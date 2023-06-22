<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Controller;

use Psr\Http\Message\ResponseInterface;
use TYPO3\CMS\Backend\Attribute\Controller;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

#[Controller]
final class AdministrationController extends ActionController {
  public function __construct(
    protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    protected readonly IconFactory $iconFactory,
  ) {
  }

  public function indexAction(): ResponseInterface {
    $moduleTemplate = $this->moduleTemplateFactory->create($this->request);
    $moduleTemplate->assignMultiple([
      'title' => $this->request->getAttribute('site')?->getConfiguration()['websiteTitle'] ?? '',
    ]);

    return $moduleTemplate->renderResponse('Administration/Index');
  }
}
