<?php

namespace App\Http\Controllers\Api;

use App\Services\CompanyService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;

class CompanyControllerApi extends Controller
{
    private CompanyService $companyService;
    private UserService $userService;

    public function __construct(CompanyService $companyService, UserService $userService)
    {
        $this->companyService = $companyService;
        $this->userService = $userService;
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
        $result = $this->companyService->store($request, $this->userService->getUserIdApi());

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

    /**
     * @throws ValidationException
     */
    public function update(Request $request, $id): JsonResponse
    {
        $result = $this->companyService->update($request->toArray(), $id, $this->userService->getUserIdApi());

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

    public function findByUserId(): JsonResponse
    {
        $user = auth('api')->user();

        $user_id = '';

        if (isset($user->id)) {
            $user_id = $user->id;
        }

        $result = $this->companyService->findByUserId($user_id);

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

    /**
     * @return string
     */
}
