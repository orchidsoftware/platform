<?php

namespace Orchid\Core\Observers;

use Illuminate\Support\Facades\App;
use Orchid\Core\Models\Newsletter;

class NewsletterObserver
{
    /**
     * @param Newsletter $newsletter
     *
     * @return Newsletter
     */
    public function creating(Newsletter $newsletter): Newsletter
    {
        if (is_null($newsletter->lang)) {
            $newsletter->lang = App::getLocale();
        }

        return $newsletter;
    }
}
