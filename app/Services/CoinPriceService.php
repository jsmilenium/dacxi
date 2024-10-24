<?php

namespace App\Services;

use App\Repositories\CoinPriceRepository;
use App\Services\CacheService;

class CoinPriceService
{

    private CoinPriceRepository $coinPriceRepository;

    public function __construct(
        CoinPriceRepository $coinPriceRepository,
        CacheService $cacheService
    ) {
        $this->coinPriceRepository = $coinPriceRepository;
        $this->cacheService = $cacheService;
    }

    public function saveCoinPrice(string $coin_id, array $prices): array
    {
        $savedPrices = [];

        foreach ($prices as $price => $value) {
            $this->coinPriceRepository->create([
                'coin_id' => $coin_id,
                'price' => $value,
            ]);

            $savedPrices[] = [
                'coin_id' => $coin_id,
                'price' => $value,
            ];
        }

        $cacheKey = $this->cacheService->generateCacheKey($coin_id);
        $this->cacheService->putCache($cacheKey, $savedPrices);

        return $savedPrices;
    }
}
