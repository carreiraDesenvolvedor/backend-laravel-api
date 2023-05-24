<?php

namespace App\Library\Api\News\Strategies;

use App\Enums\ApiNewsQueryFiltersEnum;
use App\Library\Api\News\QueryBuilder;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Http;

class NewsApiStrategy implements NewsStrategyInterface {

    public function getQueryBuilder(): QueryBuilder{
        return new QueryBuilder('page', 'q','from','source','pagesize','apiKey');
    }

    public function fetch(string $queryParms): array{

        $response = Http::get('https://newsapi.org/v2/everything?'.$queryParms);
        return $response->json();
    }


    public function getAuthKey(): string
    {
        return '5e5b74d55a4148bea24f7c00b1422c61';
    }
}
