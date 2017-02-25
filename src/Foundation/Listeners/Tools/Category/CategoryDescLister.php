<?php

namespace Orchid\Foundation\Listeners\Tools\Category;

use Orchid\Foundation\Http\Forms\Tools\Category\CategoryDescForm;

class CategoryDescLister
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @return mixed
     *
     * @internal param CategoryEvent $event
     */
    public function handle()
    {
        return CategoryDescForm::class;
    }
}
