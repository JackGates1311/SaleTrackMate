<?php

namespace App\Services;

use App\Constants;
use App\Models\InvoiceItem;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class InvoiceItemService
{
    /**
     * @throws ValidationException
     */
    public function store(array $data): array
    {
        $validated_data = Validator::make($data, InvoiceItem::$rules)->validate();

        try {
            $invoice_item = InvoiceItem::create($validated_data);

            return ['success' => true, 'message' => Constants::INVOICE_SAVE_SUCCESS, 'invoice_item' => $invoice_item];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::INVOICE_ITEM_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }
}
