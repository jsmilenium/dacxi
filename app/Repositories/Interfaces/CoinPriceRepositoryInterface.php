<?php

namespace App\Repositories\Interfaces;

use App\Models\CoinPrice;
use Illuminate\Support\Collection;

interface CoinPriceRepositoryInterface
{
    public function create(array $data): CoinPrice;

}
