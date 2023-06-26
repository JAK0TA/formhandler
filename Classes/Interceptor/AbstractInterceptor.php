<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Interceptor;

use TYPO3\CMS\Core\SingletonInterface;
use Typoheads\Formhandler\Domain\Model\Config\FormModel;
use Typoheads\Formhandler\Domain\Model\Config\Interceptor\AbstractInterceptorModel;

abstract class AbstractInterceptor implements SingletonInterface {
  abstract public function process(FormModel &$formConfig, AbstractInterceptorModel $interceptorConfig): void;
}
