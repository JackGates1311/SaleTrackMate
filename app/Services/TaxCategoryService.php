<?php

namespace App\Services;

use App\Constants;
use App\Models\TaxCategory;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TaxCategoryService
{
    private TaxRateService $taxRateService;

    public function __construct(TaxRateService $taxRateService)
    {
        $this->taxRateService = $taxRateService;
    }

    /**
     * @throws ValidationException
     */
    public function store(array $data): array
    {
        $validated_data = Validator::make($data, TaxCategory::$rules)->validate();

        try {
            $tax_category = TaxCategory::create($validated_data);

            $this->taxRateService->store($data['tax_rate']);

            return ['success' => true, 'message' => Constants::TAX_CATEGORY_SAVE_SUCCESS,
                'tax_category' => $tax_category];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::TAX_CATEGORY_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    /**
     * @throws ValidationException
     */
    public function update(array $data, $id): array
    {
        $tax_category = TaxCategory::find($id);

        if (!$tax_category) {
            return ['success' => false, 'message' => Constants::TAX_CATEGORY_NOT_FOUND . ': ' . $id];
        }

        $validated_data = Validator::make($data, TaxCategory::$rules)->validate();

        try {
            $tax_category->update($validated_data);
            return ['success' => true, 'message' => Constants::TAX_CATEGORY_UPDATE_SUCCESS,
                'tax_category' => $tax_category];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::TAX_CATEGORY_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function index(): array
    {
        $tax_categories = TaxCategory::all();

        return ['tax_categories' => $tax_categories];
    }

    public function show($id): array
    {
        $tax_category = TaxCategory::find($id);

        if (!$tax_category) {
            return ['success' => false, 'message' => Constants::TAX_CATEGORY_NOT_FOUND . ': ' . $id];
        }

        return ['success' => true, 'tax_category' => $tax_category];
    }
}
