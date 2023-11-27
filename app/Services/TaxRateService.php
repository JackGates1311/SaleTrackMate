<?php

namespace App\Services;

use App\Constants;
use App\Enums\AccountType;
use App\Models\TaxRate;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TaxRateService
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(array $data, string $user_id, string $tax_category_id): array
    {
        $result = $this->userService->getUserData($user_id);

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            try {
                $data['tax_category_id'] = $tax_category_id;

                $highestFromDate = TaxRate::where('tax_category_id', $tax_category_id)->max('from_date');

                if ($highestFromDate !== null) {
                    Validator::make($data, [
                        'from_date' => 'required|date|after:' . $highestFromDate,
                    ])->validate();
                } else {
                    Validator::make($data, [
                        'from_date' => 'required|date|after:today',
                    ])->validate();
                }

                $validated_data = Validator::make($data, TaxRate::$rules)->validate();
                $tax_rate = TaxRate::create($validated_data);

                return ['success' => true, 'message' => Constants::TAX_RATE_SAVE_SUCCESS, 'tax_rate' => $tax_rate];
            } catch (Exception $e) {
                return ['success' => false, 'message' => Constants::TAX_RATE_SAVE_FAIL . ': ' . $e->getMessage()];
            }
        } else {
            return ['success' => false, 'message' => Constants::TAX_RATE_SAVE_FAIL . ': ' .
                Constants::PERMISSION_DENIED];
        }
    }

    public function update(array $data, string $id, string $user_id): array
    {
        $result = $this->userService->getUserData($user_id);

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            $tax_rate = TaxRate::find($id);

            if (!$tax_rate) {
                return ['success' => false, 'message' => Constants::TAX_RATE_NOT_FOUND . ': ' . $id];
            }

            try {
                $data['from_date'] = Carbon::parse($data['from_date']);

                $dateChanged = $data['from_date']->ne($tax_rate->from_date);

                $uniqueValidationRule = $dateChanged ? Rule::unique('tax_rates', 'from_date')->
                where('tax_category_id', $tax_rate->tax_category_id) : '';

                $dateInTheFutureRule = $dateChanged ? 'after:' . now()->toDateString() : '';

                $validated_data = Validator::make($data, [
                    'from_date' => ['required', $uniqueValidationRule, 'date', $dateInTheFutureRule],
                    'percentage_value' => 'required|numeric|between:0,100',
                ])->validate();

                $tax_rate->update($validated_data);
                return ['success' => true, 'message' => Constants::TAX_RATE_UPDATE_SUCCESS, 'tax_rate' => $tax_rate];
            } catch (ValidationException|Exception $e) {
                return ['success' => false, 'message' => Constants::TAX_RATE_UPDATE_FAIL . ': ' . $e->getMessage()];
            }
        } else {
            return ['success' => false, 'message' => Constants::TAX_RATE_UPDATE_FAIL . ': ' .
                Constants::PERMISSION_DENIED];
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

    public function destroy($id, string $user_id): array
    {
        $result = $this->userService->getUserData($user_id);

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            $tax_rate = TaxRate::find($id);

            if (!$tax_rate) {
                return ['success' => false, 'message' => Constants::TAX_RATE_NOT_FOUND . ': ' . $id];
            }

            $taxCategory = $tax_rate->taxCategory;

            if (!$taxCategory || $taxCategory->taxRates()->count() <= 1) {
                return ['success' => false, 'message' => Constants::TAX_RATE_DELETE_FAIL . ' ' .
                    'Tax category must have at least one tax rate'];
            }

            try {
                $tax_rate->delete();
                return ['success' => true, 'message' => Constants::TAX_RATE_DELETE_SUCCESS, 'tax_rate' => $tax_rate];
            } catch (Exception $e) {
                return ['success' => false, 'message' => Constants::TAX_RATE_DELETE_FAIL . ': ' . $e->getMessage()];
            }
        } else {
            return ['success' => false, 'message' => Constants::TAX_RATE_DELETE_FAIL . ': ' .
                Constants::PERMISSION_DENIED];
        }
    }
}
