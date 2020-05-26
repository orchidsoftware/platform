<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Orchid\Screen\Field;
use Orchid\Support\Assert;
use Orchid\Support\CryptArray;

/**
 * Class Relation.
 *
 * @method Relation accesskey($value = true)
 * @method Relation autofocus($value = true)
 * @method Relation disabled($value = true)
 * @method Relation form($value = true)
 * @method Relation name(string $value = null)
 * @method Relation required(bool $value = true)
 * @method Relation size($value = true)
 * @method Relation tabindex($value = true)
 * @method Relation help(string $value = null)
 * @method Relation placeholder(string $placeholder = null)
 * @method Relation popover(string $value = null)
 * @method Relation title(string $value = null)
 */
class Relation extends Field
{
    /**
     * @var string
     */
    protected $view = 'platform::fields.relation';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'          => 'form-control',
        'value'          => [],
        'relationScope'  => null,
        'relationAppend' => null,
    ];

    /**
     * @var array
     */
    protected $required = [
        'name',
        'relationModel',
        'relationName',
        'relationKey',
        'relationScope',
        'relationAppend',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'accesskey',
        'autofocus',
        'disabled',
        'form',
        'multiple',
        'placeholder',
        'name',
        'required',
        'size',
        'tabindex',
        'data-maximum-selection-length',
    ];

    /**
     * @param string|null $name
     *
     * @return Relation
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }

    /**
     * @return Relation
     */
    public function multiple(): self
    {
        $this->attributes['multiple'] = 'multiple';

        return $this;
    }

    /**
     * @param string|Model $model
     * @param string       $name
     * @param string|null  $key
     *
     * @return Relation
     */
    public function fromModel(string $model, string $name, string $key = null): self
    {
        $key = $key ?? (new $model())->getModel()->getKeyName();

        $this->set('relationModel', Crypt::encryptString($model));
        $this->set('relationName', Crypt::encryptString($name));
        $this->set('relationKey', Crypt::encryptString($key));

        return $this->addBeforeRender(function () use ($model, $name, $key) {
            $append = $this->get('relationAppend');

            if (is_string($append)) {
                $append = Crypt::decryptString($append);
            }

            $text = $append ?? $name;
            $value = $this->get('value');

            if (! is_iterable($value)) {
                $value = Arr::wrap($value);
            }

            if (Assert::isIntArray($value)) {
                $value = $model::whereIn($key, $value)->get();
            }

            $value = collect($value)
                ->map(static function ($item) use ($text, $key) {
                    return [
                        'id'   => $item->$key,
                        'text' => $item->$text,
                    ];
                })->toJson();

            $this->set('value', $value);
        });
    }

    /**
     * @param string $class
     * @param string $name
     * @param string $key
     *
     * @return Relation
     */
    public function fromClass(string $class, string $name, string $key = 'id'): self
    {
        $this->set('relationModel', Crypt::encryptString($class));
        $this->set('relationName', Crypt::encryptString($name));
        $this->set('relationKey', Crypt::encryptString($key));

        return $this->addBeforeRender(function () use ($class, $name, $key) {
            $value = $this->get('value');

            if (empty($value)) {
                return $this->set('value', json_encode($value));
            }

            $scope = $this->get('scope', 'handler');
            $class = app()->make($class);

            if (! is_iterable($value)) {
                $value = Arr::wrap($value);
            }

            if (property_exists($class, 'value') && Assert::isIntArray($value)) {
                $class->value = $value;
            }

            $class = $class->{$scope['name']}(...$scope['parameters']);

            $item = collect($class)
                ->whereIn($key, $value)
                ->values();

            $value = collect($item)
                ->map(static function ($item) use ($name, $key) {
                    $item = is_array($item) ? collect($item) : $item;

                    return [
                        'id'   => $item->get($key),
                        'text' => $item->get($name),
                    ];
                })->toJson();

            $this->set('value', $value);
        });
    }

    /**
     * @param string $scope
     * @param array  $parameters
     *
     * @return Relation
     */
    public function applyScope(string $scope, ...$parameters): self
    {
        $data = [
            'name'       => lcfirst($scope),
            'parameters' => $parameters,
        ];
        $this->set('scope', $data);
        $this->set('relationScope', CryptArray::encrypt($data));

        return $this;
    }

    /**
     * Displays the calculated model
     * field in the selection field.
     *
     * @param string $append
     *
     * @return Relation
     */
    public function displayAppend(string $append): self
    {
        $this->set('relationAppend', Crypt::encryptString($append));

        return $this;
    }

    /**
     * Set the maximum number of items that may be selected.
     *
     * @param int $number
     *
     * @return $this
     */
    public function max(int $number)
    {
        $this->set('data-maximum-selection-length', (string) $number);

        return $this;
    }
}
