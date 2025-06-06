<?php

namespace App\Providers;

use Cog\YouTrack\Rest\Authorizer\TokenAuthorizer;
use Cog\YouTrack\Rest\Client\YouTrackClient;
use Cog\YouTrack\Rest\HttpClient\GuzzleHttpClient;
use Illuminate\Support\ServiceProvider;

class YouTrackServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
//        $this->app->singleton(Connection::class, function (Application $app) {
//            return new Connection(config('riak'));
//        });

        app()->singleton("ytclient", function () : YouTrackClient {
            // Instantiate PSR-7 HTTP Client
            $psrHttpClient = new \GuzzleHttp\Client([
                'base_uri' => 'https://galactic-enterprise.youtrack.cloud',
                'debug' => false,
            ]);

            // Instantiate YouTrack API HTTP Client Adapter
            $httpClient = new GuzzleHttpClient($psrHttpClient);
            // Instantiate YouTrack API Token Authorizer
            $authorizer = new TokenAuthorizer('perm-YXV0bzAzNA==.NjAtMw==.0p7FrB7Y6sf3H52nqLBehwGm6qGg3k');
            // Instantiate YouTrack API Client
            $youtrack = new YouTrackClient($httpClient, $authorizer, 'api');

            return $youtrack;
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
