<?php

namespace App\Services;

use App\Constants;
use App\Models\Price;
use Exception;
use Illuminate\Support\Facades\Validator;

class PriceService
{
    public function store(array $data, string $good_or_service_id): array
    {
        $data['good_or_service_id'] = $good_or_service_id;

        try {

            $highest_expiration_date = Price::where('good_or_service_id', $good_or_service_id)->max('expiration_date');

            if ($highest_expiration_date !== null) {
                Validator::make($data, ['expiration_date' => 'required|date|after:' . $highest_expiration_date
                ])->validate();
            } else {
                Validator::make($data, [
                    'expiration_date' => 'required|date|after:today',
                ])->validate();
            }

            $validated_data = Validator::make($data, Price::$rules)->validate();
            $price = Price::create($validated_data);

            return ['success' => true, 'message' => Constants::PRICE_SAVE_SUCCESS, 'price' => $price];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::PRICE_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function update(array $data, $id): array
    {
        $price = Price::find($id);

        if (!$price) {
            return ['success' => false, 'message' => Constants::PRICE_NOT_FOUND . ': ' . $id];
        }

        try {
            $validated_data = Validator::make($data, Price::$rules)->validate();
            $price->update($validated_data);
            return ['success' => true, 'message' => Constants::PRICE_UPDATE_SUCCESS, 'price' => $price];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::PRICE_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function show($id): array
    {
        $price = Price::find($id);

        if (!$price) {
            return ['success' => false, 'message' => Constants::PRICE_NOT_FOUND . ': ' . $id];
        }

        return ['success' => true, 'price' => $price];
    }

    public function getActualPrice($prices, $date)
    {
        $valid_prices = $prices
            ->where('expiration_date', '>=', $date)
            ->sortBy('expiration_date');

        if ($valid_prices->isEmpty()) {
            $actual_price = $prices->sortByDesc('expiration_date')->first();
            $actual_price['all_prices_expired'] = true;
            return $actual_price;
        }

        $actual_price = $valid_prices->first();
        $actual_price['all_prices_expired'] = false;
        return $actual_price;
    }
}
