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
     * @return mixed
     */
    public static function transform($collect)
    {
        $locale = App::getLocale();

        if ($locale == null) {
            $locale = 'en';
        }

        return $collect->reject(function ($item) use ($locale) {
            $content_locale = $item['content'][$locale];

            $exists = !isset($content_locale['place']);

            if (!$exists) {
                return
                    empty($content_locale['place']['name']) ||
                    empty($content_locale['place']['lat']) ||
                    empty($content_locale['place']['lng']);
            }

            return $exists;
        })->map(function ($item) use ($locale) {
            $content_locale = $item['content'][$locale];

            $typeObject = $item->getTypeObject();

            $result = [
                'id' => $item['id'],

                'name'    => $content_locale['name'],
                'address' => $content_locale['place']['name'],
                'lat'     => $content_locale['place']['lat'],
                'lng'     => $content_locale['place']['lng'],
            ];

            if (method_exists($typeObject, 'display')) {
                $result['display'] = $typeObject->display();
            }

            return $result;
        });
    }
}
