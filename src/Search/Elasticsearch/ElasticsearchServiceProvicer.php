<?php

namespace Orchid\Search\Elasticsearch;

use Elasticsearch\ClientBuilder as Elasticsearch;
use Illuminate\Support\ServiceProvider;
use Laravel\Scout\EngineManager;

class ElasticsearchServiceProvicer extends ServiceProvider
{
    /**
     * Boot the application events.
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/scout.php', 'scout'
        );

        resolve(EngineManager::class)->extend('elasticsearch', function () {
            return new ElasticsearchEngine(
                Elasticsearch::fromConfig(config('scout.elasticsearch.config')),
                config('scout.elasticsearch.index'),
                config('scout.elasticsearch.version')
            );
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
