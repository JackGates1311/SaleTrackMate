<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Helper\PdfGenerator;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceArticles;
use App\Models\InvoiceRecipient;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    public function index(): JsonResponse
    {
        $invoices = Invoice::with('issuerCompany', 'recipientCompany', 'articles')->get();

        return response()->json(['invoices' => $invoices]);
    }

    public function show($id): JsonResponse
    {
        $invoice = Invoice::find($id);

        if (!$invoice) {
            return response()->json(['message' => Constants::INVOICE_NOT_FOUND . ' ' . $id], 404);
        }

        $resp = $invoice::with('issuerCompany', 'recipientCompany', 'articles')->first();
        return response()->json(['invoice' => $resp]);
    }

    public function showAsPdf($id): void
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            $resp = $invoice::with('issuerCompany', 'recipientCompany', 'articles')->first();
            (new PdfGenerator)->generatePdf($resp);
        }
    }

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validatedData = $this->validateInvoiceData($request);

            $issuerCompany = (new Company)->findByCompanyId($validatedData['issuer_company_id']);
            $validatedData['issuer_company_id'] = $issuerCompany->id;

            $recipientCompany = new InvoiceRecipient($validatedData['recipient_company']);
            $recipientCompany->save();
            $validatedData['recipient_company_id'] = $recipientCompany->getAttributes()["id"];

            $invoice = new Invoice($validatedData);
            $invoice->save();
            $invoice_id = $invoice->getAttributes()["id"];

            $articles = collect($validatedData['articles'])->map(function ($articleData) use ($invoice_id) {
                $articleData['invoice_id'] = $invoice_id;
                $article = new InvoiceArticles($articleData);
                $article->save();
                return $article;
            });

            $invoice->articles()->saveMany($articles);

            DB::commit();

        } catch (Exception $exception)
        {
            DB::rollBack();

            return response()->json(['message' => Constants::INVOICE_SAVE_FAIL, 'trace' => $exception]);
        }

        // TODO here place implementation code for saving PDF file to server file system

        return response()->json(['message' => Constants::INVOICE_SAVE_SUCCESS, 'data' => $invoice]);
    }

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
            'issuer_company_id' => 'required|exists:companies,company_id',
            'recipient_company.tax_code' => 'required|string',
            'recipient_company.reg_id' => '',
            'recipient_company.vat_id' => '',
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
