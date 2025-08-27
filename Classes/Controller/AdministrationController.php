<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Http\PropagateResponseException;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Pagination\SimplePagination;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Pagination\QueryResultPaginator;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Typoheads\Formhandler\Domain\Model\Log;
use Typoheads\Formhandler\Domain\Repository\LogRepository;

final class AdministrationController extends ActionController {
  public function __construct(
    protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    protected readonly IconFactory $iconFactory,
    protected readonly LogRepository $logRepository,
    protected readonly PageRenderer $pageRenderer,
  ) {
    $this->pageRenderer->loadJavaScriptModule('@jakota/formhandler/Backend.js');
  }

  public function detailAction(Log $log, ?int $logPage = null, ?int $formPageId = null, ?string $ip = null, ?string $formName = null, ?string $startDate = null, ?string $endDate = null, int $itemsPerPage = 10): ResponseInterface {
    $moduleTemplate = $this->moduleTemplateFactory->create($this->request);

    $serializedArray = unserialize($log->getParams());
    // fallback. Use empty array in case the serialized data is invalid
    // TODO: add better error handling. Maybe exit & display error?
    if (!is_array($serializedArray)) {
      $serializedArray = [];
    }

    $moduleTemplate->assignMultiple([
      'log' => $log,
      'logPage' => $logPage ?? 0,
      'submittedValues' => $this->prepareFlatArray($serializedArray),
      'indexActionValues' => [
        'formPageId' => $formPageId,
        'ip' => $ip,
        'formName' => $formName,
        'startDate' => $startDate ? new \DateTime($startDate) : null,
        'endDate' => $endDate ? new \DateTime($endDate) : null,
        'itemsPerPage' => $itemsPerPage,
      ],
    ]);

    return $moduleTemplate->renderResponse('Administration/Detail');
  }

  /**
   * @param array<string> $fields
   */
  public function exportAction(?string $logDataUids = null, array $fields = [], string $fileType = ''): ResponseInterface {
    if (null !== $logDataUids && !empty($fields)) {
      $logEntries = $this->logRepository->findByUids(array_map('intval', explode(',', $logDataUids)));
      $exportReadyValueArray = [];

      /** @var Log $logDataRow */
      foreach ($logEntries as $logDataRow) {
        $fullExportArray = [];

        $flatDatasetValues = [
          'ip' => $logDataRow->getIp(),
          'form_name' => $logDataRow->getFormName(),
          'submission_date' => $logDataRow->getCrdate()->format('d.m.Y H:i:s'),
          'form_page_id' => strval($logDataRow->getFormPageId()),
          'key_hash' => $logDataRow->getKeyHash(),
          'unique_hash' => $logDataRow->getUniqueHash(),
        ];

        $serializedArray = unserialize($logDataRow->getParams());
        // fallback. Use empty array in case the serialized data is invalid
        // TODO: add better error handling. Maybe exit & display error?
        if (!is_array($serializedArray)) {
          $serializedArray = [];
        }
        $flatUnserialzedValues = $this->prepareFlatArray($serializedArray);

        foreach ($fields as $fieldToExport) {
          if (array_key_exists($fieldToExport, $flatDatasetValues)) {
            $fullExportArray[$fieldToExport] = $flatDatasetValues[$fieldToExport];
          } elseif (array_key_exists($fieldToExport, $flatUnserialzedValues)) {
            $fullExportArray[$fieldToExport] = $flatUnserialzedValues[$fieldToExport];
          } else {
            $fullExportArray[$fieldToExport] = '';
          }
        }

        $exportReadyValueArray[] = $fullExportArray;
      }

      if ('csv' === $fileType) {
        $this->arrayToCsvConvert($exportReadyValueArray, $fields);
      }
    }

    return $this->redirect('index');
  }

