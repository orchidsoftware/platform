<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Fields;

use Orchid\Screen\Field;
use Orchid\Tests\TestUnitCase;
use Illuminate\Support\Facades\Validator;

/**
 * Class TestFieldsUnitCase.
 */
class TestFieldsUnitCase extends TestUnitCase
{
    /**
     * @param \Orchid\Screen\Field $field
     * @param array                $data
     * @param array                $rules
     * @param array                $messages
     * @param array                $customAttributes
     *
     * @throws \Throwable
     *
     * @return string
     */
    public static function renderField(Field $field, array $data = [], array $rules = [], array $messages = [], array $customAttributes = []): string
    {
        $validator = Validator::make($data, $rules, $messages, $customAttributes);

        return $field->render()->withErrors($validator)->render();
    }
}
