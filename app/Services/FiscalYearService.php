<?php

namespace App\Services;

use App\Constants;
use App\Models\FiscalYear;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FiscalYearService
{
    /**
     * @throws ValidationException
     */
    public function store(int $year, string $company_id): array
    {
        $data = ['year' => $year, 'is_closed' => false, 'company_id' => $company_id];

        $validated_data = Validator::make($data, FiscalYear::$rules)->validate();

        try {
            $fiscal_year = FiscalYear::create($validated_data);

            return ['success' => true, 'message' => Constants::FISCAL_YEAR_SAVE_SUCCESS,
                'fiscal_year' => $fiscal_year];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }
}
