<?php

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */

namespace Typoheads\Formhandler\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/**
 * Field name from path ViewHelper.
 *
 * Converts the field name path 1.group.field to field name [1][group][field].
 *
 *      $view->assign('fieldNamePath', '1.group.field');
 *
 * And in the template::
 *
 *      {fieldNamePath -> formhandler:fieldNameFromPath()}
 *
 * Which outputs::
 *
 *      [1][group][field]
 */
final class FieldNameFromPathViewHelper extends AbstractViewHelper {
  use CompileWithContentArgumentAndRenderStatic;

  /**
   * Output is escaped already. We must not escape children, to avoid double encoding.
   *
   * @var bool
   */
  protected $escapeChildren = false;

  public function initializeArguments(): void {
    $this->registerArgument(
      'fieldNamePath',
      'string',
      'Converts the field name path 1.group.field to field name [1][group][field].'
    );
  }

  /**
   * Converts the field name path 1.group.field to field name [1][group][field].
   */
  public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): string {
    return '['.implode('][', explode('.', (string) $renderChildrenClosure())).']';
  }
}
