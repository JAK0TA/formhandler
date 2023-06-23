<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Core\Domain\Repository\PageRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class FormController extends ActionController {
  public function __construct(
    protected readonly PageRepository $pageRepository
  ) {
  }

  /**
   * Show form.
   */
  public function formAction(): ResponseInterface {
    $this->view->assignMultiple(
      [
      ]
    );

    return $this->htmlResponse();
  }

  /**
   * Initialize redirects.
   */
  public function initializeAction(): void {
  }
}
