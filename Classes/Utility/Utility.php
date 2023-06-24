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
}
