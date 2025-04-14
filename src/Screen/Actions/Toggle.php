<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

/**
 * Class Button.
 *
 * @method $this name(string $name = null)
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
        'autofocus',
        'disabled',
        'tabindex',
    ];

    public function __construct()
    {
        parent::__construct();

        $this->addBeforeRender(function () {
            $this->set('value', (bool) $this->get('value'));
        });

    }
}
