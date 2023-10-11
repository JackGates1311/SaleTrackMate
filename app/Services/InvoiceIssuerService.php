<?php

namespace App\Services;


use App\Constants;
use App\Models\InvoiceIssuer;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvoiceIssuerService
{
    public function store(array $data): array
    {
        try {
            $validated_data = Validator::make($data, InvoiceIssuer::$rules)->validate();
            $invoice_issuer = InvoiceIssuer::create($validated_data);
            return ['success' => true, 'message' => Constants::INVOICE_ISSUER_SAVE_SUCCESS,
                'invoice_issuer' => $invoice_issuer];
        } catch (ValidationException $e) {
            return ['success' => false, 'message' => Constants::INVOICE_ISSUER_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }
}
