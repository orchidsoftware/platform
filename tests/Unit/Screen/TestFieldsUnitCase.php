<?php

declare(strict_types=1);

namespace Orchid\Tests\Unit\Screen;

use Illuminate\Support\Facades\Validator;
use Orchid\Screen\Field;
use Orchid\Tests\TestUnitCase;

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
     * @return string
     */
    public static function renderField(Field $field, array $data = [], array $rules = [], array $messages = [], array $customAttributes = []): string
    {
        try {
            $validator = Validator::make($data, $rules, $messages, $customAttributes);

            return $field->render()->withErrors($validator)->render();
        } catch (\Throwable $throwable) {
            die($throwable->getMessage());
        }
    }

    /**
     * @param string $view
     *
     * @return string|string[]|null
     */
    public static function minifyOutput(string $view)
    {
        $search = [
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/', // Remove HTML comments
            '/" >/',
        ];

        $replace = [
            '>',
            '<',
            '\\1',
            '',
            '">',
        ];

        return preg_replace($search, $replace, $view);
    }

    /**
     * @param \Orchid\Screen\Field $field
     * @param array                $data
     * @param array                $rules
     * @param array                $messages
     * @param array                $customAttributes
     *
     * @return string
     */
    public static function minifyRenderField(Field $field, array $data = [], array $rules = [], array $messages = [], array $customAttributes = []): string
    {
        $view = self::renderField($field, $data, $rules, $messages, $customAttributes);

        return self::minifyOutput($view);
    }
}
