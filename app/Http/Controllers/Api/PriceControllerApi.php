<?php

namespace App\Http\Controllers\Api;

use App\Services\PriceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PriceControllerApi extends Controller
{
    private PriceService $priceService;

    public function __construct(PriceService $priceService)
    {
        $this->priceService = $priceService;
    }

    public function store(Request $request): JsonResponse
    {
        $requestArray = $request->toArray();

        $result = $this->priceService->store($requestArray, $requestArray['good_or_service_id']);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'price' => $result['price']
            ], 201);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }
}
