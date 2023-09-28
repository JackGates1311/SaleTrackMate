<?php

namespace App\Http\Controllers\Api;

use App\Constants;
use App\Helper\GenerateData;
use App\Models\Invoice;
use App\Services\InvoiceService;
use DOMException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

class InvoiceControllerApi extends Controller
{
    private InvoiceService $invoiceService;

    public function __construct(InvoiceService $invoiceService)
    {
        $this->invoiceService = $invoiceService;
    }

    public function index(): JsonResponse
    {
        $result = $this->invoiceService->index();
        return response()->json(['invoices' => $result['invoices']]);
    }

    public function show($id): JsonResponse
    {
        $result = $this->invoiceService->show($id);

        if ($result['success']) {
            return response()->json(['invoice' => $result['invoice']]);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
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
                $total_price_with_VAT = ($article['price_with_vat'] * (1 - $article['rebate'] / 100)) *
                    $article['quantity'];

                // Calculate the total price without VAT
                $total_price_without_VAT = ($article['price'] * (1 - $article['rebate'] / 100)) * $article['quantity'];

                // Calculate the tax amount
                $tax_amount += $total_price_with_VAT - $total_price_without_VAT;
                $price += $article['price'];
                $price_with_vat += $article['price_with_vat'];

                if ($total_price_with_VAT - $total_price_without_VAT != 0.0) {
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
        $requestArray = $request->toArray();

        $result = $this->invoiceService->store($requestArray, $requestArray['issuer_company_id']);

        if ($result['success']) {
            return response()->json(['message' => $result['message'], 'invoice' => $result['invoice']], 201);
        } else {
            return response()->json(['message' => $result['message']], 500);
        }
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

    public function findByCompanyId($id): JsonResponse
    {
        $result = $this->invoiceService->findByCompanyId($id);

        if ($result['success']) {
            return response()->json(['invoices' => $result['invoices']]);
        } else {
            return response()->json(['message' => $result['message']]);
        }
    }
}
