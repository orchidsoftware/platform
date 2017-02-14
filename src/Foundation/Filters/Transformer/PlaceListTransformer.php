<?php

namespace Orchid\Foundation\Filters\Transformer;

use Illuminate\Support\Facades\App;

class PlaceListTransformer extends Transformer
{
    /**
     * @var array|mixed
     */
    private $locales = [];

    /**
     * PlaceListTransformer constructor.
     */
    public function __construct()
    {
        $this->locales = config('content.locales');
    }

    /**
     * @param $collect
     *
     * @return mixed
     */
    public static function transform($collect)
    {
        $currentLocale = App::getLocale();
        $localeNames = [];

        foreach(config('content.locales') as $localeName) {
            $localeNames[] = $localeName;
        }

        if ($currentLocale == null) {
            $currentLocale = 'en';
        }

        return $collect->reject(function ($item) use ($currentLocale) {
            $content_locale = $item['content'][$currentLocale];

            $exists = !isset($content_locale['place']);

            if (!$exists) {
                return
                    empty($content_locale['place']['name']) ||
                    empty($content_locale['place']['lat']) ||
                    empty($content_locale['place']['lng']);
            }

            return $exists;
        })->map(function ($item) use ($currentLocale, $localeNames) {
            $content_locale = $item['content'][$currentLocale];

            $typeObject = $item->getTypeObject();

            $result = [
                'id' => $item['id'],

                'name'    => $content_locale['name'],
                'address' => $content_locale['place']['name'],
                'lat'     => $content_locale['place']['lat'],
                'lng'     => $content_locale['place']['lng'],

                'locales' => []
            ];

            if (method_exists($typeObject, 'display')) {
                $result['display'] = $typeObject->display();
            }

            foreach($localeNames as $localeName) {
                $result['locales'][$localeName] = $item['content'][$localeName]['place']['name'];
            }

            return $result;
        });
    }
}
