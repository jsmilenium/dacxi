<?php

namespace App\Repositories;

use App\Models\Coin;
use App\Repositories\Interfaces\CoinRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CoinRepository implements CoinRepositoryInterface
{
    private Coin $model;

    public function __construct(Coin $model)
    {
        $this->model = $model;
    }

    public function findBySymbol(string $coin): Coin
    {
        return $this->model->where('symbol', $coin)->first();
    }

}
