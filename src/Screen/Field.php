<?php

declare(strict_types=1);

namespace Orchid\Screen;

use Closure;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use Illuminate\View\ComponentAttributeBag;
use Illuminate\View\View;
use Orchid\Screen\Concerns\Makeable;
use Orchid\Screen\Contracts\Fieldable;
use Orchid\Screen\Exceptions\FieldRequiredAttributeException;
use Throwable;

/**
 * Class Field.
 *
 * @method self accesskey($value = true)
 * @method self class($value = true)
 * @method self dir($value = true)
 * @method self hidden($value = true)
 * @method self id($value = true)
 * @method self lang($value = true)
 * @method self spellcheck($value = true)
 * @method self style($value = true)
 * @method self tabindex($value = true)
 * @method self autocomplete($value = true)
 */
class Field implements Fieldable, Htmlable
{
    use CanSee, Conditionable, Macroable, Makeable {
        Macroable::__call as macroCall;
    }

    /**
     * A set of closure functions
     * that must be executed before data is displayed.
     *
     * @var Closure[]
     */
    private $beforeRender = [];

    /**
     * View template show.
     *
     * @var string
     */
    protected $view;

    /**
     * All attributes that are available to the field.
     *
     * @var array
     */
    protected $attributes = [
        'value' => null,
    ];

    /**
     * Required Attributes.
     *
     * @var array
     */
    protected $required = [
        'name',
    ];

    /**
     * Vertical or Horizontal
     * bootstrap forms.
     *
     * @var Closure|string|null
     */
    protected $typeForm;

    /**
     * A set of attributes for the assignment
     * of which will automatically translate them.
     *
     * @var array
     */
    protected $translations = [
        'title',
        'placeholder',
        'help',
    ];

