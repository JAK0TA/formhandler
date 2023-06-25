<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Utility;

class Utility {
  public static function classString(string $class, string $prefix): string {
    if (empty($class)) {
      return '';
    }

    if ('\\' == $class[0]) {
      return substr($class, 1);
    }

    return $prefix.$class;
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
