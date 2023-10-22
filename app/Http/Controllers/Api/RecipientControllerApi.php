<?php

namespace App\Http\Controllers\Api;

use App\Services\RecipientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RecipientControllerApi extends Controller
{
    private RecipientService $recipientService;

    public function __construct(RecipientService $recipientService)
    {
        $this->recipientService = $recipientService;
    }

    public function getByCompanyId($id): JsonResponse
    {
        $result = $this->recipientService->getByCompanyId($id);

        if ($result['success']) {
            return response()->json(['recipients' => $result['recipients']]);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }

    public function show($id): JsonResponse
    {
        $result = $this->recipientService->show($id);

        if ($result['success']) {
            return response()->json(['recipient' => $result['recipient']]);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $result = $this->recipientService->store($request->toArray(), $request->toArray()['company_id']);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'recipient' => $result['recipient']
            ], 201);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $result = $this->recipientService->update($request->toArray(), $id);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'recipient' => $result['recipient']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        $result = $this->recipientService->destroy($id);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'recipient' => $result['recipient']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message']
            ], 500);
        }
    }
}
