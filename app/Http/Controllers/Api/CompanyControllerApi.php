<?php

namespace App\Http\Controllers\Api;

use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CompanyControllerApi extends Controller
{

    private CompanyService $companyService;

    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

    public function index(): JsonResponse
    {
        $result = $this->companyService->index();

        return response()->json(['companies' => $result['companies']]);
    }

    public function show($id): JsonResponse
    {
        $result = $this->companyService->show($id);

        if ($result['success']) {
            return response()->json([
                'company' => $result['company']
            ]);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $result = $this->companyService->store($request);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'company' => $result['company']
            ], 201);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $result = $this->companyService->update($request, $id);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'company' => $result['company']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function findByUserId($id): JsonResponse
    {
        $result = $this->companyService->findByUserId($id);

        if ($result['success']) {
            return response()->json([
                'companies' => $result['companies']
            ]);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }
}