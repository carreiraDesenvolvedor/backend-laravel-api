<?php

namespace App\Library\Api\News;


use App\Enums\ApiNewsEnum;
use App\Library\Api\News\Strategies\NewsApiStrategy;
use App\Library\Api\News\Strategies\NewsStrategyInterface;
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

    /**
     * @return TransformedArticle[]
     */
    public function getArticles():array{
        $result = [];
        foreach(ApiNewsEnum::cases() as $apiNewsEnum){
            $apiStrategyInstance = $this->getApiStrategyByKey($apiNewsEnum);
            $response = $this->fetchDataByStrategy($apiStrategyInstance, $apiNewsEnum);
            $result = array_merge($result, $apiStrategyInstance->transformResponse($response));
        }
        return $result;
    }




    public function fetchDataByStrategy(NewsStrategyInterface $apiStrategyInstance, ApiNewsEnum $apiNewsEnum): array{
        return $apiStrategyInstance->fetch($apiStrategyInstance->getQueryBuilder()->buildQuery(
            $this->page,
            $this->keywords,
            $this->fromDate,
            $this->sources,
            $apiStrategyInstance->getAuthKey(),
            $apiNewsEnum
        ));
    }

    private function getApiStrategyByKey(ApiNewsEnum $apiNewsEnum): NewsStrategyInterface{
        return match ($apiNewsEnum){
            ApiNewsEnum::NewsApi => new NewsApiStrategy(),
            ApiNewsEnum::TheGuardian => new TheGuardianStrategy(),
            ApiNewsEnum::NewYorkTimes => new NewYorkTimesStrategy(),
            default => throw new \InvalidArgumentException(message: 'Unhandled Strategy')
        };
    }

}
