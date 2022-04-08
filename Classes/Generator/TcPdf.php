<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Generator;

/**
 * This script is part of the TYPO3 project - inspiring people to share!
 *
 * TYPO3 is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License version 2 as published by
 * the Free Software Foundation.
 *
 * This script is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General
 * Public License for more details.
 */

/**
 * PDF generator class for Formhandler using TCPDF.
 */
class TcPdf extends AbstractGenerator {
  /**
   * @return mixed
   */
  public function process(): array {
    /** @var TemplateTCPDF $pdf */
    $pdf = $this->componentManager->getComponent('\Typoheads\Formhandler\Utility\TemplateTCPDF');

    $pdf->setHeaderText($this->utilityFuncs->getSingle($this->settings, 'headerText'));
    $pdf->setFooterText($this->utilityFuncs->getSingle($this->settings, 'footerText'));

    $pdf->AddPage();
    $pdf->SetFont('Helvetica', '', 12);
    $view = $this->componentManager->getComponent('\Typoheads\Formhandler\View\PDF');
    $this->filename = false;
    if (1 === (int) ($this->settings['storeInTempFile'])) {
      $this->outputPath = $this->utilityFuncs->getDocumentRoot();
      if ($this->settings['customTempOutputPath']) {
        $this->outputPath .= $this->settings['customTempOutputPath'];
      } else {
        $this->outputPath .= '/typo3temp/';
      }
      $this->outputPath = $this->utilityFuncs->sanitizePath($this->outputPath);
      $this->filename = $this->outputPath.$this->settings['filePrefix'].$this->utilityFuncs->generateHash().'.pdf';

      $this->filenameOnly = $this->utilityFuncs->getSingle($this->settings, 'staticFileName');
      if (0 === strlen($this->filenameOnly)) {
        $this->filenameOnly = basename($this->filename);
      }
    }

    $this->formhandlerSettings = $this->globals->getSettings();
    $suffix = $this->formhandlerSettings['templateSuffix'];
    $this->template = $this->utilityFuncs->readTemplateFile('', $this->formhandlerSettings);
    if ($this->settings['templateFile']) {
      $this->template = $this->utilityFuncs->readTemplateFile('', $this->settings);
    }
    if ($suffix) {
      $view->setTemplate($this->template, 'PDF'.$suffix);
    }
    if (!$view->hasTemplate()) {
      $view->setTemplate($this->template, 'PDF');
    }
    if (!$view->hasTemplate()) {
      $this->utilityFuncs->throwException('no_pdf_template');
    }

    $view->setComponentSettings($this->settings);
    $content = $view->render($this->gp, []);

    $pdf->writeHTML($content);
    $returns = boolval($this->settings['returnFileName']);

    if (false !== $this->filename) {
      $pdf->Output($this->filename, 'F');

      $downloadpath = $this->filename;
      if ($returns) {
        return $downloadpath;
      }
      $downloadpath = str_replace($this->utilityFuncs->getDocumentRoot(), '', $downloadpath);
      header('Location: '.$downloadpath);

      exit;
    }
    $fileName = 'formhandler.pdf';
    if ($this->settings['outputFileName']) {
      $fileName = $this->utilityFuncs->getSingle($this->settings, 'outputFileName');
    }
    $pdf->Output($fileName, 'D');

    exit;
  }

  /* (non-PHPdoc)
   * @see Classes/Generator/Tx_Formhandler_AbstractGenerator#getComponentLinkParams($linkGP)
  */
  protected function getComponentLinkParams(array $linkGP): array {
    $prefix = $this->globals->getFormValuesPrefix();
    $tempParams = [
      'action' => 'pdf',
    ];
    $params = [];
    if ($prefix) {
      $params[$prefix] = $tempParams;
    } else {
      $params = $tempParams;
    }

    return $params;
  }
}
