<?php

namespace App\Services;

use App\Constants;
use App\Models\InvoiceClosure;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvoiceClosureService
{
    /**
     * @throws ValidationException
     */
    public function store(): array
    {
        $data = [
            'closure_date' => null,
            'closure_amount' => 0.0,
        ];

        $validated_data = Validator::make($data, InvoiceClosure::$rules)->validate();

        try {
            $invoice_closure = InvoiceClosure::create($validated_data);

            return ['success' => true, 'message' => Constants::INVOICE_CLOSURE_SAVE_SUCCESS, 'invoice_closure' =>
                $invoice_closure];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::INVOICE_CLOSURE_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }
}
