<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Laravel\Sanctum\PersonalAccessToken;

class UserControllerApi extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(Request $request): JsonResponse
    {
        $result = $this->userService->register($request->all());

        if ($result['success']) {
            return response()->json(['message' => $result['message'],
                'user' => $result['user'],
                'token' => $result['token'],
                'token_expiration' => $result['token_expiration']], 201);
        } else {
            return response()->json(['message' => 'Registration failed', 'error' => $result['error']], 400);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $result = $this->userService->login($request->all());

        if ($result['success']) {
            return response()->json(['message' => $result['message'],
                'user' => $result['user'],
                'token' => $result['token'],
                'token_expiration' => $result['token_expiration']]);
        } else {
            return response()->json(['message' => $result['message'], 'error' => $result['error']], 401);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $token = PersonalAccessToken::findToken($request->bearerToken());

        if ($token != null) {
            $token->delete();
            $this->userService->logout();

            return response()->json(['message' => 'Logged out successfully']);
        } else {
            return response()->json(['message' => 'User is already logged out']);
        }
    }

    public function getRegistrationRequests(): JsonResponse
    {
        $result = $this->userService->getRegistrationRequests($this->userService->getUserIdApi());

        if ($result['success']) {
            return response()->json([
                'user_registration_requests' => $result['user_registration_requests']
            ]);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function updateApprovalStatus(Request $request, string $id): JsonResponse
    {
        $result = $this->userService->updateApprovalStatus($request->toArray(), $id,
            $this->userService->getUserIdApi());

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'user_registration_request' => $result['user_registration_request']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }
}
