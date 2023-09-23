<?php

namespace App\Services;

use App\Constants;
use App\Models\PriceDiscount;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class PriceDiscountService
{
    /**
     * @throws ValidationException
     */
    public function store(array $data): array
    {
        $validated_data = Validator::make($data, PriceDiscount::$rules)->validate();

        try {
            $price_discount = PriceDiscount::create($validated_data);
            return ['success' => true, 'message' => Constants::PRICE_DISCOUNT_SAVE_SUCCESS,
                'price_discount' => $price_discount];
        } catch (Exception $e) {
            return ['success' => false, 'messsage' => Constants::PRICE_DISCOUNT_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    /**
     * @throws ValidationException
     */
    public function update(array $data, $id): array
    {
        $price_discount = PriceDiscount::find($id);

        if (!$price_discount) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_NOT_FOUND . ': ' . $id];
        }

        $validated_data = Validator::make($data, PriceDiscount::$rules)->validate();

        try {
            $price_discount->update($validated_data);
            return ['success' => true, 'message' => Constants::PRICE_DISCOUNT_UPDATE_SUCCESS,
                'price_discount' => $price_discount];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function show($id): array
    {
        $price_discount = PriceDiscount::find($id);

        if (!$price_discount) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_NOT_FOUND . ': ' . $id];
        }

        return ['success' => true, 'price_discount' => $price_discount];
    }
}
