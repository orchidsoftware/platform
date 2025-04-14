<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Illuminate\Support\Str;

/**
 * Class Toggle.
 *
 * @method $this name(string $name = null)
 * @method $this title(string $title = null)
 * @method $this placeholder(string $value = null)
 * @method $this class(string $classes = null)
 * @method $this action(string $url)
 * @method $this disabled(bool $disabled = true)
 */
class Toggle extends Button
{
    /**
     * @var string
     */
    protected $view = 'platform::actions.toggle';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'      => 'form-check-input',
        'type'       => 'checkbox',
        'novalidate' => false,
        'method'     => null,
        'action'     => null,
        'parameters' => [],
        'turbo'      => true,
        'form'       => 'post-form',
        'yesvalue'   => 1,
        'novalue'    => 0,
    ];

    /**
     * Attributes available for a particular tag.
     *
     * @var array
     */
    protected $inlineAttributes = [
        'form',
        'formaction',
        'formenctype',
        'formmethod',
        'formnovalidate',
        'formtarget',
        'type',
        'disabled',
        'yesvalue',
        'novalue',
        'title',
        'novalidate'
    ];

    /**
     * A set of attributes for the assignment
     * of which will automatically translate them.
     *
     * @var array
     */
    protected $translations = [
        'name',
    ];

    /**
     * Create a new Toggle Action.
     */
    public static function make(?string $name = null): static
    {
        return (new self())->name($name)
            ->title(Str::title($name));
    }

    public function __construct()
    {
        parent::__construct();

        $this->addBeforeRender(function () {
            $this->set('value', (bool) $this->get('value'));
        });
    }
}
