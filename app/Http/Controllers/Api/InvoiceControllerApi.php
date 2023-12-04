<?php

namespace App\Http\Controllers\Api;

use App\Constants;
use App\Models\Invoice;
use App\Services\InvoiceClosureService;
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
    private InvoiceClosureService $invoiceClosureService;

    public function __construct(InvoiceService $invoiceService, InvoiceClosureService $invoiceClosureService)
    {
        $this->invoiceService = $invoiceService;
        $this->invoiceClosureService = $invoiceClosureService;
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
        $this->invoiceService->exportAsPdf($id);
    }

    /**
     * @throws DOMException
     */
    public function exportAsXml($id): Response|Application|ResponseFactory
    {
        return $this->invoiceService->exportAsXml($id);
    }

    public function store(Request $request): JsonResponse
    {
        $requestArray = $request->toArray();

        $result = $this->invoiceService->store($requestArray, $requestArray['company_id']);

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

    public function closeInvoice($id): JsonResponse
    {
        $invoice = $this->invoiceService->show($id)['invoice'];

        $result = $this->invoiceClosureService->update($invoice['closure']['id'],
            $invoice['total_price'] + $invoice['total_vat']);

        if ($result['success']) {
            return response()->json([
                'message' => $result['message'],
                'invoice_closure' => $result['invoice_closure']
            ], 202);
        } else {
            return response()->json([
                'message' => $result['message'],
            ], 500);
        }
    }
}
