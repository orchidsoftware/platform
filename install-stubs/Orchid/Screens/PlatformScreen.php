<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use Orchid\Screen\Screen;
use Orchid\Screen\Layouts;
use Orchid\Platform\Dashboard;

class PlatformScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'platform::common.title';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'platform::common.description';

    /**
     * Query data.
     *
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'status' => Dashboard::checkUpdate(),
        ];
    }

    /**
     * Button commands.
     *
     * @return array
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            Layouts::view('platform::partials.update'),
            Layouts::view('platform::partials.welcome'),
        ];
    }
}
