<?php

namespace App\Http\Controllers\Api;

use App\Services\TaxCategoryService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

class TaxCategoryControllerApi extends Controller
{
    private TaxCategoryService $taxCategoryService;
    private UserService $userService;

    public function __construct(TaxCategoryService $taxCategoryService, UserService $userService)
    {
        $this->taxCategoryService = $taxCategoryService;
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $result = $this->taxCategoryService->index();

        return response()->json(['tax_categories' => $result['tax_categories']]);
    }

    public function show($id): JsonResponse
    {
        $result = $this->taxCategoryService->show($id);

        if ($result['success']) {
            return response()->json(['tax_category' => $result['tax_category']]);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $result = $this->taxCategoryService->store($request->toArray(), $this->userService->getUserIdApi());

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'tax_category' => $result['tax_category']
            ], 201);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $result = $this->taxCategoryService->update($request->toArray(), $id, $this->userService->getUserIdApi());

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'tax_category' => $result['tax_category']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->taxCategoryService->destroy($id, $this->userService->getUserIdApi());

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'tax_category' => $result['tax_category']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }
}
