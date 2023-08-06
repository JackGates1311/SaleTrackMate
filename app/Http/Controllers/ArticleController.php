<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\GoodsOrServices;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ArticleController extends Controller
{
    public function index(): JsonResponse
    {
        $articles = GoodsOrServices::all();

        return response()->json(['articles' => $articles]);
    }

    public function indexWithDetails(): JsonResponse
    {
        $articles = GoodsOrServices::with('articleDetails')->get();

        return response()->json(['articles' => $articles]);
    }

    public function findByCompanyId($companyId): JsonResponse
    {
        $company = Company::find($companyId);

        if (!$company) {
            return response()->json(['message' => Constants::COMPANY_NOT_FOUND . ' ' . $companyId], 404);
        } else {
            $articles = $company->articles;
        }

        if (!$articles) {
            return response()->json(['message' => Constants::ARTICLE_NOT_FOUND . ' ' . $articles->id], 404);
        }

        return response()->json(['articles' => $articles]);
    }

    public function show($id): JsonResponse
    {
        $article = GoodsOrServices::find($id);
        if (!$article) {
            return response()->json(['message' => Constants::ARTICLE_NOT_FOUND . ' ' . $id], 404);
        }

        return response()->json(['article' => $article]);
    }

    public function store(Request $request): JsonResponse
    {
        $article = new GoodsOrServices($request->toArray());
        $article->save();

        return response()->json([
            'message' => Constants::ARTICLE_SAVE_SUCCESS,
            'data' => $article
        ], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $article = GoodsOrServices::find($id);
        if(!$article) {
            return response()->json(['message' => Constants::ARTICLE_NOT_FOUND . ' ' . $id], 404);
        }

        $article->article_id = $request['article_id'];
        $article->serial_num = $request['serial_num'];
        $article->name = $request['name'];
        $article->unit = $request['unit'];
        $article->min_unit = $request['min_unit'];
        $article->max_unit = $request['max_unit'];
        $article->price = $request['price'];
        $article->description = $request['description'];
        $article->image_url = $request['image_url'];
        $article->available_quantity = $request['available_quantity'];
        $article->warranty_len = $request['warranty_len'];

        $article->save();

        return response()->json([
            'message' => Constants::ARTICLE_UPDATE_SUCCESS,
            'data' => $article
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $article = GoodsOrServices::find($id);
        if (!$article) {
            return response()->json(['message' => Constants::ARTICLE_NOT_FOUND . ' ' . $id], 404);
        }

        $article->delete();

        return response()->json([
            'message' => Constants::ARTICLE_DELETE_SUCCESS,
            'data' => $article
        ]);
    }
}
