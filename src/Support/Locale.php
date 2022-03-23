<?php

declare(strict_types=1);

namespace Orchid\Support;

class Locale
{
    /*
     * Source: https://meta.wikimedia.org/wiki/Template:List_of_language_names_ordered_by_code
     */
    private const RTL = [
        'ar', //Arabic
        'arc', //Aramaic
        'ckb', //Kurdish
        'dv', //Divehi
        'fa', //Persian
        'ha', //Hausa
        'he', //Hebrew
        'khw', //Khowar
        'ks', //Kashmiri
        'ps', //Pashto
        'sd', //Sindhi
        'ur', //Urdu
        'uz_AF', //Uzbeki Afghanistan
        'yi', //Yiddish
    ];

    /**
     * @param string|null $locale
     *
     * @return string
     */
    public static function currentDir(string $locale = null): string
    {
        $locale = $locale ?? app()->getLocale();

        return in_array($locale, self::RTL) ? "rtl" : "ltr";
    }
}
