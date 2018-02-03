<?php

declare(strict_types=1);

namespace Orchid\Platform\Listeners\Category;

use Orchid\Platform\Http\Forms\Category\CategoryMainForm;

class CategoryBaseLister
{
    /**
     * Handle the event.
     *
     * @return mixed
     *
     * @internal param CategoryEvent $event
     */
    public function handle() : string
    {
        return CategoryMainForm::class;
    }
}
