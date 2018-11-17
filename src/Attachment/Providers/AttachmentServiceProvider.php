<?php

declare(strict_types=1);

namespace Orchid\Attachment\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class AttachmentServiceProvider.
 */
class AttachmentServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->registerDatabase();
    }

    /**
     * Register migrate.
     *
     * @return $this
     */
    protected function registerDatabase(): self
    {
        $this->loadMigrationsFrom(realpath(PLATFORM_PATH . '/database/migrations/attachment'));

        return $this;
    }
}
