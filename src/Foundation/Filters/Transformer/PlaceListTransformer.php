<?php

namespace Orchid\Foundation\Filters\Transformer;

use Illuminate\Support\Facades\App;

class PlaceListTransformer extends Transformer
{
    private $locales = [];

    /**
     * PlaceListTransformer constructor.
     */
    public function __construct()
    {
        $this->locales = config('content.locales');
    }

    public static function transform($collect)
    {
        $locale = App::getLocale();

        if ($locale == null) {
            $locale = 'en';
        }

        return $collect->reject(function ($item) use ($locale) {
            return !isset($item['content'][$locale]['place']);

        })->map(function ($item) use ($locale) {
            $content_locale = $item['content'][$locale];

            return [
                'title' => $content_locale['place']['name'],
                'lat'   => $content_locale['place']['lat'],
                'lng'   => $content_locale['place']['lng'],
            ];
        });
    }
}
