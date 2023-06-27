<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Utility;

use TYPO3\CMS\Core\SingletonInterface;

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
