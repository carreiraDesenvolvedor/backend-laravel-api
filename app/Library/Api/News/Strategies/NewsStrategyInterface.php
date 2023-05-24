<?php

namespace App\Library\Api\News\Strategies;

use App\Library\Api\News\QueryBuilder;

interface NewsStrategyInterface {

    public function fetch(string $queryParms): array;

    public function getQueryBuilder():QueryBuilder;

    public function getAuthKey(): string;
}
