<?php

namespace App\Services;

use App\Constants;
use App\Models\Company;
use App\Models\Recipient;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RecipientService
{
    private BankAccountService $bankAccountService;

    public function __construct(BankAccountService $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }

    /**
     * @throws ValidationException
     */
    public function store(array $data, string $company_id): array
    {
        $data['company_id'] = $company_id;
        $validated_data = Validator::make($data, Recipient::$rules)->validate();

        try {

            DB::beginTransaction();

            try {
                if (count($data['bank_accounts']) > 0) {
                    $recipient = Recipient::create($validated_data);

                    foreach ($data['bank_accounts'] as $bank_account) {
                        $this->bankAccountService->store($bank_account, $recipient->id, true);
                    }

                    DB::commit();

                    $recipient['bank_accounts'] = $data['bank_accounts'];

                    return ['success' => true, 'message' => Constants::RECIPIENT_SAVE_SUCCESS,
                        'recipient' => $recipient];
                } else {
                    DB::rollBack();
                    return ['success' => false, 'message' => 'Recipient must have at least one bank account'];
                }
            } catch (Exception $e) {
                DB::rollBack();
                return ['success' => false, 'message' => 'Failed to save recipient: ' . $e->getMessage()];
            }
        } catch (Exception $e) {
            return ['success' => false, 'message' => Constants::RECIPIENT_SAVE_FAIL . ':' . $e->getMessage()];
        }
    }

    public function getByCompanyId($id): array
    {
        $company = (new Company)->find($id);

        if (!$company) {
            return ['success' => false, 'message' => Constants::COMPANY_NOT_FOUND . ' with ID: ' . $id];
        } else {
            $recipients = $company->recipients;
        }

        if (!$recipients) {
            return ['success' => false, 'message' => Constants::RECIPIENT_NOT_FOUND . ' with ID: ' . $id];
        }

        return ['success' => true, 'recipients' => $recipients];
    }
}
