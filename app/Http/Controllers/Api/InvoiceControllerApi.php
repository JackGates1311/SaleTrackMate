<?php

namespace App\Http\Controllers\Api;

use App\Constants;
use App\Helper\GenerateData;
use App\Models\Company;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use App\Models\Recipient;
use DOMException;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;

class InvoiceControllerApi extends Controller
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

        $resp = $invoice::with('issuerCompany', 'recipientCompany', 'articles')->where('id', $id)->get()->first();

        return response()->json(['invoice' => $resp]);
    }

    public function exportAsPdf($id): void
    {
        $invoice = Invoice::find($id);

        if ($invoice) {
            $resp = $invoice::with('issuerCompany', 'recipientCompany', 'articles')->where('id', $id)->get()->first();
            (new GenerateData)->generatePdf($resp);
        }

        //TODO Add Exception with status code 404!
    }

    /**
     * @throws DOMException
     */
    public function exportAsXml($id): ResponseFactory|Application|Response
    {
        $headers = [
            'Content-type' => 'application/xml'
        ];

        $invoice = Invoice::find($id);

        if ($invoice) {
            $resp = $invoice::with('issuerCompany', 'recipientCompany', 'articles')->where('id', $id)->get()->first();

            $data = $resp->toArray();

            //TODO These fields need more understanding and refactoring existing Invoice data model ...
            //TODO Improve PDV saving ...
            $data['invoice_type_code'] = 380;
            $data['currency'] = 'RSD';
            $data['description_code'] = 35;
            $data['contract_id'] = "Broj ugovora";
            $data['scheme_id'] = "9948";
            $data['issuer_company']['vat'] = "20%";
            $data['recipient_company']['budget_user_number'] = "JBKJS:12345";
            $data['recipient_company']['country'] = "RS";
            $data['recipient_company']['company_id'] = "125654ABCDE";
            $data['recipient_company']['vat'] = "20%";
            $data['payment_code'] = 30;
            $data['payment_mod'] = 97;
            $data['payment_id'] = "123456/2022";
            $data['tax_scheme'] = "VAT";
            $data['tax_exemption_reason_code'] = "PDV-RS-11-1-4";
            $data['allowance_total_amount'] = 0;
            $data['prepaid_amount'] = 0;

            //TODO Add these calculations to invoice entity (make valid calculations) -- THIS IS THE PRIORITY

            $tax_amount = 0.0;
            $price = 0.0;
            $price_with_vat = 0.0;

            foreach ($data['articles'] as $index => $article) {
                // Calculate the total price with VAT
                $total_price_with_VAT = ($article['price_with_vat'] * (1 - $article['rebate']/100)) *
                    $article['quantity'];

                // Calculate the total price without VAT
                $total_price_without_VAT = ($article['price'] * (1 - $article['rebate']/100)) * $article['quantity'];

                // Calculate the tax amount
                $tax_amount += $total_price_with_VAT - $total_price_without_VAT;
                $price += $article['price'];
                $price_with_vat += $article['price_with_vat'];

                if($total_price_with_VAT - $total_price_without_VAT != 0.0) {
                    $data['articles'][$index]['tax_id'] = "S";
                } else {
                    $data['articles'][$index]['tax_id'] = "O";
                }

                $data['articles'][$index]['tax_amount'] = number_format(
                    $total_price_with_VAT - $total_price_without_VAT, 2);
            }

            $data['tax_amount'] = number_format($tax_amount, 2); // total sum of PDV in RSD (for all articles)
            $data['price'] = number_format($price, 2);
            $data['price_with_vat'] = number_format($price_with_vat, 2);

            return response((new GenerateData)->generateXml($data), 200, $headers);
        }

        //TODO FIx Exception with status code 404!
        //TODO Checkif unitCode="piece" and "kg" and "meter" is good implemented in XML export ...!
        //TODO $sellersItemIdentificationID -> check if it is valid or not data!

        return response('', 404);
    }

    public function store(Request $request): JsonResponse
    {
        DB::beginTransaction();

        try {
            $validatedData = $this->validateInvoiceData($request);

            $issuerCompany = (new Company)->findByCompanyId($validatedData['issuer_company_id']);
            $validatedData['issuer_company_id'] = $issuerCompany->id;

            $recipientCompany = new Recipient($validatedData['recipient_company']);
            $recipientCompany->save();
            $validatedData['recipient_company_id'] = $recipientCompany->getAttributes()["id"];

            $invoice = new Invoice($validatedData);
            $invoice->save();
            $invoice_id = $invoice->getAttributes()["id"];

            $articles = collect($validatedData['articles'])->map(function ($articleData) use ($invoice_id) {
                $articleData['invoice_id'] = $invoice_id;
                $article = new InvoiceItems($articleData);
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
