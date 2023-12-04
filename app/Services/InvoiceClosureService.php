<?php

namespace App\Services;

use App\Constants;
use App\Models\InvoiceClosure;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;

class InvoiceClosureService
{
    public function store($invoice_id): array
    {
        $data = [
            'invoice_id' => $invoice_id,
            'closure_date' => null,
            'closure_amount' => 0.0,
        ];

        try {
            $validated_data = Validator::make($data, InvoiceClosure::$rules)->validate();
            $invoice_closure = InvoiceClosure::create($validated_data);

            return ['success' => true, 'message' => Constants::INVOICE_CLOSURE_SAVE_SUCCESS, 'invoice_closure' =>
                $invoice_closure];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::INVOICE_CLOSURE_SAVE_FAIL . ': ' . $e->getMessage()];
        }
    }

    public function update($id, $amount): array
    {
        $invoice_closure = InvoiceClosure::find($id);

        if (!$invoice_closure) {
            return ['success' => false, 'message' => Constants::INVOICE_CLOSURE_NOT_FOUND . ': ' . $id];
        }

        try {
            $invoice_closure->closure_date = Carbon::now();
            $invoice_closure->closure_amount = $amount;
            $invoice_closure->update($invoice_closure->toArray());
            return ['success' => true, 'message' => Constants::INVOICE_CLOSURE_UPDATE_SUCCESS,
                'invoice_closure' => $invoice_closure];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::INVOICE_CLOSURE_UPDATE_FAIL . ': ' . $e->getMessage()];
        }
    }
}
