<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Definitions;

enum Severity: int {
  case Error = 3;

  case Info = 1;

  case Warning = 2;
}
