<?php

namespace App\Http\Controllers\Api;

use App\Services\BankAccountService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class BankAccountControllerApi extends Controller
{

    private BankAccountService $bankAccountService;

    public function __construct(BankAccountService $bankAccountService)
    {
        $this->bankAccountService = $bankAccountService;
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        if ($request->toArray()['recipient_id'] != "" && $request->toArray()['recipient_id'] != null) {
            $result = $this->bankAccountService->store($request->except('recipient_id'),
                $request->toArray()['recipient_id'], true);
        } else {
            $result = $this->bankAccountService->store($request->except('company_id'),
                $request->toArray()['company_id'], false);
        }
        
        if ($result['success']) {
            return response()->json(['message' => $result['message'], 'bank_account' => $request->toArray()], 201);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function findByCompanyId($id): JsonResponse
    {
        $result = $this->bankAccountService->findByCompanyId($id);

        return response()->json(['bank_accounts' => $result['bank_accounts']]);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, $id): JsonResponse
    {
        $result = $this->bankAccountService->update($request->toArray(), $id);

        if ($result['success']) {
            return response()->json(['message' => $result['message'], 'bank_account' => $result['bank_account']], 202);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->bankAccountService->destroy($id);

        if ($result['success']) {
            return response()->json(['message' => $result['message'], 'bank_account' => $result['bank_account']], 202);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }
}
