<?php

namespace App\Library\Api\News\Strategies;

interface NewsStrategyInterface {

    public function fetch(): array;

    public function getAuthKey(): string | null;
}
