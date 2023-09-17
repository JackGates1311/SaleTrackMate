<?php

namespace App\Services;

use App\Models\Invoice;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvoiceService
{
    /**
     * @throws ValidationException
     */
    public function store(array $data, string $issuer_company_id): array
    {
        $data['company_id'] = $issuer_company_id;

        $validated_data = Validator::make($data, Invoice::$rules)->validate();

        try {

            DB::beginTransaction();

            try {
                
            } catch (Exception $e) {

            }
        } catch (Exception $e) {

        }

        return [];
    }
}
