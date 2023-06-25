<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
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
    $this->formConfig = GeneralUtility::makeInstance(Form::class, $this->settings);

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

    return $this->htmlResponse();
  }
}
