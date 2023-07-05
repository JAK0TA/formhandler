<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Debugger;

use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use Typoheads\Formhandler\Domain\Model\Config\Debugger\PrintToScreenDebuggerModel;

/**
 * A simple debugger printing the messages on the screen.
 */
class PrintToScreenDebugger extends AbstractDebugger {
  public function processDebugLog(
    array $debugLog,
  ): ?string {
    if (!$this->debuggerConfig instanceof PrintToScreenDebuggerModel) {
      return null;
    }
    if (!$this->debuggerConfig->active || 'html' != $this->formConfig->responseType) {
      return null;
    }

    $debugOutput = '';

    foreach ($debugLog as $section => $logData) {
      $debugOutput .= str_replace('|', $section, $this->debuggerConfig->sectionHeaderWrap);
      $sectionContent = '';
      foreach ($logData as $messageData) {
        $message = str_replace("\n", '<br />', $messageData['message']);
        $message = str_replace('|', $message, $this->debuggerConfig->severityWrap[$messageData['severity']]);

        $sectionContent .= str_replace('|', $message, $this->debuggerConfig->messageWrap);

        if ($messageData['data']) {
          $sectionContent .= trim(DebuggerUtility::var_dump($messageData['data'], '', $this->debuggerConfig->maxDepth, false, false, true));
          $sectionContent .= '<br />';
        }
      }
      $debugOutput .= str_replace('|', $sectionContent, $this->debuggerConfig->sectionWrap);
    }

    return $debugOutput;
  }
}
