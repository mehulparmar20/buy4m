<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use GuzzleHttp\Client;
use Goutte\Client;
use Illuminate\Support\Str;

class AmazonController extends Controller
{
    public function fetchAmazonData(Request $request)
    {
        $url=$request->url;
        $client = new Client();
        $crawler = $client->request('GET', $url);

        $title = $crawler->filter('title')->text();
        $price = $crawler->filter('.a-price .a-offscreen')->text();
        return [
            'title' => $title,
            'price' => $price,
        ];
    }
}
