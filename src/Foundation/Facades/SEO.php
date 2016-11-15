<?php namespace Orchid\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Foundation\Models\SEO as SEOModel;

class SEO extends Facade
{
    /**
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return SEOModel::class;
    }

    /**
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        $seo = new SEOModel();

        return $seo->$method($args);
    }
}
