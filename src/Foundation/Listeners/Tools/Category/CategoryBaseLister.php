<?php

namespace Orchid\Foundation\Listeners\Tools\Category;

use Orchid\Foundation\Events\Tools\Category\CategoryEvent;
use Orchid\Foundation\Http\Forms\Tools\Category\CategoryMainForm;

class CategoryBaseLister
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param SettingsEvent $event
     *
     * @return void
     */
    public function handle(CategoryEvent $event)
    {
        return CategoryMainForm::class;
    }
}
