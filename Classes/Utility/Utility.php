<?php

declare(strict_types=1);

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\Utility;

use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\DNSCheckValidation;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use TYPO3\CMS\Core\Crypto\Random;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\GeneralOptions\ConditionBlockModel;

class Utility implements SingletonInterface {
  /**
   * @return class-string
   */
  public static function classString(string $class, string $prefix) {
    /** @var class-string $classString */
    $classString = '';

    if (empty($class)) {
      return $classString;
    }

    if ('\\' == $class[0]) {
      /** @var class-string $classString */
      $classString = substr($class, 1);
    } else {
      /** @var class-string $classString */
      $classString = $prefix.$class;
    }

    return $classString;
  }

  public static function conditionEvaluate(ConditionBlockModel $conditionBlock, FormModel $formConfig): bool {
    foreach ($conditionBlock->conditions as $andConditions) {
      if (!is_array($andConditions ?? false)) {
        return false;
      }

      $andEvaluation = true;
      foreach ($andConditions as $andCondition) {
        if (!self::conditionResult(strval($andCondition), $formConfig)) {
          $andEvaluation = false;

          break;
        }
      }

      if ($andEvaluation) {
        return true;
      }
    }

    return false;
  }

  public static function conditionResult(string $condition, FormModel $formConfig): bool {
    $conditionResult = false;
    $valueConditions = preg_split('/\s*(!=|\^=|\$=|~=|>=|<=|=|<|>)\s*/', $condition, -1, PREG_SPLIT_DELIM_CAPTURE);
    if (is_bool($valueConditions)) {
      return $conditionResult;
    }

    $conditionOperator = trim($valueConditions[1] ?? '');
    $conditionValue = $valueConditions[2];
    $fieldName = trim($valueConditions[0]);
    $fieldPath = explode('.', $fieldName) ?: [];
    if (empty($fieldPath)) {
      return false;
    }
    $fieldValue = self::getFieldValue($fieldPath, $formConfig->formValues);

    switch ($conditionOperator) {
      case '!=':
        $conditionResult = $fieldValue != $conditionValue;

        break;

      case '^=':
        $conditionResult = 0 === strpos(strval($fieldValue), $conditionValue);

        break;

      case '$=':
        $conditionResult = (0 === strcmp($conditionValue, substr(strval($fieldValue), -strlen($conditionValue))));

        break;

      case '~=':
        if (is_array($fieldValue)) {
          $conditionResult = in_array($conditionValue, $fieldValue);
        } else {
          $conditionResult = false !== strpos(strval($fieldValue), $conditionValue);
        }

        break;

      case '=':
        $conditionResult = $conditionValue == $fieldValue;

        break;

      case '>':
        if (is_numeric($fieldValue)) {
          $conditionResult = (float) $fieldValue > (float) $conditionValue;
        }

        break;

      case '<':
        if (is_numeric($fieldValue)) {
          $conditionResult = (float) $fieldValue < (float) $conditionValue;
        }

        break;

      case '>=':
        if (is_numeric($fieldValue)) {
          $conditionResult = (float) $fieldValue >= (float) $conditionValue;
        }

        break;

      case '<=':
        if (is_numeric($fieldValue)) {
          $conditionResult = (float) $fieldValue <= (float) $conditionValue;
        }

        break;

      default:
        if (is_array($fieldValue)) {
          $conditionResult = (count($fieldValue) > 0);
        } else {
          $conditionResult = strlen(trim(strval($fieldValue))) > 0;
        }
    }

    return $conditionResult;
  }

  /**
   * Performs search and replace settings defined in TypoScript.
   *
   * @param FormModel $formConfig The form config
   * @param string    $fileName   The file name
   *
   * @return string The replaced file name
   */
  public static function doFileNameReplace(FormModel $formConfig, string $fileName): string {
    if ($formConfig->fileUpload->nameCleanUpUsePregReplace) {
      $fileName = preg_replace($formConfig->fileUpload->nameCleanUpSearch, $formConfig->fileUpload->nameCleanUpReplace, $fileName);
    } else {
      $fileName = str_replace($formConfig->fileUpload->nameCleanUpSearch, $formConfig->fileUpload->nameCleanUpReplace, $fileName);
    }

    return $fileName ?? '';
  }

  public static function generateRandomId(FormModel $formConfig): string {
    return md5(
      $formConfig->formValuesPrefix.
      GeneralUtility::makeInstance(Random::class)->generateRandomBytes(10)
    );
  }

  /**
   * @param string[] $fieldPath
   * @param mixed[]  $formValues
   *
   * @return mixed[]|string
   */
  public static function getFieldValue(array $fieldPath, array $formValues): array|string {
    $fieldKey = current($fieldPath);
    if (is_array($formValues[$fieldKey] ?? false)) {
      array_shift($fieldPath);
      if (empty($fieldPath)) {
        return $formValues[$fieldKey];
      }

      return self::getFieldValue($fieldPath, $formValues[$fieldKey]);
    }

    return $formValues[$fieldKey] ?? '';
  }

  public static function prepareAndWhereString(string $andWhere): string {
    $andWhere = trim($andWhere);
    if (str_starts_with($andWhere, 'and ') || str_starts_with($andWhere, 'AND ')) {
      $andWhere = trim(substr($andWhere, 3));
    }
    if (strlen($andWhere) > 0) {
      $andWhere = ' AND '.$andWhere;
    }

    return $andWhere;
  }

  /**
   * @param array<int|string, mixed>|bool|float|int|object|string $values
   *
   * @return array<int|string, mixed>|object|string
   */
  public static function recursiveHtmlSpecialChars(array|bool|float|int|object|string $values): array|object|string {
    if (is_array($values)) {
      if (empty($values)) {
        $values = '';
      } else {
        foreach ($values as &$value) {
          if (is_array($value)) {
            $value = self::recursiveHtmlSpecialChars($value);
          } elseif (is_bool($value)) {
            $value = $value ? 'true' : 'false';
          } elseif (is_numeric($value) || is_string($value)) {
            $value = htmlspecialchars(strval($value));
          }
        }
      }
    } elseif (is_bool($values)) {
      $values = $values ? 'true' : 'false';
    } elseif (is_numeric($values) || is_string($values)) {
      $values = htmlspecialchars(strval($values));
    }

    return $values;
  }

  /**
   * @param array<int|string, mixed> $array
   * @param array<int, int|string>   $removeKeys
   */
  public static function removeKeys(array &$array, array $removeKeys = []): void {
    foreach ($removeKeys as $removeKey) {
      unset($array[$removeKey]);
    }
    foreach ($array as $key => &$value) {
      if (is_object($value)) {
        foreach ($removeKeys as $removeKey) {
          unset($value->{$removeKey});
        }
        // @phpstan-ignore-next-line
        foreach ($value as &$property) {
          if (is_array($property)) {
            self::removeKeys($property, $removeKeys);
          }
        }
      } elseif (is_array($value)) {
        self::removeKeys($value, $removeKeys);
      }
    }
  }

  /**
   * Checking syntax of input email address.
   */
  public static function validEmail(string $email): bool {
    // Early return in case input is not a string
    if (!is_string($email)) {
      return false;
    }
    if (trim($email) !== $email) {
      return false;
    }
    if (!str_contains($email, '@')) {
      return false;
    }

    $validator = new EmailValidator();
    $multipleValidations = new MultipleValidationWithAnd(
      [
        new RFCValidation(),
        new DNSCheckValidation(),
      ],
      MultipleValidationWithAnd::STOP_ON_ERROR
    );

    $validator->isValid($email, $multipleValidations);

    return $validator->isValid($email, $multipleValidations);
  }
}
