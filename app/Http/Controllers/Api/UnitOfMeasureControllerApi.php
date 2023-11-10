<?php

namespace App\Http\Controllers\Api;

use App\Services\UnitOfMeasureService;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UnitOfMeasureControllerApi extends Controller
{
    private UnitOfMeasureService $unitOfMeasureService;
    private UserService $userService;

    public function __construct(UnitOfMeasureService $unitOfMeasureService, UserService $userService)
    {
        $this->unitOfMeasureService = $unitOfMeasureService;
        $this->userService = $userService;
    }

    public function store(Request $request): JsonResponse
    {
        $result = $this->unitOfMeasureService->store($request->toArray(), $this->userService->getUserIdApi());

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'unit_of_measure' => $result['unit_of_measure']
            ], 201);
        } else {
            return response()->json([
                'message' => $result['message'],
            ], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $result = $this->unitOfMeasureService->update($request->toArray(), $id, $this->userService->getUserIdApi());

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'unit_of_measure' => $result['unit_of_measure']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message'],
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        $result = $this->unitOfMeasureService->show($id);

        if ($result['success']) {
            return response()->json([
                'unit_of_measure' => $result['unit_of_measure']
            ]);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function index(): JsonResponse
    {
        $result = $this->unitOfMeasureService->index();

        return response()->json([
            'unit_of_measures' => $result['unit_of_measures']
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->unitOfMeasureService->destroy($id, $this->userService->getUserIdApi());

        if ($result['success']) {
            return response()->json(['message' => $result['message'],
                'unit_of_measure' => $result['unit_of_measure']], 202);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }
}
