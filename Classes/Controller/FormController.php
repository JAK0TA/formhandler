<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Typoheads\Formhandler\Domain\Model\Config\FieldSet;
use Typoheads\Formhandler\Domain\Model\Config\Form;
use Typoheads\Formhandler\Utility\Utility;

class FormController extends ActionController {
  protected Form $formConfig;

  public function __construct(
    protected readonly PageRepository $pageRepository
  ) {
  }

  /**
   * Show form.
   */
  public function formAction(): ResponseInterface {
    // Load form settings
    $this->formConfig = GeneralUtility::makeInstance(Form::class, $this->settings);

    if (!$this->formConfigValid()) {
      // TODO: Return with error
    }

    // Check if form session exists or start new if first form access
    if (!$this->formSession()) {
      // TODO: Form session is invalid reset form and return with error
    }

    if ($this->formSubmitted()) {
      // TODO: Execute Validator

      if ($this->formStepValid() && !$this->formNextStep()) {
        // TODO: Execute saveInterceptors
        // TODO: Execute Logger
        // TODO: Execute Finisher

        // TODO: Return Success and exit
      }
    }

    // TODO: Execute initInterceptors

    // Prepare output
    $this->view->assignMultiple(
      [
        'formId' => $this->formConfig->formId,
        'formName' => $this->formConfig->formName,
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

    $this->formSets();

    return $this->htmlResponse();
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
    // TODO: Execute preprocessor if first form access

    return true;
  }

  private function formSets(): void {
    $this->formConfig->fieldSets[] = new FieldSet('submitted', 'true');
    $this->formConfig->fieldSets[] = new FieldSet('randomId', $this->formConfig->randomId);
    $this->formConfig->fieldSets[] = new FieldSet('step', (string) $this->formConfig->step);
  }

  private function formStepValid(): bool {
    // TODO: Check if form step is valid
    return false;
  }

  private function formSubmitted(): bool {
    // TODO: Check if form Submitted
    return false;
  }
}
