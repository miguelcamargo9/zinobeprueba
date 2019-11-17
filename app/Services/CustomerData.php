<?php

namespace App\Services;

use Zend\Diactoros\{Request, Uri};
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;


class CustomerData
{
    // Create a request
    public function getLoadDir($uri)
    {
        $config = ['timeout' => 5];
        $guzzle = new GuzzleClient($config);
        $adapter = new GuzzleAdapter($guzzle);

        $request = (new Request())
            ->withUri(new Uri($uri))
            ->withMethod('GET');

        $response = $adapter->sendRequest($request);

        return json_decode($response->getBody()->getContents());
    }
}
