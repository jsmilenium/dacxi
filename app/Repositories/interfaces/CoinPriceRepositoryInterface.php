<?php

namespace App\Repositories\interfaces;

use App\Models\CoinPrice;
use Illuminate\Support\Collection;

interface CoinPriceRepositoryInterface
{
    public function create(array $data): CoinPrice;
    public function list(): Collection;
}