  public function indexAction(?int $logPage = null, ?int $formPageId = null, ?string $ip = null, ?string $formName = null, ?string $startDate = null, ?string $endDate = null, int $itemsPerPage = 10): ResponseInterface {
    /** @var QueryResultInterface<Log> */
    $logEntries = $this->logRepository->getAllEntries($formPageId, $formName, $ip, $startDate, $endDate);

    $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
    $paginator = new QueryResultPaginator($logEntries, $logPage ?? 1, $itemsPerPage);
    $pagination = new SimplePagination($paginator);

    $moduleTemplate->assignMultiple([
      'pagination' => $pagination,
      'paginator' => $paginator,
      'logPage' => $logPage ?? 1,
      'availableFormNames' => $this->prepareFormNamesForSelect($this->logRepository->getAllFormNames()),
      'defaultValues' => [
        'formPageId' => $formPageId,
        'ip' => $ip,
        'formName' => $formName,
        'startDate' => $startDate ? new \DateTime($startDate) : null,
        'endDate' => $endDate ? new \DateTime($endDate) : null,
        'itemsPerPage' => $itemsPerPage,
      ],
    ]);

    return $moduleTemplate->renderResponse('Administration/Index');
  }

  public function selectFieldsAction(?string $logDataUids = null, string $filetype = ''): ResponseInterface {
    $moduleTemplate = $this->moduleTemplateFactory->create($this->request);

    $logEntries = $this->logRepository->findByUids(array_map('intval', explode(',', $logDataUids ?? '')));
    $fieldsToShow = [
      'Global fields' => [
        'ip',
        'form_name',
        'submission_date',
        'form_page_id',
      ],
      'Custom fields' => [],
      'System fields' => [
        'key_hash',
        'unique_hash',
      ],
    ];

    foreach ($logEntries as $logDataRow) {
      $serializedArray = unserialize($logDataRow->getParams());
      // fallback. Use empty array in case the serialized data is invalid
      // TODO: add better error handling. Maybe exit & display error?
      if (!is_array($serializedArray)) {
        $serializedArray = [];
      }

      $params = $this->prepareFlatArray($serializedArray);
      $fields = array_keys($params);
      foreach ($fields as $idx => $rowField) {
        if (!in_array($rowField, $fieldsToShow['Custom fields'])) {
          $fieldsToShow['Custom fields'][] = $rowField;
        }
      }
    }

    $moduleTemplate->assignMultiple([
      'fieldsToShow' => $fieldsToShow,
      'fileType' => $filetype,
      'logDataUids' => $logDataUids,
    ]);

    return $moduleTemplate->renderResponse('Administration/SelectFields');
  }

  /**
   * @param array<int, array<string, string>> $array
   * @param array<string>                     $headers
   */
  protected function arrayToCsvConvert(array $array, array $headers, string $filename = 'export.csv', string $delimiter = ','): void {
    if (count($array) < 1 || count($array[0]) !== count($headers)) {
      return;
    }

    $csvFile = fopen('php://memory', 'w');
    if ($csvFile) {
      fputcsv($csvFile, $headers, $delimiter);
      foreach ($array as $line) {
        // remove linebreaks
        $line = array_map(function ($field) {
          return str_replace(["\r", "\n"], '', $field);
        }, $line);

        fputcsv($csvFile, $line, $delimiter);
      }

      fseek($csvFile, 0);
      header('Content-Type: text/csv');
      header('Content-Disposition: attachment; filename="'.$filename.'";');
      fpassthru($csvFile);
    }

    $response = $this->responseFactory->createResponse(200);

    throw new PropagateResponseException($response);
  }

  /**
   * TODO: add ability to map language files to forms. Fieldkeys like 1.customer.email should get changed to their translation.
   *
   * @param array<mixed> $formValues
   *
   * @return array<string, string>
   */
  protected function prepareFlatArray(array $formValues, string $passedName = ''): array {
    $returnArray = [];
    foreach ($formValues as $formValueKey => $formValueEntry) {
      if (is_array($formValueEntry)) {
        $returnArray = array_merge($this->prepareFlatArray($formValueEntry, $passedName.strval($formValueKey).'.'), $returnArray);
      } else {
        $returnArray[$passedName.$formValueKey] = strval($formValueEntry);
      }
    }

    return $returnArray;
  }

  /**
   * @param array<mixed, mixed> $formNames
   *
   * @return array<mixed>
   */
  protected function prepareFormNamesForSelect(array $formNames): array {
    $returnArray = ['' => null];

    foreach ($formNames as $formName) {
      $returnArray[$formName] = $formName;
    }

    return $returnArray;
  }
}
