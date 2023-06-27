<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Finisher;

use TYPO3\CMS\Core\Http\RedirectResponse;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\AbstractFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\Finisher\RedirectFinisherModel;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;

class RedirectFinisher extends AbstractFinisher {
  public function process(FormModel &$formConfig, AbstractFinisherModel &$finisherConfig): void {
    if (!$finisherConfig instanceof RedirectFinisherModel || null === $formConfig->site) {
      return;
    }

    if (!empty($finisherConfig->additionalParams)) {
      foreach ($finisherConfig->additionalParams as &$valueOrFieldName) {
        // TODO: Lookup valueOrFieldName in field names (and markers???) and replace it with value if found.
      }
    }

    $uri = $formConfig->site->getRouter()->generateUri(
      $formConfig->redirectPage,
      $finisherConfig->additionalParams,
    )->withFragment('c0')->__toString();

    if (!empty($finisherConfig->correctRedirectUrl)) {
      // TODO: Check if still needed
      $uri = str_replace('&amp;', '&', $uri);
    }

    $finisherConfig->redirectResponse = new RedirectResponse(
      (string) GeneralUtility::locationHeaderUrl($uri),
      $finisherConfig->headerStatusCode
    );
  }
}
