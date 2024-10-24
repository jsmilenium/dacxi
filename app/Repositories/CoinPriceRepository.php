<?php

namespace App\Repositories;

use App\Models\CoinPrice;
use App\Repositories\Interfaces\CoinPriceRepositoryInterface;
use Illuminate\Support\Collection;
use App\DTO\CoinPriceDTO;

class CoinPriceRepository implements CoinPriceRepositoryInterface
{
    private CoinPrice $model;

    public function __construct(CoinPrice $model)
    {
        $this->model = $model;
    }

    public function create(array $data): CoinPrice
    {
        return $this->model->create([
            'coin_id' => $data['coin_id'],
            'price' => $data['price'],
        ]);
    }

    public function list(): Collection
    {
        return $this->model
            ->with('coin')
            ->orderBy('created_at', 'desc')
            ->get();
    }

}
