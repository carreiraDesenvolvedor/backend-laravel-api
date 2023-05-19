<?php

namespace App\Library\Api\News;


use App\Enums\ApiNewsEnum;
use App\Library\Api\News\Strategies\NewsApiStrategy;
use App\Library\Api\News\Strategies\TheGuardianStrategy;
use App\Library\Api\News\Strategies\NewYorkTimesStrategy;

class NewsApiService {


    public function fetchData(ApiNewsEnum $apiNewsEnum): array{

        $strategyClass = match ($apiNewsEnum){
            ApiNewsEnum::NewsApi => new NewsApiStrategy(),
            ApiNewsEnum::TheGuardian => new TheGuardianStrategy(),
            ApiNewsEnum::NewYorkTimes => new NewYorkTimesStrategy(),
            default => throw new \InvalidArgumentException(message: 'Unhandled Strategy')
        };

        return $strategyClass->fetch();

    }


}
