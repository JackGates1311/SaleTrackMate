<?php

namespace App\Services;

use App\Constants;
use App\Models\TaxRate;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TaxRateService
{
    /**
     * @throws ValidationException
     */
    public function store(array $data): array
    {
        $validated_data = Validator::make($data, TaxRate::$rules)->validate();

        try {
            $tax_rate = TaxRate::create($validated_data);

            return ['success' => true, 'message' => Constants::TAX_RATE_SAVE_SUCCESS, 'tax_rate' => $tax_rate];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::TAX_RATE_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    /**
     * @throws ValidationException
     */
    public function update(array $data, $id): array
    {
        $tax_rate = TaxRate::find($id);

        if (!$tax_rate) {
            return ['success' => false, 'message' => Constants::TAX_RATE_NOT_FOUND . ': ' . $id];
        }

        $validated_data = Validator::make($data, TaxRate::$rules)->validate();

        try {
            $tax_rate->update($validated_data);
            return ['success' => true, 'message' => Constants::TAX_RATE_UPDATE_SUCCESS, 'tax_rate' => $tax_rate];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::TAX_RATE_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function show($id): array
    {
        $tax_rate = TaxRate::find($id);

        if (!$tax_rate) {
            return ['success' => false, 'message' => Constants::TAX_RATE_NOT_FOUND . ': ' . $id];
        }

        return ['success' => true, 'tax_rate' => $tax_rate];
    }
}
