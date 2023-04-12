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
        $companyId = $invoice->createElement('cbc:CompanyID', $data['issuer_company']['country'] .
            $data['issuer_company']['tax_code']);
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

        $accountingCustomerParty = $invoice->createElement('cac:AccountingCustomerParty');

        $partyCustomer = $invoice->createElement('cac:Party');

        $endpointIDCustomer = $invoice->createElement('cbc:EndpointID', $data['recipient_company']
            ['tax_code']);
        $endpointIDCustomer->setAttribute('schemeID', $data['scheme_id']);
        $partyIdentification = $invoice->createElement('cac:PartyIdentification');
        $IDCustomer = $invoice->createElement('cbc:ID', $data['recipient_company']['budget_user_number']);
        $partyIdentification->appendChild($IDCustomer);

        $partyNameCustomer = $invoice->createElement('cac:PartyName');
        $nameCustomer = $invoice->createElement('cbc:Name', $data['recipient_company']['name']);
        $partyNameCustomer->appendChild($nameCustomer);

        $postalAddressCustomer = $invoice->createElement('cac:PostalAddress');
        $streetName = $invoice->createElement('cbc:StreetName', $data['recipient_company']['address']);
        $cityNameCustomer = $invoice->createElement('cbc:CityName', $data['recipient_company']['place']);
        $countryCustomer = $invoice->createElement('cac:Country');
        $identificationCodeCustomer = $invoice->createElement('cbc:IdentificationCode',
            $data['recipient_company']['country']);
        $countryCustomer->appendChild($identificationCodeCustomer);
        $postalAddressCustomer->appendChild($streetName);
        $postalAddressCustomer->appendChild($cityNameCustomer);
        $postalAddressCustomer->appendChild($countryCustomer);

        $partyTaxSchemeCustomer = $invoice->createElement('cac:PartyTaxScheme');
        $companyIdCustomer = $invoice->createElement('cbc:CompanyID',
            $data['recipient_company']['country'].$data['recipient_company']['company_id']);
        $taxSchemeCustomer = $invoice->createElement('cac:TaxScheme');
        $taxSchemeIdCustomer = $invoice->createElement('cbc:ID', $data['recipient_company']['vat']);
        $taxSchemeCustomer->appendChild($taxSchemeIdCustomer);
        $partyTaxSchemeCustomer->appendChild($companyIdCustomer);
        $partyTaxSchemeCustomer->appendChild($taxSchemeCustomer);

        $partyLegalEntityCustomer = $invoice->createElement('cac:PartyLegalEntity');
        $registrationNameCustomer = $invoice->createElement('cbc:RegistrationName',
            $data['recipient_company']['name']);
        $companyIdCustomerLegal = $invoice->createElement('cbc:CompanyID',
            $data['recipient_company']['reg_id']);
        $partyLegalEntityCustomer->appendChild($registrationNameCustomer);
        $partyLegalEntityCustomer->appendChild($companyIdCustomerLegal);

        $contactCustomer = $invoice->createElement('cac:Contact');
        $electronicMailCustomer = $invoice->createElement('cbc:ElectronicMail',
            $data['recipient_company']['email']);
        $contactCustomer->appendChild($electronicMailCustomer);

        $partyCustomer->appendChild($endpointIDCustomer);
        $partyCustomer->appendChild($partyIdentification);
        $partyCustomer->appendChild($partyNameCustomer);
        $partyCustomer->appendChild($postalAddressCustomer);
        $partyCustomer->appendChild($partyTaxSchemeCustomer);
        $partyCustomer->appendChild($partyLegalEntityCustomer);
        $partyCustomer->appendChild($contactCustomer);

        $accountingSupplierParty->appendChild($party);
        $accountingCustomerParty->appendChild($partyCustomer);

        $delivery = $invoice->createElement('cac:Delivery');
        $actualDeliveryDate = $invoice->createElement('cbc:ActualDeliveryDate', $data['delivery_date']);
        $delivery->appendChild($actualDeliveryDate);

        $paymentMeans = $invoice->createElement('cac:PaymentMeans');
        $paymentMeansCode = $invoice->createElement('cbc:PaymentMeansCode', $data['payment_code']);
        $paymentID = $invoice->createElement('cbc:PaymentID', "(mod" . $data['payment_mod'] . ") " .
            $data['payment_id']);
        $paymentFinancialAccount = $invoice->createElement('cac:PayeeFinancialAccount');
        $paymentFinancialAccountID = $invoice->createElement('cbc:ID', $data['issuer_company']['iban']);
        $paymentFinancialAccount->appendChild($paymentFinancialAccountID);

        $paymentMeans->appendChild($paymentMeansCode);
        $paymentMeans->appendChild($paymentID);
        $paymentMeans->appendChild($paymentFinancialAccount);

        $taxTotal = $invoice->createElement('cac:TaxTotal');
        $taxAmount = $invoice->createElement('cbc:TaxAmount', $data['tax_amount']);
        $taxAmount->setAttribute('currencyID', $data['currency']);
        $taxTotal->appendChild($taxAmount);

        foreach ($data['articles'] as $article) {
            $taxSubtotal = $invoice->createElement('cac:TaxSubtotal');
            $taxableAmount = $invoice->createElement('cbc:TaxableAmount', $article['price_with_vat']);
            $taxableAmount->setAttribute('currencyID', $data['currency']);
            $taxAmountArticle = $invoice->createElement('cbc:TaxAmount', $article['tax_amount']);
            $taxAmountArticle->setAttribute('currencyID', $data['currency']);
            $taxCategory = $invoice->createElement('cac:TaxCategory');
            $taxID = $invoice->createElement('cbc:ID', $article['tax_id']);
            $percent = $invoice->createElement('cbc:Percent', $article['vat']);
            $taxExemptionReasonCode = $invoice->createElement('cbc:TaxExemptionReasonCode',
                $data['tax_exemption_reason_code']);
            $taxSchemeArticle = $invoice->createElement('cac:TaxScheme');
            $taxSchemeArticleID = $invoice->createElement('cbc:ID', $data['tax_scheme']);
            $taxSchemeArticle->appendChild($taxSchemeArticleID);
            $taxCategory->appendChild($taxID);
            $taxCategory->appendChild($percent);
            if($article['tax_id'] == "O") {
                $taxCategory->appendChild($taxExemptionReasonCode);
            }
            $taxCategory->appendChild($taxSchemeArticle);
            $taxSubtotal->appendChild($taxableAmount);
            $taxSubtotal->appendChild($taxAmountArticle);
            $taxSubtotal->appendChild($taxCategory);
            $taxTotal->appendChild($taxSubtotal);
        }

        $invoiceElement->appendChild($customizationID);
        $invoiceElement->appendChild($ID);
        $invoiceElement->appendChild($issueDate);
        $invoiceElement->appendChild($dueDate);
        $invoiceElement->appendChild($invoiceTypeCode);
        $invoiceElement->appendChild($documentCurrencyCode);
        $invoiceElement->appendChild($invoicePeriod);
        $invoiceElement->appendChild($contractDocumentReference);
        $invoiceElement->appendChild($accountingSupplierParty);
        $invoiceElement->appendChild($accountingCustomerParty);
        $invoiceElement->appendChild($delivery);
        $invoiceElement->appendChild($paymentMeans);
        $invoiceElement->appendChild($taxTotal);

        $invoice->appendChild($invoiceElement);

        return $invoice->saveXML();

    }
}
