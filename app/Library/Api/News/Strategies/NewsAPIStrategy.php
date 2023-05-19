<?php

namespace App\Library\Api\News\Strategies;

use Illuminate\Support\Facades\Http;

class NewsApiStrategy implements NewsStrategyInterface {
    public function fetch(): array{

        $response = Http::get('https://newsapi.org/v2/everything?q=bitcoin&apiKey='.$this->getAuthKey());
        return $response->json();
    }


    public function getAuthKey(): string|null
    {
        return '5e5b74d55a4148bea24f7c00b1422c61';
    }
}
