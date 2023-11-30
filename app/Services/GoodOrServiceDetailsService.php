<?php

namespace App\Services;

use App\Constants;
use App\Models\GoodOrServiceDetails;
use Exception;
use Illuminate\Support\Facades\Validator;

class GoodOrServiceDetailsService
{
    public function store(array $data): array
    {
        try {
            $validated_data = Validator::make($data, GoodOrServiceDetails::$rules)->validate();
            $good_or_service_details = GoodOrServiceDetails::create($validated_data);
            return ['success' => true, 'message' => Constants::GOOD_OR_SERVICE_DETAILS_SAVE_SUCCESS,
                'good_or_service_details' => $good_or_service_details];
        } catch (Exception $e) {
            return ['success' => false,
                'message' => Constants::GOOD_OR_SERVICE_DETAILS_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function update(array $data, $id): array
    {
        $good_or_service_details = GoodOrServiceDetails::find($id);

        if (!$good_or_service_details) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_DETAILS_NOT_FOUND . ": " . $id];
        }

        try {
            $validated_data = Validator::make($data, GoodOrServiceDetails::$rules)->validate();
            $good_or_service_details->update($validated_data);
            return ['success' => true, 'message' => Constants::GOOD_OR_SERVICE_DETAILS_UPDATE_SUCCESS,
                'good_or_service_details' => $good_or_service_details];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::GOOD_OR_SERVICE_DETAILS_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }
}
