<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Typoheads\Formhandler\Domain\Model\Config\FieldSetModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;
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

    $this->formConfig->parsedBody = (array) $this->request->getParsedBody();

    // Check if form session exists or start new if first form access
    if (!$this->formSession()) {
      // TODO: Form session is invalid reset form and return with error
    }

    if ($this->formSubmitted()) {
      // TODO: Execute Validator

      if ($this->formStepValid() && !$this->formNextStep()) {
        $this->saveInterceptors();
        // TODO: Execute Logger
        // TODO: Execute Finisher

        // TODO: Return Success and exit
      }
    }

    $this->initInterceptors();

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

      $this->view->assign(
        'steps',
        $steps,
      );

      return $this->jsonResponse();
    }

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
    // TODO: Check if form Submitted
    return false;
  }

  private function initInterceptors(): void {
    foreach ($this->formConfig->initInterceptors as $initInterceptor) {
      GeneralUtility::makeInstance($initInterceptor->class)->process($this->formConfig, $initInterceptor);
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
}
