<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;
use Orchid\Support\Assert;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Relation.
 *
 * @method self accesskey($value = true)
 * @method self autofocus($value = true)
 * @method self disabled($value = true)
 * @method self form($value = true)
 * @method self name(string $value = null)
 * @method self required(bool $value = true)
 * @method self size($value = true)
 * @method self tabindex($value = true)
 * @method self help(string $value = null)
 * @method self placeholder(string $placeholder = null)
 * @method self popover(string $value = null)
 */
class Relation extends Field
{
    /**
     * @var string
     */
    public $view = 'platform::fields.relation';

    /**
     * Default attributes value.
     *
     * @var array
     */
    public $attributes = [
        'class'         => 'form-control',
        'value'         => [],
        'relationScope' => '',
    ];

    /**
     * @var array
     */
    public $required = [
        'name',
        'relationModel',
        'relationName',
        'relationKey',
        'relationScope',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    public $inlineAttributes = [
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
    ];

    /**
     * @param string|null $name
     *
     * @return self
     */
    public static function make(string $name = null): self
    {
        return (new static())->name($name);
    }

    /**
     * @return self
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
     * @return self
     */
    public function fromModel(string $model, string $name, string $key = null): self
    {
        $key = $key ?? (new $model())->getModel()->getKeyName();

        $this->set('relationModel', Crypt::encryptString($model));
        $this->set('relationName', Crypt::encryptString($name));
        $this->set('relationKey', Crypt::encryptString($key));

        $this->addBeforeRender(function () use ($model, $name, $key) {
            $value = $this->get('value');

            if (! is_iterable($value)) {
                $value = Arr::wrap($value);
            }

            if (Assert::isIntArray($value)) {
                $value = $model::whereIn($key, $value)->get();
            }

            $value = collect($value)
                ->map(function ($item) use ($name, $key) {
                    return [
                        'id'   => $item->$key,
                        'text' => $item->$name,
                    ];
                })->toJson();

            $this->set('value', $value);
        });

        return $this;
    }

    /**
     * @param string $class
     * @param string $name
     * @param string $key
     *
     * @return self
     */
    public function fromClass(string $class, string $name, string $key = 'id'): self
    {
        $this->set('relationModel', Crypt::encryptString($class));
        $this->set('relationName', Crypt::encryptString($name));
        $this->set('relationKey', Crypt::encryptString($key));

        $this->addBeforeRender(function () use ($class, $name, $key) {
            $value = $this->get('value');
            if (! empty($value)) {
                $scope = $this->get('scope', 'handler');
                $class = (new $class())->{$scope}();

                $item = collect($class)
                    ->whereIn($key, $value)
                    ->all();

                if (is_array($item)) {
                    $item = collect(array_values($item));
                }

                $value = collect($item)
                    ->map(function ($item) use ($name, $key) {
                        if (is_array($item)) {
                            $item = collect($item);
                        }

                        return [
                            'id'   => $item->get($key),
                            'text' => $item->get($name),
                        ];
                    })->toJson();
            } else {
                $value = json_encode($value);
            }

            $this->set('value', $value);
        });

        return $this;
    }

    /**
     * @param string $scope
     *
     * @return $this
     */
    public function applyScope(string $scope): self
    {
        $scope = lcfirst($scope);

        $this->set('relationScope', Crypt::encryptString($scope));

        return $this;
    }
}
