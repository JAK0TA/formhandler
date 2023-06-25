<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Utility\Utility;

class DefaultValidator extends AbstractValidator {
  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings = []) {
    $utility = GeneralUtility::makeInstance(Utility::class);
    $this->class = '\\Typoheads\\Formhandler\\Validator\\DefaultValidator';

    foreach (GeneralUtility::trimExplode(',', strval($settings['restrictErrorChecks'] ?? ''), true) as $restrictErrorCheck) {
      $this->restrictErrorChecks[] = $utility->classString($restrictErrorCheck, '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\');
    }

    if (isset($settings['disableErrorCheckFields'])) {
      if (is_string($settings['disableErrorCheckFields'])) {
        foreach (GeneralUtility::trimExplode(',', $settings['disableErrorCheckFields'], true) as $field) {
          $this->disableErrorCheckFields[strval($field)] = [];
        }
      } elseif (is_array($settings['disableErrorCheckFields'])) {
        foreach ($settings['disableErrorCheckFields'] as $field => $errorChecks) {
          if (empty($errorChecks)) {
            $this->disableErrorCheckFields[strval($field)] = [];

            continue;
          }
          foreach (GeneralUtility::trimExplode(',', $errorChecks, true) as $errorCheck) {
            $this->disableErrorCheckFields[strval($field)][] = $utility->classString($errorCheck, '\\Typoheads\\Formhandler\\Validator\\ErrorCheck\\');
          }
        }
      }
    }

    if (isset($settings['messageLimit'])) {
      if (is_int($settings['messageLimit'])) {
        $this->messageLimit = $settings['messageLimit'];
      } elseif (is_array($settings['messageLimit'])) {
        foreach ($settings['messageLimit'] as $field => $messageLimit) {
          $this->messageLimits[strval($field)] = intval($messageLimit);
        }
      }
    }

    if (isset($settings['fields']) && is_array($settings['fields'])) {
      foreach ($settings['fields'] as $fieldName => $fieldSettings) {
        /** @var Field $fieldModel */
        $fieldModel = GeneralUtility::makeInstance(Field::class, $fieldName, $this, $fieldSettings);

        $this->fields[] = $fieldModel;
      }
    }
  }
}
