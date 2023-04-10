<?php

namespace App\Helper;

use DOMDocument;
use DOMException;
use Dompdf\Dompdf;

class GenerateData
{
    public function generatePdf($data): void
    {
        $html = view('invoice', $data)->render();

        $pdf = new Dompdf();
        $pdf->loadHtml($html);
        $pdf->setPaper('A4');
        $pdf->render();
        $pdf->stream('invoice.pdf');
    }

    /**
     * @throws DOMException
     */
    public function generateXml($data): bool|string
    {
        $invoice = new DOMDocument('1.0', 'UTF-8');

        $invoiceElement = $invoice->createElement('Invoice');

        $invoiceElement->setAttribute('xmlns:cec',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonExtensionComponents-2');
        $invoiceElement->setAttribute('xmlns:cac',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2');
        $invoiceElement->setAttribute('xmlns:cbc',
            'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2');
        $invoiceElement->setAttribute('xmlns:xsi',
            'http://www.w3.org/2001/XMLSchema-instance');
        $invoiceElement->setAttribute('xmlns:xsd',
            'http://www.w3.org/2001/XMLSchema');
        $invoiceElement->setAttribute('xmlns:sbt',
            'http://mfin.gov.rs/srbdt/srbdtext');
        $invoiceElement->setAttribute('xmlns',
            'urn:oasis:names:specification:ubl:schema:xsd:Invoice-2');

        $customizationID = $invoice->createElement('cbc:CustomizationID',
            'urn:cen.eu:en16931:2017#compliant#urn:mfin.gov.rs:srbdt:2021');
        $ID = $invoice->createElement('cbc:ID', $data['invoice_num']);
        $issueDate = $invoice->createElement('cbc:IssueDate', $data['invoice_date']);
        $dueDate = $invoice->createElement('cbc:DueDate', $data['due_date']);
        $invoiceTypeCode = $invoice->createElement('cbc:InvoiceTypeCode', $data['invoice_type_code']);
        $documentCurrencyCode = $invoice->createElement('cbc:DocumentCurrencyCode', $data['currency']);

        $invoiceElement->appendChild($customizationID);
        $invoiceElement->appendChild($ID);
        $invoiceElement->appendChild($issueDate);
        $invoiceElement->appendChild($dueDate);
        $invoiceElement->appendChild($invoiceTypeCode);
        $invoiceElement->appendChild($documentCurrencyCode);

        $invoice->appendChild($invoiceElement);

        return $invoice->saveXML();

    }
}
