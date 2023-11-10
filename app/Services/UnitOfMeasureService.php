<?php

namespace App\Services;

use App\Constants;
use App\Enums\AccountType;
use App\Models\UnitOfMeasure;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UnitOfMeasureService
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(array $data, string $user_id): array
    {
        $result = $this->userService->getUserData($user_id);

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            try {
                $validated_data = Validator::make($data, UnitOfMeasure::$rules)->validate();
                $unit_of_measure = UnitOfMeasure::create($validated_data);
                return ['success' => true, 'message' => Constants::UNIT_OF_MEASURE_SAVE_SUCCESS,
                    'unit_of_measure' => $unit_of_measure];
            } catch (ValidationException $e) {
                return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_SAVE_FAIL . ': ' . $e->getMessage()];
            }
        } else {
            return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_SAVE_FAIL . ': ' .
                Constants::PERMISSION_DENIED];
        }
    }

    public function update(array $data, string $id, string $user_id): array
    {
        $result = $this->userService->getUserData($user_id);

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            $unit_of_measure = UnitOfMeasure::find($id);

            if (!$unit_of_measure) {
                return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_NOT_FOUND . ': ' . $id];
            }

            try {
                $validated_data = Validator::make($data, UnitOfMeasure::$rules)->validate();
                $unit_of_measure->update($validated_data);
                return ['success' => true, 'message' => Constants::UNIT_OF_MEASURE_UPDATE_SUCCESS,
                    'unit_of_measure' => $unit_of_measure];
            } catch (Exception $e) {
                return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_UPDATE_FAIL . ': ' . $e->getMessage()];
            }
        } else {
            return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_SAVE_FAIL . ': ' .
                Constants::PERMISSION_DENIED];
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

    public function destroy(string $id, string $user_id): array
    {
        $result = $this->userService->getUserData($user_id);

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            $unit_of_measure = UnitOfMeasure::find($id);

            if (!$unit_of_measure) {
                return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_NOT_FOUND . ': ' . $id];
            }

            try {
                $unit_of_measure->delete();
                return ['success' => true, 'message' => Constants::UNIT_OF_MEASURE_DELETE_SUCCESS,
                    'unit_of_measure' => $unit_of_measure];
            } catch (Exception $e) {
                return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_DELETE_FAIL . ': ' .
                    $e->getMessage()];
            }
        } else {
            return ['success' => false, 'message' => Constants::UNIT_OF_MEASURE_SAVE_FAIL . ': ' .
                Constants::PERMISSION_DENIED];
        }
    }
}
