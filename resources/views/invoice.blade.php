<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice {{ $invoice_num }} </title>
</head>
<body class="antialiased">
<table>
    <thead>
    <tr>
        <th>Invoice Number</th>
        <th>Invoice Date</th>
        <th>Due Date</th>
        <th>Delivery Date</th>
        <th>Payment Method</th>
        <th>Payment Deadline</th>
        <th>Fiscal Receipt Number</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $invoice_num }}</td>
        <td>{{ $invoice_date }}</td>
        <td>{{ $due_date }}</td>
        <td>{{ $delivery_date }}</td>
        <td>{{ $payment_method }}</td>
        <td>{{ $payment_deadline }}</td>
        <td>{{ $fiscal_receipt_num }}</td>
    </tr>
    </tbody>
</table>

<h2>Issuer Company</h2>
<p>{{ $issuer_company['name'] }}</p>
<p>{{ $issuer_company['address'] }},{{ $issuer_company['postal_code'] }} {{ $issuer_company['place'] }}</p>
<p>Tax Code: {{ $issuer_company['tax_code'] }}</p>

<h2>Recipient Company</h2>
<p>{{ $recipient_company['name'] }}</p>
<p>{{ $recipient_company['address'] }}, {{ $recipient_company['postal_code'] }} {{ $recipient_company['place'] }}</p>
<p>Tax Code: {{ $recipient_company['tax_code'] }}</p>

<h2>Articles</h2>
<table>
    <thead>
    <tr>
        <th>Name</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Rebate</th>
        <th>VAT</th>
        <th>Total Price</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($articles as $article)
        <tr>
            <td>{{ $article['name'] }}</td>
            <td>{{ $article['quantity'] }}</td>
            <td>{{ $article['price'] }}</td>
            <td>{{ $article['rebate'] }}</td>
            <td>{{ $article['vat'] }}</td>
            <td>{{ $article['price_with_vat'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
