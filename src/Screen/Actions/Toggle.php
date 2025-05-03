<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

/**
 * Class Toggle.
 *
 * @method $this name(string $name = null)
 * @method $this title(string $title = null)
 * @method $this placeholder(string $value = null)
 * @method $this class(string $classes = null)
 * @method $this action(string $url)
 * @method $this disabled(bool $disabled = true)
 * @method $this status(bool $status = null)
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
        'icon'       => null,
        'action'     => null,
        'confirm'    => null,
        'parameters' => [],
        'turbo'      => true,
        'form'       => 'post-form',
        'status'     => false,
    ];

    public function __construct()
    {
        parent::__construct();

        $this->addBeforeRender(function () {
            $this->set('placeholder', $this->get('title'));
            $this->set('title', null);
        });
    }
}
