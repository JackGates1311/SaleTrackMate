<?php

namespace App\Services;

use App\Constants;
use App\Models\InvoiceRecipient;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvoiceRecipientService
{
    public function store(array $data): array
    {
        try {
            $validated_data = Validator::make($data, InvoiceRecipient::$rules)->validate();
            $invoice_recipient = InvoiceRecipient::create($validated_data);
            return ['success' => true, 'message' => Constants::INVOICE_RECIPIENT_SAVE_SUCCESS,
                'invoice_recipient' => $invoice_recipient];
        } catch (ValidationException $e) {
            return ['success' => false, 'message' => Constants::INVOICE_RECIPIENT_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }
}
