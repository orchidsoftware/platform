<?php

declare(strict_types=1);

namespace Orchid\Platform\Providers;

use Illuminate\Support\ServiceProvider;
use Orchid\Platform\Console\Commands\CreateAdminCommand;
use Orchid\Platform\Console\Commands\MakeChart;
use Orchid\Platform\Console\Commands\MakeFilter;
use Orchid\Platform\Console\Commands\MakeManyBehavior;
use Orchid\Platform\Console\Commands\MakeRows;
use Orchid\Platform\Console\Commands\MakeScreen;
use Orchid\Platform\Console\Commands\MakeSingleBehavior;
use Orchid\Platform\Console\Commands\MakeTable;
use Orchid\Platform\Console\Commands\MakeWidget;
use Orchid\Platform\Console\Commands\PublicLinkCommand;
use Orchid\Platform\Platform\Console\Commands\InstallCommand;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * The available command shortname.
     *
     * @var array
     */
    protected $commands = [
        InstallCommand::class,
        CreateAdminCommand::class,
        MakeManyBehavior::class,
        MakeSingleBehavior::class,
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
        foreach ($this->commands as $command) {
            $this->commands($command);
        }
    }
}
