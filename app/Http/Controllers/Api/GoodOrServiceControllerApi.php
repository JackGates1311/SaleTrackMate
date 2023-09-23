<?php

namespace App\Http\Controllers\Api;

use App\Services\GoodOrServiceService;
use http\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class GoodOrServiceControllerApi extends Controller
{
    private GoodOrServiceService $goodOrServiceService;

    public function __construct(GoodOrServiceService $goodOrServiceService)
    {
        $this->goodOrServiceService = $goodOrServiceService;
    }

    public function index(): JsonResponse
    {
        $result = $this->goodOrServiceService->index();

        return response()->json(['goods_or_services' => $result['goods_or_services']]);
    }

    public function show($id): JsonResponse
    {
        $result = $this->goodOrServiceService->show($id);

        if ($result['success']) {
            return response()->json(['good_or_service' => $result['good_or_service']]);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }

    public function findByCompanyId($id): JsonResponse
    {
        $result = $this->goodOrServiceService->findByCompanyId($id);

        if ($result['success']) {
            return response()->json(['goods_or_services' => $result['goods_or_services']]);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, $id): JsonResponse
    {
        $result = $this->goodOrServiceService->update($request->toArray(), $id);

        if ($result['success']) {
            return response()->json(['message' => $result['message'],
                'good_or_service' => $result['good_or_service']], 202);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $result = $this->goodOrServiceService->store($request->toArray(), $request->toArray()['company_id']);

        if ($result['success']) {
            return response()->json(['message' => $result['message'],
                'good_or_service' => $result['good_or_service']], 201);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }
}
