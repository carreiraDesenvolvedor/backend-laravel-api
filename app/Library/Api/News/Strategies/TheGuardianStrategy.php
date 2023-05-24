<?php

namespace App\Library\Api\News\Strategies;

use App\Library\Api\News\QueryBuilder;
use Illuminate\Support\Facades\Http;

class TheGuardianStrategy implements NewsStrategyInterface
{

    public function getQueryBuilder(): QueryBuilder{
        return new QueryBuilder('page', 'q','from-date','','page-size','api-key');
    }
    public function fetch(string $queryParms): array
    {
        $response = Http::get('https://content.guardianapis.com/search?'.$queryParms);
        return $response->json();
    }

    public function getAuthKey(): string
    {
        return 'e6478f0e-980d-4e93-9be3-7303e286a36d';
    }

}
