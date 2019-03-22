<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Fields;

use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Field;
use Orchid\Tests\TestUnitCase;

/**
 * Class TestFieldsUnitCase
 */
class TestFieldsUnitCase extends TestUnitCase
{

  /**
   * @param \Orchid\Screen\Field $field
   *
   * @param array                $data
   * @param array                $rules
   * @param array                $messages
   * @param array                $customAttributes
   *
   * @return string
   * @throws \Throwable
   */
  public static function renderField(Field $field, array $data = [], array $rules = [], array $messages = [], array $customAttributes = []): string
  {
    $validator = Validator::make($data, $rules, $messages, $customAttributes);

    return $field->render()->withErrors($validator)->render();
  }
}