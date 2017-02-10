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
            $content_locale = $item['content'][$locale];


            $exists = !isset($content_locale['place']);

            if($exists) {
                return
                    $content_locale['place']['name'] != '' &&
                    $content_locale['place']['lat'] != '' &&
                    $content_locale['place']['lng'] != '';
            }

            return false;
        })->map(function ($item) use ($locale) {
            $content_locale = $item['content'][$locale];

            return [
                'name'    => $content_locale['name'],
                'address' => $content_locale['place']['name'],
                'lat'     => $content_locale['place']['lat'],
                'lng'     => $content_locale['place']['lng'],
            ];
        });
    }
}
