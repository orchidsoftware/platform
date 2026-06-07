<?php

declare(strict_types=1);

namespace Orchid\Screen\Fields;

use Orchid\Screen\Field;

/**
 * Class Markdown.
 *
 * @method $this accesskey($value = true)
 * @method $this autofocus($value = true)
 * @method $this disabled($value = true)
 * @method $this form($value = true)
 * @method $this maxlength($value = true)
 * @method $this name(string $value = null)
 * @method $this placeholder(string $value = null)
 * @method $this readonly($value = true)
 * @method $this required(bool $value = true)
 * @method $this rows($value = true)
 * @method $this tabindex($value = true)
 * @method $this value($value = true)
 * @method $this help(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
 */
class Markdown extends Field
{
    public const H1 = 'h1';

    public const H2 = 'h2';

    public const H3 = 'h3';

    public const H4 = 'h4';

    public const H5 = 'h5';

    public const BOLD = 'bold';

    public const ITALIC = 'italic';

    public const LINK = 'link';

    public const QUOTE = 'quote';

    public const CODE = 'code';

    public const LIST = 'list';

    public const ORDERED_LIST = 'orderedList';

    public const UPLOAD = 'upload';

    public const DEFAULT_TOOLBAR = [
        [self::H2, self::H3, self::H4],
        [self::BOLD, self::ITALIC],
        [self::LINK, self::QUOTE, self::CODE],
        [self::LIST, self::ORDERED_LIST],
        [self::UPLOAD],
    ];

    /**
     * @var string
     */
    protected $view = 'orchid::fields.markdown';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'   => 'form-control',
        'value'   => null,
        'rows'    => 8,
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
        'maxlength',
        'name',
        'placeholder',
        'readonly',
        'required',
        'rows',
        'tabindex',
    ];

    /**
     * Markdown constructor.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            $this->set('toolbarGroups', $this->prepareToolbarGroups());
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
     * Defines the buttons and visual groups displayed in the editor toolbar.
     */
    public function toolbar(array $groups): self
    {
        return $this->set('toolbar', $groups);
    }

    /**
     * Prepares toolbar groups for rendering.
     */
    protected function prepareToolbarGroups(): array
    {
        $toolbar = collect($this->get('toolbar'));
        $groups = $toolbar->contains(fn ($buttons) => is_array($buttons))
            ? $toolbar
            : collect([$toolbar->all()]);

        return $groups
            ->map(fn ($buttons) => collect($this->toolbarButtons())->only($buttons)->values()->all())
            ->filter()
            ->values()
            ->all();
    }

    /**
     * Returns supported toolbar buttons.
     */
    protected function toolbarButtons(): array
    {
        return [
            self::H1           => ['H1', 'headingOne', 'bs.type-h1'],
            self::H2           => ['H2', 'headingTwo', 'bs.type-h2'],
            self::H3           => ['H3', 'headingThree', 'bs.type-h3'],
            self::H4           => ['H4', 'headingFour', 'bs.type-h4'],
            self::H5           => ['H5', 'headingFive', 'bs.type-h5'],
            self::BOLD         => [__('Bold'), 'bold', 'bs.type-bold'],
            self::ITALIC       => [__('Italic'), 'italic', 'bs.type-italic'],
            self::LINK         => [__('Link'), 'link', 'bs.link-45deg'],
            self::QUOTE        => [__('Quote'), 'quote', 'bs.quote'],
            self::CODE         => [__('Code'), 'code', 'bs.code-slash'],
            self::LIST         => [__('List'), 'list', 'bs.list-ul'],
            self::ORDERED_LIST => [__('Numbered list'), 'orderedList', 'bs.list-ol'],
            self::UPLOAD       => [__('Upload file'), 'showDialogUpload', 'bs.cloud-arrow-up'],
        ];
    }
}
