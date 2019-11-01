<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Orchid\Screen\Field;
use Orchid\Support\Assert;

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
        'class'         => 'form-control',
        'value'         => [],
        'relationScope' => '',
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

        return $this->addBeforeRender(function () use ($model, $name, $key) {
            $value = $this->get('value');

            if (! is_iterable($value)) {
                $value = Arr::wrap($value);
            }

            if (Assert::isIntArray($value)) {
                $value = $model::whereIn($key, $value)->get();
            }

            $value = collect($value)
                ->map(static function ($item) use ($name, $key) {
                    return [
                        'id'   => $item->$key,
                        'text' => $item->$name,
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
     * @return self
     */
    public function fromClass(string $class, string $name, string $key = 'id'): self
    {
        $this->set('relationModel', Crypt::encryptString($class));
        $this->set('relationName', Crypt::encryptString($name));
        $this->set('relationKey', Crypt::encryptString($key));

        return $this->addBeforeRender(function () use ($class, $name, $key) {
            $value = $this->get('value');
            if (! empty($value)) {
                $scope = $this->get('scope', 'handler');
                $class = app()->make($class);

                if (property_exists($class, 'value') && Assert::isIntArray($value)) {
                    $class->value = $value;
                }

                $class = $class->{$scope}();

                $item = collect($class)
                    ->whereIn($key, $value)
                    ->all();

                if (is_array($item)) {
                    $item = collect(array_values($item));
                }

                $value = collect($item)
                    ->map(static function ($item) use ($name, $key) {
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
    }

    /**
     * @param string $scope
     *
     * @return $this
     */
    public function applyScope(string $scope): self
    {
        $scope = lcfirst($scope);
        $this->set('scope', $scope);
        $this->set('relationScope', Crypt::encryptString($scope));

        return $this;
    }
}
