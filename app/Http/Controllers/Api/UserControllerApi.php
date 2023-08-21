<?php

namespace App\Http\Controllers\Api;

use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
}
