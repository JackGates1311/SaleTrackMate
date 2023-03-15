<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceArticles;
use App\Models\InvoiceRecipient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class InvoiceController extends Controller
{
    public function index(): JsonResponse
    {
        $invoices = Invoice::all();

        return response()->json(['invoices' => $invoices]);
    }

    public function show($id): JsonResponse
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json(['message' => Constants::INVOICE_NOT_FOUND . ' ' . $id], 404);
        }

        return response()->json(['invoice' => $invoice]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $this->validateInvoiceData($request);

        $issuerCompany = Company::find($validatedData['issuer_company_id']);

        $recipientCompany = new InvoiceRecipient($validatedData['recipient_company']);
        $recipientCompany->save();

        $invoice = new Invoice($validatedData);
        $invoice->issuerCompany()->associate($issuerCompany);
        $invoice->recipientCompany()->associate($recipientCompany);
        $invoice->save();

        $articles = collect($validatedData['articles'])->map(function ($articleData) {
            $article = new InvoiceArticles($articleData);
            $article->save();
            return $article;
        });

        $invoice->articles()->saveMany($articles);

        return response()->json(['message' => Constants::INVOICE_SAVE_SUCCESS, 'data' => $invoice]);
    }

    /* public function update(Request $request, $id): JsonResponse
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
        $company->category = $request['category'];
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

        return response()->json([]);
    } */

    public function destroy($id): JsonResponse
    {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json(['message' => Constants::INVOICE_NOT_FOUND . ' ' . $id], 404);
        }

        $invoice->delete();

        return response()->json([
            'message' => Constants::INVOICE_DELETE_SUCCESS,
            'data' => $invoice
        ]);
    }

    private function validateInvoiceData(Request $request): array
    {
        return $request->validate([
            'issuer_company_id' => 'required|exists:companies,id',
            'recipient_company.tax_code' => 'required|string',
            'recipient_company.reg_id' => 'required|string',
            'recipient_company.vat_id' => 'required|string',
            'recipient_company.name' => 'required|string',
            'recipient_company.place' => 'required|string',
            'recipient_company.postal_code' => 'required|string',
            'recipient_company.address' => 'required|string',
            'recipient_company.iban' => 'required|string',
            'recipient_company.phone_num' => 'required|string',
            'recipient_company.fax' => 'required|string',
            'recipient_company.email' => 'required|email',
            'invoice_num' => 'required|string',
            'invoice_date' => 'required|date',
            'invoice_location' => 'required|string',
            'due_date' => 'required|date',
            'due_location' => 'required|string',
            'delivery_date' => 'required|date',
            'delivery_location' => 'required|string',
            'payment_method' => 'required|string',
            'payment_deadline' => 'required|date',
            'fiscal_receipt_num' => 'required|string',
            'articles.*.article_id' => 'required|string',
            'articles.*.name' => 'required|string',
            'articles.*.unit' => 'required|string',
            'articles.*.quantity' => 'required|numeric',
            'articles.*.price' => 'required|numeric',
            'articles.*.rebate' => 'required|numeric',
            'articles.*.vat' => 'required|numeric',
            'articles.*.price_with_vat' => 'required|numeric',
            'articles.*.image_url' => 'nullable|url',
        ]);
    }
}
