<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\Validator;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\Validator\Field\FieldModel;
use Typoheads\Formhandler\Utility\Utility;
use Typoheads\Formhandler\Validator\DefaultValidator;

class DefaultValidatorModel extends AbstractValidatorModel {
  public readonly int $messageLimit;

  /** @var array<string, int> */
  public readonly array $messageLimits;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $utility = GeneralUtility::makeInstance(Utility::class);

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

    $this->messageLimit = intval($settings['messageLimit'] ?? 1);

    if (isset($settings['messageLimits']) && is_array($settings['messageLimits'])) {
      $messageLimits = [];
      foreach ($settings['messageLimits'] as $field => $messageLimit) {
        $messageLimits[strval($field)] = intval($messageLimit ?? 1);
      }
      $this->messageLimits = $messageLimits;
    } else {
      // TODO: remove ignore once fixed: https://github.com/phpstan/phpstan/issues/6402
      // @phpstan-ignore-next-line
      $this->messageLimits = [];
    }

    if (isset($settings['fields']) && is_array($settings['fields'])) {
      foreach ($settings['fields'] as $fieldName => $fieldSettings) {
        /** @var FieldModel $fieldModel */
        $fieldModel = GeneralUtility::makeInstance(FieldModel::class, $fieldName, $this, $fieldSettings);

        $this->fields[] = $fieldModel;
      }
    }
  }

  public function class(): string {
    return DefaultValidator::class;
  }
}
