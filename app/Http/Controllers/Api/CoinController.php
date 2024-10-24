<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CoinPriceResource;
use App\Services\CacheService;
use App\Services\CoinService;
use App\Services\CoinPriceService;
use App\Services\CoinGeckoService;
use App\Exceptions\CoinGeckoApiException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CoinController extends Controller
{
    private CoinService $coinService;
    private CoinPriceService $coinPriceService;
    private CoinGeckoService $geckoService;
    private CacheService $cacheService;

    public function __construct(
        CoinService $coinService,
        CoinPriceService $coinPriceService,
        CoinGeckoService $geckoService,
        CacheService $cacheService
    ) {
        $this->cacheService = $cacheService;
        $this->coinService = $coinService;
        $this->coinPriceService = $coinPriceService;
        $this->geckoService = $geckoService;
    }

    public function getCoin(string $symbol)
    {
        try {
            $coin = $this->coinService->findBySymbol($symbol);

            $cacheKey = $this->cacheService->generateCacheKey($coin->id);

            if ($this->cacheService->hasCache($cacheKey)) {
                $coinPrices = $this->cacheService->getCache($cacheKey);
            } else {
                $prices = $this->geckoService->getCoinPrice($coin->coin_id);
                $coinPrices = $this->coinPriceService->saveCoinPrice($coin->id, $prices);
            }

            $data = [
                'coin' => $coin->symbol,
                'prices' => $coinPrices
            ];

            return new CoinPriceResource($data);
        } catch (ModelNotFoundException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Coin Not Found',
                'message' => "Symbol {$symbol} not found in our database"
            ], 404);

        } catch (CoinGeckoApiException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'External API Error',
                'message' => $e->getMessage()
            ], 503);

        } catch (GuzzleException $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'External API Error',
                'message' => 'An error occurred while fetching data from external API'
            ], 503);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Internal Server Error',
                'message' => 'An unexpected error occurred: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }

}
