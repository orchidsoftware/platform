<?php

declare(strict_types=1);

namespace Orchid\Platform\Fields;

use Illuminate\Support\Str;

class Parser
{
    /**
     * Parse the data fields.
     *
     * @param $data
     *
     * @return array
     */
    public static function parseFields($data)
    {
        $data = self::explodeFields($data);
        //string parse
        foreach ($data as $name => $value) {
            $newField = collect();
            foreach ($value as $rule) {
                if (array_key_exists(0, $value)) {
                    $newField[] = self::parseStringFields($rule);
                }
            }
            $fields[$name] = $newField->collapse();
        }
        //parse array
        foreach ($data as $name => $value) {
            if (! array_key_exists(0, $value)) {
                $fields[$name] = collect($value);
            }
        }

        return $fields ?? [];
    }

    /**
     * Explode the rules into an array of rules.
     *
     * @param array $rules
     *
     * @return array
     */
    public static function explodeFields(array $rules) : array
    {
        foreach ($rules as $key => $rule) {
            if (Str::contains($key, '*')) {
                $rules->each($key, [$rule]);
                unset($rules[$key]);
                continue;
            }

            if (is_string($rule)) {
                $rules[$key] = explode('|', $rule);
            } elseif (is_object($rule)) {
                $rules[$key] = [$rule];
            } else {
                $rules[$key] = $rule;
            }
        }

        return $rules;
    }

    /**
     * @param $rules
     *
     * @return array
     */
    public static function parseStringFields(string $rules) : array
    {
        $parameters = [];
        // The format for specifying validation rules and parameters follows an
        // easy {rule}:{parameters} formatting convention. For instance the
        // rule "Max:3" states that the value may only be three letters.
        if (strpos($rules, ':') !== false) {
            list($rules, $parameter) = explode(':', $rules, 2);
            $parameters = self::parseParameters($rules, $parameter);
        }

        return [
            $rules => empty($parameters) ? true : implode(' ', $parameters),
        ];
    }

    /**
     * Parse a parameter list.
     *
     * @param string $rule
     * @param string $parameter
     *
     * @return array
     */
    public static function parseParameters(string $rule, string $parameter) : array
    {
        if (strtolower($rule) == 'regex') {
            return [$parameter];
        }

        return str_getcsv($parameter);
    }
}
