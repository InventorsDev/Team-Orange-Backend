<?php

namespace App\Services;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ArticleService
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function baseUri()
    {
        return config('article.baseUrl');
    }

    public function getArticles()
    {
        $api_key = config('article.apiKey');

        $query = $this->request->input('q');

        $url = $this->baseUri() . "everything?q=$query&apiKey=$api_key";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->get($url);


        if ($response->status() != 200) {
            throw new Exception($response['message']);
        }

        return json_decode($response->body(), true);
    }
}
