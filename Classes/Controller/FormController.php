<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Typoheads\Formhandler\Domain\Model\Config\Form;

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

    if ('json' == $this->formConfig->responseType) {
      $jsonOutput = json_encode($this->formConfig) ?: null;

      return $this->jsonResponse($jsonOutput);
    }

    $this->view->assignMultiple(
      [
      ]
    );

    return $this->htmlResponse();
  }
}
