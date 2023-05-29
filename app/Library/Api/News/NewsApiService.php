<?php

namespace App\Library\Api\News;


use App\Enums\ApiNewsEnum;
use App\Library\Api\News\Strategies\AbstractApiStrategy;
use App\Library\Api\News\Strategies\NewsAPIStrategy;
use App\Library\Api\News\Strategies\NewsStrategyInterface;
use App\Library\Api\News\Strategies\TheGuardianStrategy;
use App\Library\Api\News\Strategies\NewYorkTimesStrategy;

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
            $response = $this->fetchDataByStrategy($apiStrategyInstance);
            $result = array_merge($result, $response);
        }
        return $result;
    }

    /**
     * @param NewsStrategyInterface $apiStrategyInstance
     * @return TransformedArticle[]
     */
    public function fetchDataByStrategy(NewsStrategyInterface $apiStrategyInstance): array{
        return $apiStrategyInstance->fetch(
            $this->page,
            $this->keywords,
            $this->fromDate,
            $this->sources,
        );
    }

    private function getApiStrategyByKey(ApiNewsEnum $apiNewsEnum): AbstractApiStrategy{
        return match ($apiNewsEnum){
            ApiNewsEnum::NewsApi => new NewsAPIStrategy(),
            ApiNewsEnum::TheGuardian => new TheGuardianStrategy(),
            ApiNewsEnum::NewYorkTimes => new NewYorkTimesStrategy(),
            default => throw new \InvalidArgumentException(message: 'Unhandled Strategy')
        };
    }

}
