<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\PreProcessor;

use Typoheads\Formhandler\PreProcessor\SetSelectOptionsPreProcessor;

class SetSelectOptionsPreProcessorModel extends AbstractPreProcessorModel {
  public string $field = '';

  /** @var array<string, string> */
  public array $options = [];

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->class = SetSelectOptionsPreProcessor::class;

    $this->field = strval($settings['field'] ?? '');

    if (!is_array($settings['options'] ?? false)) {
      return;
    }

    // Get form logger
    foreach ($settings['options'] as $option) {
      if (!isset($option['title'],$option['value'])) {
        continue;
      }
      $this->options[strval($option['value'])] = strval($option['title']);
    }
  }
}
