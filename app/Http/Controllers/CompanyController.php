<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Company;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CompanyController extends Controller
{
    public function index(): JsonResponse
    {
        $companies = Company::all();

        return response()->json(['companies' => $companies]);
    }

    public function show($id): JsonResponse
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => Constants::COMPANY_NOT_FOUND . ' ' . $id], 404);
        }

        return response()->json(['company' => $company]);
    }

    public function store(Request $request): JsonResponse
    {
        $company = new Company($request->toArray());
        $company->save();

        return response()->json([
            'message' => Constants::COMPANY_SAVE_SUCCESS,
            'data' => $company
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $company = Company::find($id);
        if(!$company) {
            return response()->json(['message' => Constants::COMPANY_NOT_FOUND . ' ' . $id], 404);
        }

        $company->company_id = $request['company_id'];
        $company->tax_code = $request['tax_code'];
        $company->reg_id = $request['reg_id'];
        $company->vat_id = $request['vat_id'];
        $company->name = $request['name'];
        $company->country = $request['country'];
        $company->place = $request['place'];
        $company->postal_code = $request['postal_code'];
        $company->address = $request['address'];
        $company->iban = $request['iban'];
        $company->bank_name = $request['bank_name'];
        $company->phone_num = $request['phone_num'];
        $company->fax = $request['fax'];
        $company->email = $request['email'];
        $company->url = $request['url'];
        $company->logo_url = $request['logo_url'];

        $company->save();

        return response()->json([
            'message' => Constants::COMPANY_UPDATE_SUCCESS,
            'data' => $company
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => Constants::COMPANY_NOT_FOUND . ' ' . $id], 404);
        }

        $company->delete();

        return response()->json([
            'message' => Constants::COMPANY_DELETE_SUCCESS,
            'data' => $company
        ]);
    }
}
