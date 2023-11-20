<?php

namespace App\Services;

use App\Constants;
use App\Enums\AccountType;
use App\Models\TaxCategory;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TaxCategoryService
{
    private TaxRateService $taxRateService;
    private UserService $userService;

    public function __construct(TaxRateService $taxRateService, UserService $userService)
    {
        $this->taxRateService = $taxRateService;
        $this->userService = $userService;
    }

    public function store(array $data, string $user_id): array
    {
        $result = $this->userService->getUserData($user_id);

        //TODO Add DB transaction logic there ... (make cascade delete of tax rates while deleting tax category)

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            try {

                DB::beginTransaction();

                try {

                    if (!isset($data['tax_rate']['from_date'])) {
                        $data['tax_rate']['from_date'] = Carbon::now()->startOfDay();
                    }

                    $validated_data = Validator::make($data, TaxCategory::$rules)->validate();

                    $tax_category = TaxCategory::create($validated_data);

                    $result = $this->taxRateService->store($data['tax_rate'], $user_id, $tax_category->id);

                    if ($result['success']) {
                        DB::commit();
                        return ['success' => true, 'message' => Constants::TAX_CATEGORY_SAVE_SUCCESS,
                            'tax_category' => $tax_category];
                    } else {
                        DB::rollBack();
                        return ['success' => false, 'message' => Constants::TAX_CATEGORY_SAVE_FAIL . ': ' .
                            $result['message']];
                    }

                } catch (Exception $e) {
                    DB::rollBack();
                    return ['success' => false, 'message' => Constants::TAX_CATEGORY_SAVE_FAIL . ': ' .
                        $e->getMessage()];
                }

            } catch (Exception $e) {
                return ['success' => false, 'message' => Constants::TAX_CATEGORY_SAVE_FAIL . ': ' . $e->getMessage()];
            }
        } else {
            return ['success' => false, 'message' => Constants::TAX_CATEGORY_SAVE_FAIL . ': ' .
                Constants::PERMISSION_DENIED];
        }
    }

    public function update(array $data, string $id, string $user_id): array
    {
        $result = $this->userService->getUserData($user_id);

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            $tax_category = TaxCategory::find($id);
            $data['tax_rate_id'] = $tax_category->tax_rate_id;

            if (!$tax_category) {
                return ['success' => false, 'message' => Constants::TAX_CATEGORY_NOT_FOUND . ': ' . $id];
            }

            try {
                $validated_data = Validator::make($data, TaxCategory::$rules)->validate();
                $tax_category->update($validated_data);
                return ['success' => true, 'message' => Constants::TAX_CATEGORY_UPDATE_SUCCESS,
                    'tax_category' => $tax_category];
            } catch (Exception $e) {
                return ['success' => false, 'message' => Constants::TAX_CATEGORY_UPDATE_FAIL . ': ' .
                    $e->getMessage()];
            }
        } else {
            return ['success' => false, 'message' => Constants::TAX_CATEGORY_UPDATE_FAIL . ': ' .
                Constants::PERMISSION_DENIED];
        }
    }

    public function index(): array
    {
        $tax_categories = TaxCategory::with('taxRates')->get();

        foreach ($tax_categories as $i => $tax_category) {
            $actual_tax_rate = $this->getActualTaxRate($tax_category, Carbon::now());
            if (isset($actual_tax_rate)) {
                $tax_categories[$i]['actual_percentage_value'] = $actual_tax_rate->toArray()['percentage_value'];
                $tax_categories[$i]['actual_from_date'] = $actual_tax_rate->toArray()['from_date'];
            } else {
                $first_tax_rate_to_start = $this->getEarliestTaxRate($tax_category);
                $tax_categories[$i]['staged_percentage_value'] = $first_tax_rate_to_start->toArray()['percentage_value'];
                $tax_categories[$i]['staged_from_date'] = $first_tax_rate_to_start->toArray()['from_date'];
            }

        }

        return ['tax_categories' => $tax_categories->toArray()];
    }

    public function show($id): array
    {
        $tax_category = TaxCategory::with('taxRates')->find($id);

        if (!$tax_category) {
            return ['success' => false, 'message' => Constants::TAX_CATEGORY_NOT_FOUND . ': ' . $id];
        }

        return ['success' => true, 'tax_category' => $tax_category];
    }

    public function destroy(string $id, string $user_id): array
    {
        $result = $this->userService->getUserData($user_id);

        if ($result['success'] && $result['user']['account_type'] == AccountType::ADMINISTRATOR->value) {
            $tax_category = TaxCategory::find($id);

            if (!$tax_category) {
                return ['success' => false, 'message' => Constants::TAX_CATEGORY_NOT_FOUND . ': ' . $id];
            }

            try {
                $tax_rates = $tax_category->taxRates;
                foreach ($tax_rates as $tax_rate) {
                    $tax_rate->delete();
                }
                $tax_category->delete();
                return ['success' => true, 'message' => Constants::TAX_CATEGORY_DELETE_SUCCESS,
                    'tax_category' => $tax_category];
            } catch (Exception $e) {
                return ['success' => false, 'message' => Constants::TAX_CATEGORY_DELETE_FAIL . ': ' .
                    $e->getMessage()];
            }
        } else {
            return ['success' => false, 'message' => Constants::TAX_CATEGORY_DELETE_FAIL . ': ' .
                Constants::PERMISSION_DENIED];
        }
    }

    public function getActualTaxRate($tax_category, $date)
    {
        $tax_rates = $tax_category->load('taxRates')['taxRates'];

        return $tax_rates
            ->where('from_date', '<=', $date)
            ->sortByDesc('from_date')
            ->first();
    }

    private function getEarliestTaxRate($tax_category)
    {
        return $tax_category['taxRates']
            ->sortBy('from_date') // Use sortBy to order by from_date in ascending order
            ->first();
    }
}
