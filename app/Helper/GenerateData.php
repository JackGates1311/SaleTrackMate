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

        $invoicePeriod = $invoice->createElement('cac:InvoicePeriod');
        $descriptionCode = $invoice->createElement('cbc:DescriptionCode', $data['description_code']);
        $invoicePeriod->appendChild($descriptionCode);

        $contractDocumentReference = $invoice->createElement('cac:ContractDocumentReference');
        $contract_ID = $invoice->createElement('cbc:ID', $data['contract_id']);
        $contractDocumentReference->appendChild($contract_ID);

        $accountingSupplierParty = $invoice->createElement('cac:AccountingSupplierParty');
        $party = $invoice->createElement('cac:Party');

        $endpointID = $invoice->createElement('cbc:EndpointID', $data['issuer_company']['tax_code']);
        $endpointID->setAttribute('schemeID', $data['scheme_id']);

        $partyName = $invoice->createElement('cac:PartyName');
        $name = $invoice->createElement('cbc:Name', $data['issuer_company']['name']);
        $partyName->appendChild($name);

        $postalAddress = $invoice->createElement('cac:PostalAddress');
        $cityName = $invoice->createElement('cbc:CityName', $data['issuer_company']['place']);
        $country = $invoice->createElement('cac:Country');
        $identificationCode = $invoice->createElement('cbc:IdentificationCode',
            $data['issuer_company']['country']);
        $country->appendChild($identificationCode);
        $postalAddress->appendChild($cityName);
        $postalAddress->appendChild($country);

        $partyTaxScheme = $invoice->createElement('cac:PartyTaxScheme');
        $companyId = $invoice->createElement('cbc:CompanyID', $data['issuer_company']['tax_code']);
        $taxScheme = $invoice->createElement('cac:TaxScheme');
        $taxSchemeId = $invoice->createElement('cbc:ID', $data['issuer_company']['vat']);
        $taxScheme->appendChild($taxSchemeId);
        $partyTaxScheme->appendChild($companyId);
        $partyTaxScheme->appendChild($taxScheme);

        $partyLegalEntity = $invoice->createElement('cac:PartyLegalEntity');
        $registrationName = $invoice->createElement('cbc:RegistrationName', $data['issuer_company']['name']);
        $companyId = $invoice->createElement('cbc:CompanyID', $data['issuer_company']['company_id']);
        $partyLegalEntity->appendChild($registrationName);
        $partyLegalEntity->appendChild($companyId);

        $contact = $invoice->createElement('cac:Contact');
        $electronicMail = $invoice->createElement('cbc:ElectronicMail', $data['issuer_company']['email']);
        $contact->appendChild($electronicMail);

        $party->appendChild($endpointID);
        $party->appendChild($partyName);
        $party->appendChild($postalAddress);
        $party->appendChild($partyTaxScheme);
        $party->appendChild($partyLegalEntity);
        $party->appendChild($contact);

        $accountingSupplierParty->appendChild($party);

        $invoiceElement->appendChild($customizationID);
        $invoiceElement->appendChild($ID);
        $invoiceElement->appendChild($issueDate);
        $invoiceElement->appendChild($dueDate);
        $invoiceElement->appendChild($invoiceTypeCode);
        $invoiceElement->appendChild($documentCurrencyCode);
        $invoiceElement->appendChild($invoicePeriod);
        $invoiceElement->appendChild($contractDocumentReference);
        $invoiceElement->appendChild($accountingSupplierParty);

        $invoice->appendChild($invoiceElement);

        return $invoice->saveXML();

    }
}
