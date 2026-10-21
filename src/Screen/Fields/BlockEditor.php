<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Illuminate\Support\Arr;
use Orchid\Screen\Field;

/**
 * Class BlockEditor.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this name(string $value = null)
 * @method $this placeholder(string $value = null)
 * @method $this readonly($value = true)
 * @method $this required(bool $value = true)
 * @method $this tabindex($value = true)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
 * @method $this toolbar(array $options)
 */
class BlockEditor extends Field
{
    /**
     * Toolbar identifier for the paragraph control.
     */
    public const PARAGRAPH = 'paragraph';

    /**
     * Toolbar identifier for the heading control.
     */
    public const HEADING = 'heading';

    /**
     * Toolbar identifier for the quote control.
     */
    public const QUOTE = 'quote';

    /**
     * Toolbar identifier for the list control.
     */
    public const LIST = 'list';

    /**
     * Toolbar identifier for the image control.
     */
    public const IMAGE = 'image';

    /**
     * Toolbar identifier for the code block control.
     */
    public const CODE = 'code';

    /**
     * Toolbar identifier for the embed control.
     */
    public const EMBED = 'embed';

    /**
     * Default set of controls available in the editor toolbar.
     */
    public const DEFAULT_TOOLBAR = [
        self::PARAGRAPH,
        self::HEADING,
        self::QUOTE,
        self::LIST,
        self::IMAGE,
        self::CODE,
        self::EMBED,
    ];

    /**
     * @var string
     */
    protected $view = 'orchid::fields.blockEditor';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'value'   => null,
        'toolbar' => self::DEFAULT_TOOLBAR,
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
        'name',
        'placeholder',
        'readonly',
        'required',
        'tabindex',
    ];

    /**
     * BlockEditor constructor.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            $this->set('toolbarButtons', $this->prepareToolbarButtons());
            $this->set('encodedValue', $this->prepareValue());
        });
    }

    /**
     * Hides the editor toolbar.
     */
    public function withoutToolbar(): self
    {
        return $this->set('toolbar', []);
    }

    /**
     * Defines the buttons displayed in the editor toolbar.
     */
    public function toolbar(array $buttons): self
    {
        return $this->set('toolbar', $buttons);
    }

    /**
     * Restore submitted values, including an explicitly cleared document.
     */
    protected function updateFieldValue(): static
    {
        $oldInput = request()->hasSession() ? request()->session()->getOldInput() : [];

        if (Arr::has($oldInput, $this->getOldName())) {
            return $this->set('value', Arr::get($oldInput, $this->getOldName()));
        }

        return parent::updateFieldValue();
    }

    /**
     * Prepares the current value as normalized JSON.
     */
    protected function prepareValue(): string
    {
        $value = $this->get('value');

        if ($value === null || $value === '') {
            return '{"blocks":[]}';
        }

        return is_string($value)
            ? $value
            : json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    }

    /**
     * Prepares toolbar buttons for rendering.
     */
    protected function prepareToolbarButtons(): array
    {
        $buttons = $this->toolbarButtons();

        return collect($this->get('toolbar'))
            ->unique()
            ->filter(fn ($type) => is_string($type) && array_key_exists($type, $buttons))
            ->map(fn (string $type) => [
                'type'  => $type,
                'title' => $buttons[$type],
            ])
            ->values()
            ->all();
    }

    /**
     * Returns supported toolbar buttons.
     */
    protected function toolbarButtons(): array
    {
        return [
            self::PARAGRAPH => __('Paragraph'),
            self::HEADING   => __('Heading'),
            self::QUOTE     => __('Quote'),
            self::LIST      => __('List'),
            self::IMAGE     => __('Image'),
            self::CODE      => __('Code'),
            self::EMBED     => __('Embed'),
        ];
    }
}
