<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Typoheads\Formhandler\Domain\Model\Config\FieldSetModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;
use Typoheads\Formhandler\Domain\Model\Json\JsonResponseModel;
use Typoheads\Formhandler\Utility\Utility;

class FormController extends ActionController {
  /** @var array<string, bool> */
  protected $fieldsRequired = [];

  protected FormModel $formConfig;

  public function __construct(
    protected readonly PageRepository $pageRepository
  ) {
  }

  /**
   * Show form.
   */
  public function formAction(): ResponseInterface {
    // Load form settings
    $this->formConfig = GeneralUtility::makeInstance(FormModel::class, $this->settings);

    if (!$this->formConfigValid()) {
      // TODO: Return with error
    }

    $jsonResponse = new JsonResponseModel();

    $this->formConfig->site = $this->request->getAttribute('site');
    $this->formConfig->parsedBody = (array) $this->request->getParsedBody();

    // Check if form session exists or start new if first form access
    if (!$this->formSession()) {
      // TODO: Form session is invalid reset form and return with error
    }

    $this->initInterceptors();

    if ('json' == $this->formConfig->responseType) {
      $jsonResponse->formId = $this->formConfig->formId;
      $jsonResponse->formName = $this->formConfig->formName;
      $jsonResponse->formUrl = $this->formConfig->formUrl;
      $jsonResponse->formValuesPrefix = $this->formConfig->formValuesPrefix;
      $jsonResponse->requiredFields = $this->formConfig->requiredFields;
      $jsonResponse->step = $this->formConfig->step;
    }

    if ($this->formSubmitted()) {
      $this->validators();

      if ($this->formStepValid() && !$this->formNextStep()) {
        $this->saveInterceptors();
        $this->loggers();
        if (($redirectResponse = $this->finishers()) !== null) {
          if ('json' == $this->formConfig->responseType) {
            $jsonResponse->success = true;
            $jsonResponse->redirectPage = $redirectResponse->getHeaderLine('location');
            $jsonResponse->redirectCode = $redirectResponse->getStatusCode();

            return $this->jsonResponse(json_encode($jsonResponse) ?: '{}');
          }

          return $redirectResponse;
        }
        if ('json' == $this->formConfig->responseType) {
          $jsonResponse->success = true;

          return $this->jsonResponse(json_encode($jsonResponse) ?: '{}');
        }
      }
    }

    if ('json' == $this->formConfig->responseType) {
      $steps = $this->formConfig->steps;
      GeneralUtility::makeInstance(Utility::class)::removeKeys(
        $steps,
        [
          'class',
          'restrictErrorChecks',
          'templateForm',
        ]
      );
      $jsonResponse->steps = $steps;

      return $this->jsonResponse(json_encode($jsonResponse) ?: '{}');
    }

    // Prepare output
    $this->view->assignMultiple(
      [
        'formId' => $this->formConfig->formId,
        'formName' => $this->formConfig->formName,
        'formUrl' => $this->formConfig->formUrl,
        'formValuesPrefix' => $this->formConfig->formValuesPrefix,
        'templateForm' => $this->formConfig->steps[$this->formConfig->step]->templateForm,
        'requiredFields' => $this->formConfig->requiredFields,
        'step' => $this->formConfig->step,
      ]
    );

    $this->prepareFormSets();

    foreach ($this->formConfig->steps[$this->formConfig->step]->validators as $validator) {
      foreach ($validator->fields as $field) {
        $this->prepareFieldRequired('', $field);
      }
    }

    $this->view->assignMultiple(
      [
        'fieldsRequired' => $this->fieldsRequired,
        'fieldSets' => $this->formConfig->fieldSets,
        'langFileDefault' => $this->formConfig->langFileDefault,
        'fieldsSelectOptions' => $this->formConfig->fieldsSelectOptions,
        'steps' => $this->formConfig->steps,
      ]
    );

    // TODO: Delete me, once done
    echo $this->view->render();

    // TODO: Delete me, once done
    exit;

    // TODO: Activate me, once done
    // return $this->htmlResponse();
  }

  private function finishers(): ?RedirectResponse {
    foreach ($this->formConfig->finishers as $finisher) {
      GeneralUtility::makeInstance($finisher->class)->process($this->formConfig, $finisher);
      if ($finisher->returns) {
        return $finisher->redirectResponse;
      }
    }

    return null;
  }

  private function formConfigValid(): bool {
    // TODO: Check for valid form config
    // check if template is set
    return true;
  }

  private function formNextStep(): bool {
    return count($this->formConfig->steps) > $this->formConfig->step;
  }

  private function formSession(): bool {
    // TODO: Check if form session exists or start new if first form access
    foreach ($this->formConfig->preProcessors as $preProcessor) {
      GeneralUtility::makeInstance($preProcessor->class)->process($this->formConfig, $preProcessor);
    }

    return true;
  }

  private function formStepValid(): bool {
    // TODO: Check if form step is valid
    return false;
  }

  private function formSubmitted(): bool {
    return boolval($this->formConfig->parsedBody['submitted'] ?? false);
  }

  private function initInterceptors(): void {
    foreach ($this->formConfig->initInterceptors as $initInterceptor) {
      GeneralUtility::makeInstance($initInterceptor->class)->process($this->formConfig, $initInterceptor);
    }
  }

  private function loggers(): void {
    foreach ($this->formConfig->loggers as $logger) {
      GeneralUtility::makeInstance($logger->class)->process($this->formConfig, $logger);
    }
  }

  private function prepareFieldRequired(string $fieldNamePath, FieldModel $field): void {
    $fieldNamePath .= '['.$field->name.']';
    foreach ($field->errorChecks as $errorCheck) {
      if ('Required' == $errorCheck->name) {
        $this->fieldsRequired[$fieldNamePath] = true;
      }
    }
    foreach ($field->fields as $field) {
      $this->prepareFieldRequired($fieldNamePath, $field);
    }
  }

  private function prepareFormSets(): void {
    $this->formConfig->fieldSets[] = new FieldSetModel('submitted', 'true');
    $this->formConfig->fieldSets[] = new FieldSetModel('randomId', $this->formConfig->randomId);
    $this->formConfig->fieldSets[] = new FieldSetModel('step', (string) $this->formConfig->step);
  }

  private function saveInterceptors(): void {
    foreach ($this->formConfig->saveInterceptors as $saveInterceptor) {
      GeneralUtility::makeInstance($saveInterceptor->class)->process($this->formConfig, $saveInterceptor);
    }
  }

  private function validators(): void {
    foreach ($this->formConfig->steps[$this->formConfig->step]->validators as $validator) {
      GeneralUtility::makeInstance($validator->class)->process($this->formConfig, $validator);
    }
  }
}
