<?php

namespace App\Services;

use App\Constants;
use App\Models\GoodOrServiceDetails;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GoodOrServiceDetailsService
{
    /**
     * @throws ValidationException
     */
    public function store(array $data): array
    {
        $validated_data = Validator::make($data, GoodOrServiceDetails::$rules)->validate();

        try {
            $good_or_service_details = GoodOrServiceDetails::create($validated_data);
            return ['success' => true, 'message' => Constants::GOOD_OR_SERVICE_DETAILS_SAVE_SUCCESS,
                'good_or_service_details' => $good_or_service_details];
        } catch (Exception $e) {
            return ['success' => false,
                'message' => Constants::GOOD_OR_SERVICE_DETAILS_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    /**
     * @throws ValidationException
     */
    public function update(array $data, $id): array
    {
        $good_or_service_details = GoodOrServiceDetails::find($id);

        if (!$good_or_service_details) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_DETAILS_NOT_FOUND . ": " . $id];
        }

        $validated_data = Validator::make($data, GoodOrServiceDetails::$rules)->validate();

        try {
            $good_or_service_details->update($validated_data);
            return ['success' => true, 'message' => Constants::GOOD_OR_SERVICE_DETAILS_UPDATE_SUCCESS,
                'good_or_service_details' => $good_or_service_details];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_DETAILS_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }

    // public function destroy($id)
}
