<?php

declare(strict_types=1);

namespace Typoheads\Formhandler\Domain\Model\Config\PreProcessor;

use Typoheads\Formhandler\PreProcessor\SetSelectOptionsPreProcessor;

class SetSelectOptionsPreProcessorModel extends AbstractPreProcessorModel {
  public readonly string $field;

  /** @var array<string, string> */
  public readonly array $options;

  /**
   * @param array<string, mixed> $settings
   */
  public function __construct(array $settings) {
    $this->field = strval($settings['field'] ?? '');

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
