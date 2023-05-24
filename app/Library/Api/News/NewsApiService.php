<?php

namespace App\Library\Api\News;


use App\Enums\ApiNewsEnum;
use App\Library\Api\News\Strategies\NewsApiStrategy;
use App\Library\Api\News\Strategies\TheGuardianStrategy;
use App\Library\Api\News\Strategies\NewYorkTimesStrategy;
use Illuminate\Support\Facades\Date;

class NewsApiService {

    private int $page;
    private array $keywords;

    private string $fromDate;

    private array $sources;


    public function __construct(int $page, array $keywords, string $fromDate, array $sources)
    {
        $this->page = $page;
        $this->keywords = $keywords;
        $this->fromDate = $fromDate;
        $this->sources = $sources;
    }


    public function fetchDataByStrategy(ApiNewsEnum $apiNewsEnum): array{

        $strategyClass = match ($apiNewsEnum){
            ApiNewsEnum::NewsApi => new NewsApiStrategy(),
            ApiNewsEnum::TheGuardian => new TheGuardianStrategy(),
            ApiNewsEnum::NewYorkTimes => new NewYorkTimesStrategy(),
            default => throw new \InvalidArgumentException(message: 'Unhandled Strategy')
        };

        $queryParms = $strategyClass->getQueryBuilder()->buildQuery(
            $this->page,
            $this->keywords,
            $this->fromDate,
            $this->sources,
            $strategyClass->getAuthKey(),
            $apiNewsEnum
        );

        return $strategyClass->fetch($queryParms);

    }


}
