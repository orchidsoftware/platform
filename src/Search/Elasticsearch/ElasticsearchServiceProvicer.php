<?php

namespace Orchid\Search\Elasticsearch;

use Laravel\Scout\EngineManager;
use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder as Elasticsearch;

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
