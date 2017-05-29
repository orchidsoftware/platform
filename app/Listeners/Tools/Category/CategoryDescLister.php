<?php

namespace Orchid\Listeners\Tools\Category;

use Orchid\Http\Forms\Tools\Category\CategoryDescForm;

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
    public function handle(): string
    {
        return CategoryDescForm::class;
    }
}
