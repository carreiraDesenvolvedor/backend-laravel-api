<?php

namespace App\Library\Api\News\Strategies;

use Illuminate\Support\Facades\Http;

class TheGuardianStrategy implements NewsStrategyInterface
{
    public function fetch(): array
    {
        $response = Http::get('https://content.guardianapis.com/search?api-key='.$this->getAuthKey());
        return $response->json();
    }

    public function isAuthRequired(): bool
    {
        return false;
    }

    public function getAuthKey(): string|null
    {
        return 'e6478f0e-980d-4e93-9be3-7303e286a36d';
    }
}
