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
use TYPO3\CMS\Backend\Attribute\Controller;
use TYPO3\CMS\Backend\Template\ModuleTemplateFactory;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use Typoheads\Formhandler\Domain\Repository\LogRepository;

#[Controller]
final class AdministrationController extends ActionController {
  public function __construct(
    protected readonly ModuleTemplateFactory $moduleTemplateFactory,
    protected readonly IconFactory $iconFactory,
    protected readonly LogRepository $logRepository,
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
