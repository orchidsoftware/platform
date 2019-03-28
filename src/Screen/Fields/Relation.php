<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Orchid\Screen\Field;

/**
 * Class Relation.
 *
 * @method self accesskey($value = true)
 * @method self autofocus($value = true)
 * @method self disabled($value = true)
 * @method self form($value = true)
 * @method self name(string $value)
 * @method self required(bool $value = true)
 * @method self size($value = true)
 * @method self tabindex($value = true)
 * @method self help(string $value = null)
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
        'class' => 'form-control',
    ];

    /**
     * @var array
     */
    public $required = [
        'name',
        'relationModel',
        'relationName',
        'relationKey',
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
     * @param string $name
     * @param string|null $key
     *
     * @return self
     */
    public function fromModel($model, string $name, string $key = null): self
    {
        /* @var $model Model */
        $model = is_object($model) ? $model : new $model();
        $key   = $key ?? $model->getModel()->getKeyName();
        $model = get_class($model);

        $this->set('relationModel', Crypt::encryptString($model));
        $this->set('relationName', Crypt::encryptString($name));
        $this->set('relationKey', Crypt::encryptString($key));

        return $this;
    }
}
