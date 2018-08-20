<?php

namespace Orchid\Platform\Http\Screens\Maintenance;

use Orchid\Screen\Link;
use Orchid\Screen\Screen;
use Illuminate\Contracts\Foundation\Application;

class MaintenanceModScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Режим технического обслуживания';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'Режим технического обслуживания';

    /**
     * @var bool
     */
    private $maintenance = false;

    /**
     * Query data.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return array
     */
    public function query(Application $app): array
    {
        $this->maintenance = $app->isDownForMaintenance();
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [
            Link::name('Запустить режим')
                ->icon('icon-check')
                ->show($this->maintenance)
                ->method('save'),
            Link::name('Отключить режим')
                ->icon('icon-trash')
                ->show(! $this->maintenance)
                ->method('remove'),
        ];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [];
    }
}
