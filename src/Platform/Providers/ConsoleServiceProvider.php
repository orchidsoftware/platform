<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Commands\CreateAdminCommand;
use Orchid\Platform\Commands\InstallCommand;
use Orchid\Platform\Commands\MakeChart;
use Orchid\Platform\Commands\MakeFilter;
use Orchid\Platform\Commands\MakeRows;
use Orchid\Platform\Commands\MakeScreen;
use Orchid\Platform\Commands\MakeTable;
use Orchid\Platform\Commands\MakeWidget;
use Orchid\Platform\Commands\PublicLinkCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * The available command shortname.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        CreateAdminCommand::class,
        MakeFilter::class,
        PublicLinkCommand::class,
        MakeWidget::class,
        MakeRows::class,
        MakeScreen::class,
        MakeTable::class,
        MakeChart::class,
    ];

    /**
     * Register the commands.
     */
    public function register()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        foreach ($this->commands as $command) {
            $this->commands($command);
        }
    }
}
