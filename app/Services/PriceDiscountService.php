<?php

namespace App\Services;

use App\Constants;
use App\Models\PriceDiscount;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class PriceDiscountService
{
    public function store(array $data, string $good_or_service_id): array
    {
        try {
            $data['good_or_service_id'] = $good_or_service_id;

            $from_date = Carbon::parse($data['from_date']);
            $current_date = Carbon::now();

            if ($from_date <= $current_date) {
                return ['success' => false, 'message' => Constants::FROM_DATE_IN_PAST];
            }

            $due_date = Carbon::parse($data['due_date']);

            if ($due_date <= $from_date) {
                return ['success' => false, 'message' => Constants::DUE_DATE_INVALID];
            }

            $existing_discount = $this->getExistingDiscount($good_or_service_id, $from_date, $due_date);

            if ($existing_discount) {
                return ['success' => false, 'message' => Constants::DATE_RANGE_OVERLAP];
            }

            $validated_data = Validator::make($data, PriceDiscount::$rules)->validate();
            $price_discount = PriceDiscount::create($validated_data);

            return ['success' => true, 'message' => Constants::PRICE_DISCOUNT_SAVE_SUCCESS,
                'price_discount' => $price_discount];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function update(array $data, $id): array
    {
        $price_discount = PriceDiscount::find($id);

        if (!$price_discount) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_NOT_FOUND . ': ' . $id];
        }

        $data['good_or_service_id'] = $price_discount->good_or_service_id;

        $current_date = Carbon::now();

        if ($price_discount->due_date < $current_date) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_EXPIRED];
        }

        try {
            $validated_data = Validator::make($data, PriceDiscount::$rules)->validate();

            $from_date = Carbon::parse($validated_data['from_date']);
            $due_date = Carbon::parse($validated_data['due_date']);

            if ($data['from_date'] == $price_discount->from_date && $from_date <= $current_date) {
                return ['success' => false, 'message' => Constants::FROM_DATE_IN_PAST];
            }

            $existing_discount = $this->getExistingDiscount($price_discount->good_or_service_id, $from_date, $due_date,
                $price_discount->id);

            if ($existing_discount) {
                return ['success' => false, 'message' => Constants::DATE_RANGE_OVERLAP];
            }

            $price_discount->update($validated_data);
            return ['success' => true, 'message' => Constants::PRICE_DISCOUNT_UPDATE_SUCCESS,
                'price_discount' => $price_discount];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function destroy($id): array
    {
        $price_discount = PriceDiscount::find($id);

        if (!$price_discount) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_NOT_FOUND . ': ' . $id];
        }

        $current_date = Carbon::now();

        if ($price_discount->due_date <= $current_date) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_EXPIRED];
        }

        try {
            $price_discount->delete();
            return ['success' => true, 'message' => Constants::PRICE_DISCOUNT_DELETE_SUCCESS,
                'price_discount' => $price_discount];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_DELETE_FAIL . ' ' . $e->getMessage()];
        }
    }

    public function getExistingDiscount(string  $good_or_service_id, Carbon $from_date, Carbon $due_date,
                                        ?string $current_discount_id = null): mixed
    {
        $query = PriceDiscount::where('good_or_service_id', $good_or_service_id)
            ->where(function ($query) use ($from_date, $due_date) {
                $query->whereBetween('from_date', [$from_date, $due_date])
                    ->orWhereBetween('due_date', [$from_date, $due_date])
                    ->orWhere(function ($query) use ($from_date, $due_date) {
                        $query->where('from_date', '<=', $from_date)
                            ->where('due_date', '>=', $due_date);
                    });
            });

        if ($current_discount_id) {
            $query->where('id', '!=', $current_discount_id);
        }

        return $query->first();
    }

    public function show($id): array
    {
        $price_discount = PriceDiscount::find($id);

        if (!$price_discount) {
            return ['success' => false, 'message' => Constants::PRICE_DISCOUNT_NOT_FOUND . ': ' . $id];
        }

        return ['success' => true, 'price_discount' => $price_discount];
    }

    public function getActualPriceDiscount($price_discounts, $date)
    {
        foreach ($price_discounts as $price_discount) {
            $from_date = Carbon::parse($price_discount->from_date);
            $due_date = Carbon::parse($price_discount->due_date);
            if ($from_date <= $date && $due_date > $date) {
                return $price_discount;
            }
        }

        return null;
    }
}
