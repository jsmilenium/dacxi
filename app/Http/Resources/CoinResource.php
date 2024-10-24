<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoinResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'prices' => $this->prices,
        ];
    }
}
