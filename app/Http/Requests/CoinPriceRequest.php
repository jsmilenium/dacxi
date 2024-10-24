<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CoinPriceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'coin_id' => 'required|exists:coins,id',
            'price' => 'required|numeric|min:0',
        ];
    }
}
