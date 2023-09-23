<?php

namespace App\Services;

use App\Constants;
use App\Models\UnitOfMeasure;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UnitOfMeasureService
{
    /**
     * @throws ValidationException
     */
    public function store(array $data): array
    {
        $validated_data = Validator::make($data, UnitOfMeasure::$rules)->validate();

        try {
            $unit_of_measure = UnitOfMeasure::create($validated_data);
            return ['success' => true, 'message' => Constants::UNIT_OF_MEASURE_SAVE_SUCCESS,
                'unit_of_measure' => $unit_of_measure];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    /**
     * @throws ValidationException
     */
    public function update(array $data, $id): array
    {
        $unit_of_measure = UnitOfMeasure::find($id);

        if (!$unit_of_measure) {
            return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_NOT_FOUND . ': ' . $id];
        }

        $validated_data = Validator::make($data, UnitOfMeasure::$rules)->validate();

        try {
            $unit_of_measure->update($validated_data);
            return ['success' => true, 'message' => Constants::UNIT_OF_MEASURE_UPDATE_SUCCESS,
                'unit_of_measure' => $unit_of_measure];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function show($id): array
    {
        $unit_of_measure = UnitOfMeasure::find($id);

        if (!$unit_of_measure) {
            return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_NOT_FOUND . ': ' . $id];
        }

        return ['success' => true, 'unit_of_measure' => $unit_of_measure];
    }

    public function index(): array
    {
        $unit_of_measures = UnitOfMeasure::all();

        return ['unit_of_measures' => $unit_of_measures];
    }
}
