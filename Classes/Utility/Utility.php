<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Utility;

use TYPO3\CMS\Core\Crypto\Random;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;

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

  public static function generateRandomId(FormModel $formConfig): string {
    return md5(
      $formConfig->formValuesPrefix.
      GeneralUtility::makeInstance(Random::class)->generateRandomBytes(10)
    );
  }

  /**
   * @param array<int|string, mixed>|bool|float|int|object|string $values
   *
   * @return array<int|string, mixed>|string
   */
  public static function recursiveHtmlSpecialChars(array|bool|float|int|object|string $values): array|string {
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
          } else {
            $value = htmlspecialchars(var_export($value, true));
          }
        }
      }
    } elseif (is_bool($values)) {
      $values = $values ? 'true' : 'false';
    } elseif (is_numeric($values) || is_string($values)) {
      $values = htmlspecialchars(strval($values));
    } else {
      $values = htmlspecialchars(var_export($values, true));
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
}
