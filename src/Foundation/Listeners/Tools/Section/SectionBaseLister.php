<?php

namespace Orchid\Foundation\Listeners\Tools\Section;

use Orchid\Foundation\Events\Tools\SectionEvent;
use Orchid\Foundation\Http\Forms\Tools\Section\SectionMainForm;

class SectionBaseLister
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
     * @param SectionEvent|SettingsEvent $event
     * @return
     */
    public function handle(SectionEvent $event)
    {
        return SectionMainForm::class;
    }
}
