<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\PreProcessor;

use Typoheads\Formhandler\PreProcessor\SetSelectOptionsPreProcessor;

/** Documentation:Start:PreProcessors/SetSelectOptionsPreProcessor.rst.
 *
 *.. _setselectoptionspreprocessor:
 *
 *============================
 *SetSelectOptionsPreProcessor
 *============================
 *
 *Sets a named Options array for select boxes.
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **TypoScript Path**
 *     - plugin.tx_formhandler_form.settings.predefinedForms.[x].preProcessors
 *
 *..  code-block:: typoscript
 *
 *    Example Code:
 *
 *    preProcessors {
 *      setSalutations {
 *        model = SetSelectOptionsPreProcessorModel
 *        config {
 *          name = salutation
 *          options {
 *            mr {
 *              value = mr
 *              title = Mr.
 *            }
 *            mrs {
 *              value = mrs
 *              title = Mrs.
 *            }
 *          }
 *        }
 *      }
 *      setCountry {
 *        model = SetSelectOptionsPreProcessorModel
 *        config {
 *          name = country
 *          options {
 *            DE {
 *              value = DE
 *              title = Germany
 *            }
 *            USA {
 *              value = USA
 *              title = United States of America
 *            }
 *          }
 *        }
 *      }
 *    }
 *
 ***Properties**
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **name**
 *     - Set a name for this key value array
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - String
 *   * - *Note*
 *     - Must be unique
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **options**
 *     - Option array for the select box options
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - Array<String, `Option <option-label_>`__>
 *
 *Option
 *======
 *
 *.. _option-label:
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **value**
 *     - The value for the select box option.
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - String
 *
 *.. list-table::
 *   :align: left
 *   :width: 100%
 *   :widths: 20 80
 *   :header-rows: 0
 *   :stub-columns: 0
 *
 *   * - **title**
 *     - The title for the select box option
 *   * -
 *     -
 *   * - *Mandatory*
 *     - True
 *   * - *Data Type*
 *     - String
 *
 *Documentation:End
 */
class SetSelectOptionsPreProcessorModel extends AbstractPreProcessorModel {
  public readonly string $name;

  /** @var array<string, string> */
  public readonly array $options;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->name = strval($settings['name'] ?? '');

    if (!is_array($settings['options'] ?? false)) {
      $this->options = [];

      return;
    }

    $options = [];
    foreach ($settings['options'] as $option) {
      if (!isset($option['title'],$option['value'])) {
        continue;
      }
      $options[strval($option['value'])] = strval($option['title']);
    }

    // TODO: remove ignore once fixed: https://github.com/phpstan/phpstan/issues/6402
    // @phpstan-ignore-next-line
    $this->options = $options;
  }

  public function class(): string {
    return SetSelectOptionsPreProcessor::class;
  }
}
