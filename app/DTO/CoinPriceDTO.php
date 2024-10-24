<?php

namespace App\DTO;

use Illuminate\Database\Eloquent\Model;

class CoinPriceDTO
{

    public string $coin_id;
    public float $price;

    public function __construct(string $coin_id, float $price)
    {
        $this->coin_id = $coin_id;
        $this->price = $price;
    }

    public static function fromModel(Model $model): self
    {
        return new self(
            $model->coin_id,
            $model->price
        );
    }
}