    /**
     * Universal attributes are applied to almost all tags,
     * so they are allocated to a separate group so that they do not repeat for all tags.
     *
     * @var array
     */
    protected $universalAttributes = [
        'accesskey',
        'class',
        'dir',
        'hidden',
        'id',
        'lang',
        'spellcheck',
        'style',
        'tabindex',
        'title',
        'xml:lang',
        'autocomplete',
        'data-*',
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [];

    /**
     * @param string $method
     * @param array  $parameters
     *
     * @return $this|mixed|static|\Orchid\Screen\Field
     */
    public function __call(string $method, array $parameters)
    {
        if (static::hasMacro($method)) {
            return $this->macroCall($method, $parameters);
        }

        $arguments = collect($parameters)->map(static fn ($argument) => $argument instanceof Closure ? $argument() : $argument);

        if (method_exists($this, $method)) {
            $this->$method($arguments);
        }

        return $this->set($method, $arguments->first() ?? true);
    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function value($value): self
    {
        return $this->set('value', $value);
    }

    /**
     * @param mixed $value
     *
     * @return static
     */
    public function set(string $key, $value = true): self
    {
        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * @throws Throwable
     *
     * @return static
     */
    protected function checkRequired(): self
    {
        collect($this->required)
            ->filter(fn ($attribute) => ! array_key_exists($attribute, $this->attributes))
            ->each(function ($attribute) {
                throw new FieldRequiredAttributeException($attribute);
            });

        return $this;
    }

    /**
     * @throws Throwable
     *
     * @return Factory|View|mixed
     */
    public function render()
    {
        if (! $this->isSee()) {
            return;
        }

        $this
            ->checkRequired()
            ->modifyName()
            ->modifyValue()
            ->runBeforeRender()
            ->translate()
            ->checkError();

        $id = $this->getId();
        $this->set('id', $id);

        $errors = $this->getErrorsMessage();

        return view($this->view, array_merge($this->getAttributes(), [
            'attributes'     => $this->getAllowAttributes(),
            'dataAttributes' => $this->getAllowDataAttributes(),
            'id'             => $id,
            'old'            => $this->getOldValue(),
            'slug'           => $this->getSlug(),
            'oldName'        => $this->getOldName(),
            'typeForm'       => $this->typeForm ?? $this->vertical()->typeForm,
        ]))
            ->withErrors($errors);
    }

    /**
     * Localization of fields.
     *
     * @return static
     */
    private function translate(): self
    {
        $lang = $this->get('lang');

        collect($this->attributes)
            ->intersectByKeys(array_flip($this->translations))
            ->each(function ($value, $key) use ($lang) {
                $translation = __($value, [], $lang);
                $this->set($key, is_string($translation) ? $translation : $value);
            });

        return $this;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    protected function getAllowAttributes(): ComponentAttributeBag
    {
        $allow = array_merge($this->universalAttributes, $this->inlineAttributes);

        $attributes = collect($this->getAttributes())
            ->filter(fn ($value, $attribute) => Str::is($allow, $attribute))
            ->toArray();

        return (new ComponentAttributeBag())
            ->merge($attributes);
    }

    protected function getAllowDataAttributes(): ComponentAttributeBag
    {
        return $this->getAllowAttributes()->filter(fn ($value, $key) => Str::startsWith($key, 'data-'));
    }

    /**
     * @return string
     */
    protected function getId(): ?string
    {
        $id = $this->get('id');

        if ($id !== null) {
            return (string) $id;
        }

        $lang = $this->get('lang');
        $slug = $this->get('name');
        $hash = sha1(json_encode($this->getAttributes()));

        return Str::slug("field-$lang-$slug-$hash");
    }

    /**
     * @param mixed|null $value
     *
     * @return static|mixed|null
     */
    public function get(string $key, $value = null)
    {
        return $this->attributes[$key] ?? $value;
    }

    protected function getSlug(): string
    {
        return Str::slug($this->get('name'));
    }

    /**
     * Get the old value of the field.
     *
     * @return float|int|mixed|string
     */
    public function getOldValue()
    {
        return old($this->getOldName());
    }

    public function getOldName(): string
    {
        return (string) Str::of($this->get('name'))
            ->replace(['][', '['], '.')
            ->replace([']'], '')->rtrim('.');
    }

    /**
     * Checking for errors and filling css class.
     *
     * @return $this
     */
    private function checkError(): self
    {
        if (! $this->hasError()) {
            return $this;
        }

        $class = $this->get('class');

        return $this->set('class', $class.' is-invalid');
    }

    private function hasError(): bool
    {
        return optional(session('errors'))->has($this->getOldName()) ?? false;
    }

    /**
     * @return static
     */
    protected function modifyName()
    {
        $name = $this->get('name');
        $prefix = $this->get('prefix');
        $lang = $this->get('lang');

        if ($prefix !== null && $lang !== null) {
            return $this->set('name', $prefix.'['.$lang.']'.$name);
        }

        if ($prefix !== null) {
            return $this->set('name', $prefix.$name);
        }

        if ($lang !== null) {
            return $this->set('name', $lang.'['.$name.']');
        }

        return $this;
    }

    /**
     * @return static
     */
    protected function modifyValue(): self
    {
        $value = $this->getOldValue() ?? $this->get('value');

        if ($value instanceof Closure) {
            $value = $value($this->attributes);
        }

        return $this->set('value', $value);
    }

    /**
     * Use vertical layout for the field.
     *
     * @return static
     */
    public function vertical(): self
    {
        $this->typeForm = 'platform::partials.fields.vertical';

        return $this;
    }

    /**
     * Use clear layout for the field.
     *
     * @return static
     */
    public function clear(): self
    {
        $this->typeForm = 'platform::partials.fields.clear';

        return $this;
    }

    /**
     * Use horizontal layout for the field.
     *
     * @return static
     */
    public function horizontal(): self
    {
        $this->typeForm = 'platform::partials.fields.horizontal';

        return $this;
    }

    /**
     * Displaying an item without titles or additional information.
     *
     * @return $this
     */
    public function withoutFormType(): self
    {
        $this->typeForm = static fn (array $attributes) => $attributes['slot'];

        return $this;
    }

    /**
     * Create separate line after the field.
     *
     * @return static
     */
    public function hr(): self
    {
        $this->set('hr');

        return $this;
    }

    /**
     * @return static
     */
    public function addBeforeRender(Closure $closure)
    {
        $this->beforeRender[] = $closure;

        return $this;
    }

    /**
     * Alternately performs all tasks.
     *
     * @return $this
     */
    public function runBeforeRender(): self
    {
        foreach ($this->beforeRender as $before) {
            $before->call($this);
        }

        return $this;
    }

    private function getErrorsMessage(): array
    {
        $errors = session()->get('errors', new MessageBag());

        return $errors->getMessages();
    }

    /**
     * @throws Throwable
     */
    public function __toString(): string
    {
        $view = $this->render();

        if (is_string($view)) {
            return $view;
        }

        if (is_a($view, View::class)) {
            return (string) $view->render();
        }

        return '';
    }

    /**
     * Apply the callback if the value is truthy.
     *
     * @param bool     $condition
     * @param callable $callback
     *
     * @return $this
     */
    public function when(bool $condition, callable $callback)
    {
        if ($condition) {
            $callback($this);
        }

        return $this;
    }

    /**
     * @throws \Throwable
     *
     * @return string
     */
    public function toHtml()
    {
        return $this->render()->toHtml();
    }
}
