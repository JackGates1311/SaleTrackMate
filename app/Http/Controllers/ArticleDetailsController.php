<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\GoodsOrServicesDetails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ArticleDetailsController extends Controller
{
    public function index(): JsonResponse
    {
        $articlesDetails = GoodsOrServicesDetails::all();

        return response()->json(['articles' => $articlesDetails]);
    }

    public function show($id): JsonResponse
    {
        $articleDetails = GoodsOrServicesDetails::find($id);
        if (!$articleDetails) {
            return response()->json(['message' => Constants::ARTICLE_DETAILS_NOT_FOUND . ' ' . $id], 404);
        }

        return response()->json(['articleDetails' => $articleDetails]);
    }

    public function store(Request $request): JsonResponse
    {
        $articleDetails = new GoodsOrServicesDetails($request->toArray());
        $articleDetails->save();

        return response()->json([
            'message' => Constants::ARTICLE_DETAILS_SAVE_SUCCESS,
            'data' => $articleDetails
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $articleDetails = GoodsOrServicesDetails::find($id);
        if(!$articleDetails) {
            return response()->json(['message' => Constants::ARTICLE_DETAILS_NOT_FOUND . ' ' . $id], 404);
        }

        $articleDetails->article_id = $request['article_id'];
        $articleDetails->url = $request['url'];
        $articleDetails->category = $request['category'];
        $articleDetails->supplier = $request['supplier'];
        $articleDetails->country_origin = $request['country_origin'];
        $articleDetails->country_origin_code = $request['country_origin_code'];
        $articleDetails->weight = $request['weight'];
        $articleDetails->dimensions = $request['dimensions'];
        $articleDetails->color = $request['color'];

        $articleDetails->save();

        return response()->json([
            'message' => Constants::ARTICLE_DETAILS_UPDATE_SUCCESS,
            'data' => $articleDetails
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $articleDetails = GoodsOrServicesDetails::find($id);
        if (!$articleDetails) {
            return response()->json(['message' => Constants::ARTICLE_DETAILS_NOT_FOUND . ' ' . $id], 404);
        }

        $articleDetails->delete();

        return response()->json([
            'message' => Constants::ARTICLE_DETAILS_DELETE_SUCCESS,
            'data' => $articleDetails
        ]);
    }
}
