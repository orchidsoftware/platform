<?php

namespace Orchid\Foundation\Listeners\Tools\Category;

use Orchid\Foundation\Events\Tools\CategoryEvent;
use Orchid\Foundation\Http\Forms\Tools\Category\CategoryMainForm;

class CategoryBaseLister
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
     * @param CategoryEvent $event
     * @return mixed
     */
    public function handle(CategoryEvent $event)
    {
        return CategoryMainForm::class;
    }
}
