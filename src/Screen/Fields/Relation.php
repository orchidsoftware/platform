<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Orchid\Screen\Concerns\Multipliable;
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
 * @method Relation title(string $value = null)
 * @method Relation allowAdd($value = false)
 */
class Relation extends Field
{
    use Multipliable;

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
        'class'                 => 'form-control',
        'value'                 => [],
        'relationScope'         => null,
        'relationAppend'        => null,
        'relationSearchColumns' => null,
        'chunk'                 => 10,
        'allowEmpty'            => '',
        'allowAdd'              => false,
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
        'relationSearchColumns',
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
        'placeholder',
        'name',
        'required',
        'size',
        'tabindex',
        'data-maximum-selection-length',
    ];

    /**
     * @param string|Model $model
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function fromModel(string $model, string $name, ?string $key = null): self
    {
        $key = $key ?? resolve($model)->getModel()->getKeyName();

        $this
            ->set('relationModel', Crypt::encryptString($model))
            ->set('relationName', Crypt::encryptString($name))
            ->set('relationKey', Crypt::encryptString($key));

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

            if (! Assert::isObjectArray($value)) {
                $value = $model::whereIn($key, $value)->get();
            }

            $value = collect($value)
                ->map(static fn ($item) => [
                    'id'   => $item->$key,
                    'text' => $item->$text,
                ])->toArray();

            $this->set('value', $value);
        });
    }

    public function fromClass(string $class, string $name, string $key = 'id'): self
    {
        $this->set('relationModel', Crypt::encryptString($class));
        $this->set('relationName', Crypt::encryptString($name));
        $this->set('relationKey', Crypt::encryptString($key));

        return $this->addBeforeRender(function () use ($class, $name, $key) {
            $value = $this->get('value');

            if (empty($value)) {
                return $this->set('value', $value);
            }

            $scope = $this->get('scope', 'handler');
            $class = resolve($class);

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
                })->toArray();

            $this->set('value', $value);
        });
    }

    /**
     * @param array $parameters
     */
    public function applyScope(string $scope, ...$parameters): self
    {
        $data = [
            'name'       => lcfirst($scope),
            'parameters' => $parameters,
        ];
        $this->set('scope', $data);
        $this->set('relationScope', Crypt::encrypt($data));

        return $this;
    }

    /**
     * @param string|array $columns
     *
     * @return $this
     */
    public function searchColumns(...$columns): self
    {
        $columns = Arr::wrap($columns);

        $this->set('relationSearchColumns', Crypt::encrypt($columns));

        return $this;
    }

    /**
     * Displays the calculated model
     * field in the selection field.
     */
    public function displayAppend(string $append): self
    {
        $this->set('relationAppend', Crypt::encryptString($append));

        return $this;
    }

    /**
     * Set the maximum number of items that may be selected.
     *
     * @return $this
     */
    public function max(int $number)
    {
        $this->set('data-maximum-selection-length', (string) $number);

        return $this;
    }

    /**
     * Sets the size of the chunk to be shown to the user.
     *
     * @return $this
     */
    public function chunk(int $value)
    {
        return $this->set('chunk', $value);
    }

    /**
     * Allow empty value to be set
     *
     * @return $this
     */
    public function allowEmpty(bool $value = true)
    {
        return $this->set('allowEmpty', $value);
    }

    /**
     * Allow empty value to be set
     *
     * @deprecated use `allowEmpty()` instead
     */
    public function nullable(bool $value = true): self
    {
        return $this->set('allowEmpty', $value);
    }
}
