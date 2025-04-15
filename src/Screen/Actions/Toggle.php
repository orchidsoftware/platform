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
            $this->set('value', (bool) $this->get('value'))
                ->set('type', 'checkbox')
                ->set('class', 'form-check-input');
        });
    }
}
