<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Typoheads\Formhandler\Definitions\FormhandlerExtensionConfig;
use Typoheads\Formhandler\Domain\Model\Config\FieldSetModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;
use Typoheads\Formhandler\Domain\Model\Json\JsonResponseModel;
use Typoheads\Formhandler\Session\Typo3Session;
use Typoheads\Formhandler\Utility\Utility;

class FormController extends ActionController {
  /** @var array<string, bool> */
  protected $fieldsRequired = [];

  protected FormModel $formConfig;

  protected JsonResponseModel $jsonResponse;

  /** @var array<string, mixed> */
  protected array $parsedBody;

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

    $this->formConfig->site = $this->request->getAttribute('site');
    $this->parsedBody = (array) $this->request->getParsedBody();
    $queryParams = (array) $this->request->getQueryParams();

    if (is_array($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY] ?? false)) {
      if (isset($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['randomId'])) {
        $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['randomId'] = strval($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['randomId']);
      }
      if (isset($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['step'])) {
        $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['step'] = intval($queryParams[FormhandlerExtensionConfig::EXTENSION_KEY]['step']);
      }
    }

    if (is_array($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY] ?? false)) {
      $this->formConfig->randomId = strval($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['randomId'] ?? '');
    }

    // Check if form session exists or start new if first form access
    $this->formSession();

    $this->mergeParsedBodyWithSession();

    $this->initInterceptors();

    $this->initJsonResponse();

    if ($this->formSubmitted()) {
      $this->validators();

      if (!$this->formStepIsValid()) {
        // TODO: Prepare error output
      }

      $this->formStepChange();

      if ($this->formStepIsLast()) {
        $this->saveInterceptors();
        $this->loggers();
        if (($redirectResponse = $this->finishers()) !== null) {
          if ('json' == $this->formConfig->responseType) {
            $this->jsonResponse->success = true;
            $this->jsonResponse->redirectPage = $redirectResponse->getHeaderLine('location');
            $this->jsonResponse->redirectCode = $redirectResponse->getStatusCode();

            return $this->jsonResponse(json_encode($this->jsonResponse) ?: '{}');
          }

          return $redirectResponse;
        }
        if ('json' == $this->formConfig->responseType) {
          $this->jsonResponse->success = true;

          return $this->jsonResponse(json_encode($this->jsonResponse) ?: '{}');
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
      $this->jsonResponse->steps = $steps;

      $this->formConfig->processDebugLog();

      return $this->jsonResponse(json_encode($this->jsonResponse) ?: '{}');
    }

    $this->prepareFormSets();

    foreach ($this->formConfig->steps[$this->formConfig->step]->validators as $validator) {
      foreach ($validator->fields as $field) {
        $this->prepareFieldRequired('', $field);
      }
    }

    $this->formConfig->processDebugLog();

    // Prepare output
    $this->view->assignMultiple(
      [
        'fieldsRequired' => $this->fieldsRequired,
        'fieldsSelectOptions' => $this->formConfig->fieldsSelectOptions,
        'fieldSets' => $this->formConfig->fieldSets,
        'formId' => $this->formConfig->formId,
        'formName' => $this->formConfig->formName,
        'formUrl' => $this->formConfig->formUrl,
        'formValuesPrefix' => $this->formConfig->formValuesPrefix,
        'requiredFields' => $this->formConfig->requiredFields,
        'langFileDefault' => $this->formConfig->langFileDefault,
        'step' => $this->formConfig->step,
        'steps' => $this->formConfig->steps,
        'templateForm' => $this->formConfig->steps[$this->formConfig->step]->templateForm,
        'formValues' => $this->formConfig->formValues ?? [],
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

  private function formSession(): void {
    $firstStart = false;
    if (empty($this->formConfig->randomId)) {
      $firstStart = true;
      $this->formConfig->randomId = GeneralUtility::makeInstance(Utility::class)::generateRandomId($this->formConfig);
    }
    $this->formConfig->debugMessage(
      key: 'Session first start',
      data: $firstStart,
    );

    $this->formConfig->session = GeneralUtility::makeInstance(Typo3Session::class)
      ->init($this->formConfig)
      ->start($this->formConfig->randomId)
    ;

    if ($this->formConfig->session->exists()) {
      $fieldsSelectOptions = $this->formConfig->session->get('fieldsSelectOptions');
      if (is_array($fieldsSelectOptions)) {
        $this->formConfig->fieldsSelectOptions = $fieldsSelectOptions;
      }
      $this->formConfig->step = intval($this->formConfig->session->get('step') ?: 1);
      $this->formConfig->formValues = (array) ($this->formConfig->session->get('formValues') ?: []);
    } else {
      // Form session is invalid or first form access reset form
      if (!$firstStart) {
        // Form session is invalid create new one
        $randomId = GeneralUtility::makeInstance(Utility::class)::generateRandomId($this->formConfig);
        $this->formConfig->session->reset()->start($randomId);
        $this->formConfig->randomId = $randomId;
      }

      $this->formConfig->step = 1;
      $this->formConfig->formValues = [];

      $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY] = [];
      $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['submitted'] = false;
      $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['randomId'] = $this->formConfig->randomId;
      $this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['step'] = $this->formConfig->step;
      $this->parsedBody[$this->formConfig->formValuesPrefix] = $this->formConfig->formValues;

      // Execute PreProcessor
      foreach ($this->formConfig->preProcessors as $preProcessor) {
        GeneralUtility::makeInstance($preProcessor->class)->process($this->formConfig, $preProcessor);
      }

      $this->formConfig->session->setMultiple(
        [
          'fieldsSelectOptions' => $this->formConfig->fieldsSelectOptions,
          'formValues' => $this->formConfig->formValues,
          'step' => $this->formConfig->step,
        ]
      );
    }
  }

  private function formStepChange(): void {
    if (isset($this->parsedBody[$this->formConfig->formValuesPrefix]['step']['prev'])) {
      $this->formConfig->step = $this->formConfig->step > 1 ? $this->formConfig->step - 1 : 1;
    } else {
      $this->formConfig->step = !$this->formStepIsLast() ? $this->formConfig->step + 1 : $this->formConfig->step;
    }
  }

  private function formStepIsLast(): bool {
    return count($this->formConfig->steps) == $this->formConfig->step;
  }

  private function formStepIsValid(): bool {
    // TODO: Check if form step is valid
    return false;
  }

  private function formSubmitted(): bool {
    if (is_array($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY] ?? false)) {
      return boolval($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['submitted'] ?? false);
    }

    return false;
  }

  private function initInterceptors(): void {
    foreach ($this->formConfig->initInterceptors as $initInterceptor) {
      GeneralUtility::makeInstance($initInterceptor->class)->process($this->formConfig, $initInterceptor);
    }
  }

  private function initJsonResponse(): void {
    if ('json' == $this->formConfig->responseType) {
      $this->jsonResponse = new JsonResponseModel();
      $this->jsonResponse->formId = $this->formConfig->formId;
      $this->jsonResponse->formName = $this->formConfig->formName;
      $this->jsonResponse->formUrl = $this->formConfig->formUrl;
      $this->jsonResponse->formValuesPrefix = $this->formConfig->formValuesPrefix;
      $this->jsonResponse->requiredFields = $this->formConfig->requiredFields;
      $this->jsonResponse->step = $this->formConfig->step;
    }
  }

  private function loggers(): void {
    foreach ($this->formConfig->loggers as $logger) {
      GeneralUtility::makeInstance($logger->class)->process($this->formConfig, $logger);
    }
  }

  private function mergeParsedBodyWithSession(): void {
    if (!is_array($this->parsedBody[$this->formConfig->formValuesPrefix] ?? false)) {
      return;
    }

    $reference_function = function ($fieldName, &$fields) use (&$reference_function) {
      foreach ($fields as $field => $value) {
        if (is_array($value)) {
          $fieldName .= '['.$field.']';
          $reference_function($fieldName, $value);
        } else {
          $this->formConfig->formValues[$fieldName.'['.$field.']'] = $value;
        }
      }
    };

    $reference_function('['.$this->formConfig->step.']', $this->parsedBody[$this->formConfig->formValuesPrefix][$this->formConfig->step]);
    $this->formConfig->session->set('formValues', $this->formConfig->formValues);

    $this->formConfig->debugMessage(
      key: 'Merge parsedBody with Session',
      data: $this->formConfig->formValues,
    );

    // TODO: Add check if step number is valid
    $this->formConfig->step = intval($this->parsedBody[FormhandlerExtensionConfig::EXTENSION_KEY]['step'] ?? 1);
    $this->formConfig->session->set('step', $this->formConfig->step);

    $this->formConfig->debugMessage(
      key: 'Step number in Session',
      data: $this->formConfig->step,
    );
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
