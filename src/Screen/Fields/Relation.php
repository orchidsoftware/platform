<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Crypt;
use Orchid\Support\Assert;

/**
 * Relation select: loads options via HTTP in chunks.
 *
 * @deprecated Use Select::make()->fromModel(...)->lazy(10) instead. This class is kept for backward compatibility.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this name(string $value = null)
 * @method $this required(bool $value = true)
 * @method $this size($value = true)
 * @method $this tabindex($value = true)
 * @method $this help(string $value = null)
 * @method $this placeholder(string $placeholder = null)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
 * @method $this allowAdd($value = false)
 */
class Relation extends Select
{
    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'value' => [],
    ];

    public function __construct()
    {
        parent::__construct();
        $this->lazy(Select::DEFAULT_LAZY_CHUNK);
    }

    /**
     * @param string|Model $model
     */
    public function fromModel(string|Model $model, string $name, ?string $key = null): static
    {
        return parent::fromModel($model, $name, $key);
    }

    /**
     * Load options from a class with a scope (e.g. custom handler). Lazy-only.
     */
    public function fromClass(string $class, string $name, string $key = 'id'): static
    {
        $this
            ->set('relationModel', Crypt::encryptString($class))
            ->set('relationName', Crypt::encryptString($name))
            ->set('relationKey', Crypt::encryptString($key));

        return $this->addBeforeRender(function () use ($class, $name, $key) {
            $value = $this->get('value');
            if (empty($value)) {
                return $this->set('value', $value ?? []);
            }
            $scope = $this->get('relationScope') ? Crypt::decrypt($this->get('relationScope')) : ['name' => 'handler', 'parameters' => []];
            $instance = resolve($class);
            if (! is_iterable($value)) {
                $value = Arr::wrap($value);
            }
            if (property_exists($instance, 'value') && Assert::isIntArray($value)) {
                $instance->value = $value;
            }
            $items = $instance->{$scope['name']}(...$scope['parameters']);
            $items = collect($items)->whereIn($key, $value)->values();
            $value = collect($items)
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
    public function applyScope(string $scope, ...$parameters): static
    {
        return parent::applyScope($scope, ...$parameters);
    }

    /**
     * Sets the size of the chunk to be shown to the user.
     *
     * @return static
     */
    public function chunk(int $value): static
    {
        return $this->set('lazyChunk', $value);
    }

    /**
     * Allow empty value to be set
     *
     * @deprecated use `allowEmpty()` instead
     */
    public function nullable(bool $value = true): static
    {
        return $this->set('allowEmpty', $value);
    }
}
