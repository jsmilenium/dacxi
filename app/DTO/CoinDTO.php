<?php

namespace App\DTO;

use Illuminate\Database\Eloquent\Model;

class CoinDTO
{
    public string $coin_id;

    public string $symbol;

    public function __construct(string $coin_id, string $symbol)
    {
        $this->coin_id = $coin_id;
        $this->symbol = $symbol;
    }

    public static function fromModel(Model $model): self
    {
        return new self(
            $model->coin_id,
            $model->symbol
        );
    }
}
