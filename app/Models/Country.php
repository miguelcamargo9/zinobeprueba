<?php

namespace App\Models;

use Zend\Diactoros\{Request, Uri};
use GuzzleHttp\Client as GuzzleClient;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;


class Country
{
    public function all()
    {
        $config = ['timeout' => 5];
        $guzzle = new GuzzleClient($config);
        $adapter = new GuzzleAdapter($guzzle);

        $request = (new Request())
            ->withUri(new Uri('https://pkgstore.datahub.io/core/country-list/data_json/data/8c458f2d15d9f2119654b29ede6e45b8/data_json.json'))
            ->withMethod('GET');

        $response = $adapter->sendRequest($request);

        return json_decode($response->getBody()->getContents());
    }
}
