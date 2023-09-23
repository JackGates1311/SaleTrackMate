<?php

namespace App\Services;

use App\Constants;
use App\Models\Price;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PriceService
{
    /**
     * @throws ValidationException
     */
    public function store(array $data): array
    {
        $validated_data = Validator::make($data, Price::$rules)->validate();

        try {
            $price = Price::create($validated_data);
            return ['success' => true, 'message' => Constants::PRICE_SAVE_SUCCESS, 'price' => $price];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::PRICE_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    /**
     * @throws ValidationException
     */
    public function update(array $data, $id): array
    {
        $price = Price::find($id);

        if (!$price) {
            return ['success' => false, 'message' => Constants::PRICE_NOT_FOUND . ': ' . $id];
        }

        $validated_data = Validator::make($data, Price::$rules)->validate();

        try {
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
}
