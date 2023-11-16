<?php

namespace App\Http\Controllers\Api;

use App\Services\TaxRateService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class TaxRateControllerApi extends Controller
{
    public TaxRateService $taxRateService;
    public UserService $userService;

    public function __construct(TaxRateService $taxRateService, UserService $userService)
    {
        $this->taxRateService = $taxRateService;
        $this->userService = $userService;
    }

    public function store(Request $request): JsonResponse
    {
        $request_array = $request->toArray();
        $result = $this->taxRateService->store($request_array, $this->userService->getUserIdApi(),
            $request_array['tax_category_id']);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'tax_rate' => $result['tax_rate']
            ], 201);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request_array = $request->toArray();

        $result = $this->taxRateService->update($request_array, $id, $this->userService->getUserIdApi());

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'tax_rate' => $result['tax_rate']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->taxRateService->destroy($id, $this->userService->getUserIdApi());

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'tax_rate' => $result['tax_rate']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }
}
