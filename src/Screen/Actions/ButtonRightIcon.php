<?php

declare(strict_types=1);

namespace Orchid\Screen\Actions;

use Orchid\Screen\Action;

/**
 * Class Button.
 *
 * @method ButtonRightIcon name(string $name = null)
 * @method ButtonRightIcon modal(string $modalName = null)
 * @method ButtonRightIcon icon(string $icon = null)
 * @method ButtonRightIcon class(string $classes = null)
 * @method ButtonRightIcon method(string $methodName = null)
 * @method ButtonRightIcon parameters(array|object $name)
 * @method ButtonRightIcon confirm(string $confirm = true)
 * @method ButtonRightIcon action(string $url)
 * @method ButtonRightIcon disabled(bool $disabled)
 */
class ButtonRightIcon extends Action
{
    /**
     * @var string
     */
    protected $view = 'platform::actions.button-right-icon';
    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'class'      => 'btn btn-default',
        'type'       => 'submit',
        'novalidate' => false,
        'method'     => null,
        'icon'       => 'arrow-right',
        'action'     => null,
        'confirm'    => null,
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

    /**
     * Button constructor.
     */
    public function __construct()
    {
        $this->addBeforeRender(function () {
            if ($this->get('action') !== null) {
                return;
            }

            $url = url()->current();
            $query = http_build_query($this->get('parameters'));

            $action = rtrim("{$url}/{$this->get('method')}?{$query}", '/?');
            $this->set('action', $action);
        })->addBeforeRender(function () {
            $action = $this->get('action');

            if ($action !== null) {
                $this->set('formaction', $action);
            }
        });
    }

    /**
     * @param bool $novalidate
     *
     * @return ButtonRightIcon|\Orchid\Screen\Field
     */
    public function novalidate(bool $novalidate = true)
    {
        return $this->set('formnovalidate', var_export($novalidate, true));
    }
}
