<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Elasticsearch\ClientBuilder;

class ElasticsearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        
        $this->app->singleton('Elasticsearch\Client', function ($app) {
            return ClientBuilder::create()
                ->setHosts([config('services.elasticsearch.host')])
                ->build();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
