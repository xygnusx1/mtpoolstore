<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

class YouTrackController extends Controller
{
    function __construct()
    {
        app()->singleton("ytclient", function () {
            // Instantiate PSR-7 HTTP Client
            $psrHttpClient = new \GuzzleHttp\Client([
                'base_uri' => 'https://galactic-enterprise.youtrack.cloud',
                'debug' => false,
            ]);

            // Instantiate YouTrack API HTTP Client Adapter
            $httpClient = new \Cog\YouTrack\Rest\HttpClient\GuzzleHttpClient($psrHttpClient);

            // Instantiate YouTrack API Token Authorizer
            $authorizer = new \Cog\YouTrack\Rest\Authorizer\TokenAuthorizer('perm-YXV0bzAzNA==.NjAtMw==.0p7FrB7Y6sf3H52nqLBehwGm6qGg3k');

            // Instantiate YouTrack API Client
            $youtrack = new \Cog\YouTrack\Rest\Client\YouTrackClient($httpClient, $authorizer, 'api');

            return $youtrack;
        });
    }

    public function show($slug)
    {
        $ytclient = app("ytclient");
//        $apiResponse = $ytclient->get("/issues/PAP034-1851");

//        $apiResponse = $ytclient->get('admin/projects');
//        $apiResponse = $ytclient->request('get', '/users', ["fields=id,login,fullName,email,name"], ['debug'=>true]);
        $apiResponse = $ytclient->request('get', '/users?fields=id,name,email');
        Log::info($apiResponse->statusCode());
        Log::info($apiResponse->isSuccess());
        Log::info(json_decode($apiResponse->body()));
//        Log::info($apiResponse->toArray());

        return view('youtrack/ytissue', [
            'yti' => json_decode($apiResponse->body())
        ]);
    }
}
