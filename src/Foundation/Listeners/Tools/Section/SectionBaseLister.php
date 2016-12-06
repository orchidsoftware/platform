<?php

namespace Orchid\Foundation\Listeners\Tools\Section;

use Orchid\Foundation\Events\Tools\SectionEvent;
use Orchid\Foundation\Http\Forms\Tools\Section\SectionMainForm;

class SectionBaseLister
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
    public function handle(SectionEvent $event)
    {
        return SectionMainForm::class;
    }
}
