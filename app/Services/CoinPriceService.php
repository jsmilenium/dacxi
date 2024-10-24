<?php

namespace App\Services;

use App\Repositories\CoinPriceRepository;
use App\Services\CacheService;
use App\Services\CoinGeckoService;

class CoinPriceService
{

    private CoinPriceRepository $coinPriceRepository;
    private CacheService $cacheService;
    private CoinGeckoService $geckoService;

    public function __construct(
        CoinPriceRepository $coinPriceRepository,
        CacheService $cacheService,
        CoinGeckoService $geckoService
    ) {
        $this->coinPriceRepository = $coinPriceRepository;
        $this->cacheService = $cacheService;
        $this->geckoService = $geckoService;
    }

    public function saveCoinPrice(string $coin_id, array $prices): array
    {
        $savedPrices = [];

        foreach ($prices as $currency => $value) {
            $this->coinPriceRepository->create([
                'coin_id' => $coin_id,
		'currency' => $currency,
                'price' => $value,
            ]);

            $savedPrices[] = [
                'coin_id' => $coin_id,
		'currency' => $currency,
                'price' => $value,
            ];
        }

        $cacheKey = $this->cacheService->generateCacheKey($coin_id);
        $this->cacheService->putCache($cacheKey, $savedPrices);

        return $savedPrices;
    }

    public function getCoinPrices($coin)
    {
        $cacheKey = $this->cacheService->generateCacheKey($coin->id);

        if ($this->cacheService->hasCache($cacheKey)) {
            return $this->cacheService->getCache($cacheKey);
        } else {
            $prices = $this->geckoService->getCoinPrice($coin->coin_id);
            return $this->saveCoinPrice($coin->id, $prices);
        }
    }
}
