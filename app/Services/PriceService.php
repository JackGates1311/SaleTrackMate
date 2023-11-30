<?php

namespace App\Services;

use App\Constants;
use App\Models\Price;
use Exception;
use Carbon\Carbon;
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

        $data['good_or_service_id'] = $price->good_or_service_id;

        if (!$price) {
            return ['success' => false, 'message' => Constants::PRICE_NOT_FOUND . ': ' . $id];
        }

        $expiration_date = Carbon::parse($price->expiration_date);
        $current_date = Carbon::now();

        if ($expiration_date < $current_date) {
            return ['success' => false, 'message' => Constants::PRICE_EXPIRED];
        }

        if (isset($data['expiration_date']) && $data['expiration_date'] !== $price->expiration_date) {
            $new_expiration_date = Carbon::parse($data['expiration_date']);

            if ($new_expiration_date < $current_date) {
                return ['success' => false, 'message' => Constants::NEW_EXPIRATION_DATE_PAST];
            }

            $existing_prices = Price::where('good_or_service_id', $data['good_or_service_id'])
                ->where('expiration_date', $new_expiration_date)
                ->where('id', '!=', $id)
                ->get();

            if ($existing_prices->isNotEmpty()) {
                return ['success' => false, 'message' => Constants::DUPLICATE_EXPIRATION_DATE];
            }
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

    public function destroy($id): array
    {
        $price = Price::find($id);

        if (!$price) {
            return ['success' => false, 'message' => Constants::PRICE_NOT_FOUND . ': ' . $id];
        }

        $expiration_date = Carbon::parse($price->expiration_date);
        $current_date = Carbon::now();

        if ($expiration_date < $current_date) {
            return ['success' => false, 'message' => Constants::PRICE_EXPIRED];
        }

        $good_or_service = $price->goodOrService;

        if (!$good_or_service || $good_or_service->prices->count() <= 1) {
            return ['success' => false, 'message' => 'Good or service must have at least one active price'];
        }

        $active_prices = $good_or_service->prices->where('expiration_date', '>', $current_date);

        if ($active_prices->isEmpty()) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_DELETE_FAIL . ': ' . $id];
        }

        try {
            $price->delete();
            return ['success' => true, 'message' => Constants::PRICE_DELETE_SUCCESS,
                'price' => $price];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::PRICE_DELETE_FAIL . ': ' .
                $e->getMessage()];
        }
    }
}
