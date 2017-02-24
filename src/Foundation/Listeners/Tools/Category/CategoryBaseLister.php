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
     * @return mixed
     * @internal param CategoryEvent $event
     *
     */
    public function handle()
    {
        return CategoryMainForm::class;
    }
}
