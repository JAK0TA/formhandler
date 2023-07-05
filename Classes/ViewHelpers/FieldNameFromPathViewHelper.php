<?php

/*
 * This file is part of TYPO3 CMS-based extension "Formhandler" by JAKOTA.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 */

namespace Typoheads\Formhandler\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

/** Documentation:Start:TocTree:ViewHelpers/Index.rst.
 *
 *.. _viewhelpers:
 *
 *============
 *View Helpers
 *============
 *
 *:ref:`FieldNameFromPathViewHelper`
 *  Converts the field name path 1.group.field to field name [1][group][field].
 *
 *.. toctree::
 *   :maxdepth: 2
 *   :hidden:
 *
 *   FieldNameFromPathViewHelper
 *
 *Documentation:End
 */
/** Documentation:Start:ViewHelpers/FieldNameFromPathViewHelper.rst.
 *
 *.. _fieldnamefrompathviewhelper:
 *
 *===========================
 *FieldNameFromPathViewHelper
 *===========================
 *
 *Converts the field name path 1.group.field to field name [1][group][field].
 *
 *..  code-block:: php
 *
 *    Example Code:
 *
 *    $view->assign('fieldNamePath', '1.group.field');
 *
 *And in the template:
 *
 *..  code-block:: typoscript
 *
 *    {fieldNamePath -> formhandler:fieldNameFromPath()}
 *
 *Which returns:
 *
 *..  code-block:: text
 *
 *    [1][group][field]
 *
 *Documentation:End
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
