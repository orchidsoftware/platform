<?php
/**
 * Created by PhpStorm.
 * User: joker
 * Date: 16.11.16
 * Time: 11:16
 */

namespace Orchid\Foundation\Listeners\Systems\Localization;

use Orchid\Foundation\Events\Systems\LocalizationEvent;
use Orchid\Foundation\Events\Systems\RolesEvent;
use Orchid\Foundation\Http\Forms\Systems\Localization\LocalizationMainForm;

class LocalizationAddListener
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
     * @param RolesEvent $event
     *
     * @return void
     */
    public function handle(LocalizationEvent $event)
    {
        return LocalizationMainForm::class;
    }
}