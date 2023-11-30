<?php

namespace App\Http\Controllers\Api;

use App\Services\PriceDiscountService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class PriceDiscountControllerApi extends Controller
{
    private PriceDiscountService $priceDiscountService;

    public function __construct(PriceDiscountService $priceDiscountService)
    {
        $this->priceDiscountService = $priceDiscountService;
    }

    public function store(Request $request): JsonResponse
    {
        $request_array = $request->toArray();
        $result = $this->priceDiscountService->store($request_array, $request_array['good_or_service_id']);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'price_discount' => $result['price_discount']
            ], 201);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $result = $this->priceDiscountService->update($request->toArray(), $id);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'price_discount' => $result['price_discount']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->priceDiscountService->destroy($id);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'price_discount' => $result['price_discount']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }
}
