<?php

namespace App\Services;

use App\Constants;
use App\Models\Recipient;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RecipientService
{
    /**
     * @throws ValidationException
     */
    public function store(array $data): array
    {
        $validated_data = Validator::make($data, Recipient::$rules)->validate();

        try {
            $recipient = Recipient::create($validated_data);

            return ['success' => true, 'message' => Constants::RECIPIENT_SAVE_SUCCESS,
                'recipient' => $recipient];
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::RECIPIENT_SAVE_FAIL . ':' . $e->getMessage()];
        }
    }
}
