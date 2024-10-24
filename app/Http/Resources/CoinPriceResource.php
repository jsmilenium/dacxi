<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CoinPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
	$prices = collect($this->resource['prices'])->map(function ($price) {
            return [
                'currency' => $price['currency'],
                'price' => $price['price'],
            ];
        })->all();

        return [
            'coin' => $this->resource['coin'],
            'prices' => $prices,
        ];
    }
}
