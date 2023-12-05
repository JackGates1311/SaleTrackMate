<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>{{$invoice_num}}</title>
    <style>
        * {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
        }

        img {
            width: 160px;
            height: 160px;
        }

        h1, h2, h3, h4, h5, h6, p, span, div {
            font-family: DejaVu Sans, serif;
            font-size: 11px;
            font-weight: normal;
        }

        th, td {
            font-family: DejaVu Sans, serif;
            font-size: 11px;
            white-space: normal;
        }

        .panel {
            margin-bottom: 20px;
            background-color: #fff;
            border: 1px solid transparent;
            border-radius: 4px;
            -webkit-box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .panel-default {
            border-color: #ddd;
        }

        .panel-body {
            padding: 15px;
        }

        table {
            width: 100%;
            max-width: 100%;
            margin-bottom: 0;
            border-spacing: 0;
            border-collapse: collapse;
            background-color: transparent;
        }

        thead {
            text-align: left;
            display: table-header-group;
            vertical-align: middle;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .center {
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>
<header>
    <div style="position:absolute; left:0;">
        <img class="img-rounded"
             src="data:image/jpeg;base64,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"
             alt="">
    </div>
    <div style="margin-left:300pt; margin-top: 20pt">
        <b>{{$issuer['name']}}</b><br/>
        {{$issuer['address'] . ', ' . $issuer['postal_code'] . ' ' . $issuer['place']}}<br/>
        {{ ($issuer['phone_num'] ? 'Phone: ' . $issuer['phone_num'] : '') . ($issuer['phone_num'] &&
            $issuer['fax'] ? ' / ' : '') . ($issuer['fax'] ? 'Fax: ' . $issuer['fax'] : '') }}<br/>
        {{$issuer['email']}}{{ ($issuer['email'] && $issuer['url']) ? ' / ' : '' }}{{$issuer['url']}}<br/>
        <!-- PIB equals VAT ++++ MB equals ID !-->
        {{'VAT: ' . $issuer['tax_code'] . ' / ID: ' . $issuer['company_id']}}<br/>
        {{$issuer['bank_name'] . ' / ' . $issuer['iban']}}<br/>
    </div>
    <br/>
</header>
<hr/>
<main>
    <div style="clear:both; position:relative;">
        <div style="position:absolute; left:0; width:250pt;">
            <h4>Invoice Details:</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>Invoice number: </b>{{$invoice_num}}<br/>
                    <b>Invoice date: </b>{{$invoice_date}}<br/>
                    <b>Invoice location: </b>{{$invoice_location}}<br/>
                    <b>Due date: </b>{{$due_date}}<br/>
                    <b>Due location: </b>{{$due_location}}<br/>
                    <b>Payment method: </b>{{ucwords(strtolower(str_replace("_", " ", $payment_method)))}}<br/>
                    <b>Payment deadline: </b>{{$payment_deadline}}<br/>
                    <b>Fiscal recipient number: </b>{{$fiscal_receipt_num}}<br/>
                </div>
            </div>
        </div>
        <div style="margin-left: 300pt;">
            <h4>Recipient Details:</h4>
            <div class="panel panel-default">
                <div class="panel-body">
                    {{$recipient['name']}}<br/>
                    {{$recipient['address']}}<br/>
                    {{$recipient['postal_code'] . ' ' . $recipient['place']}}<br/>
                    {{ isset($recipient['iban']) && $recipient['iban'] !== '' && isset($recipient['bank_name'])
                        && $recipient['bank_name'] !== '' ? $recipient['bank_name'] . ' / ' . $recipient['iban'] :
                        (isset($recipient['iban']) && $recipient['iban'] !== '' ? $recipient['iban'] : '') }}
                    <br/>
                    Phone: {{$recipient['phone_num'] ?? ''}}<br/>
                    Fax: {{$recipient['fax'] ?? ''}}<br/>
                    VAT: {{$recipient['tax_code'] ?? ''}}<br/>
                </div>
            </div>
        </div>
    </div>

    <table class="table table-bordered" style="margin-top: 20pt">
        <thead>
        <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Unit</th>
            <th>Quantity</th>
            <th>Rebate</th>
            <th>Total Price</th>
            <th>VAT (%)</th>
            <th>Total Price with VAT</th>
        </tr>
        </thead>
        <tbody>
        @foreach($invoice_items as $i=>$invoice_item)
            <tr>
                <td class="center">{{$i + 1}}.</td>
                <td>{{(strlen($invoice_item['name']) > 32) ? substr($invoice_item['name'], 0, 29) . '...' :
                        $invoice_item['name']}}</td>
                <td class="center">{{$invoice_item['unit']}}</td>
                <td class="center">{{$invoice_item['quantity']}}</td>
                <td class="center">{{$invoice_item['rebate'] ?? '-'}}</td>
                <td class="center">{{$invoice_item['base_amount']}}</td>
                <td class="center">{{$invoice_item['vat_percentage']}}</td>
                <td class="center">{{$invoice_item['total_price']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div style="clear:both; position:relative;">
        <div style="margin-left: 300pt; margin-top: 15pt">
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <td><b>Subtotal</b></td>
                    <td>{{($total_price + $total_vat - $total_vat) . ' ' . $currency}}</td>
                </tr>
                <tr>
                    <td><b>Total VAT</b></td>
                    <td>{{$total_vat . ' ' . $currency}}</td>
                </tr>
                <tr>
                    <td><b>To Pay</b></td>
                    <td><b>{{$total_price + $total_vat . ' ' . $currency}}</b></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <br/><br/>
    <!-- Mock footnote -->
    <div style="display: inline-flex; justify-content: start;">
        <div style="width: 100%"><p>Issuer: ______________________________</p></div>
    </div>
    <div style="display: inline-flex; justify-content: end;">
        <div style="width: 100%; margin-left: 170pt;"><p>Recipient: ______________________________</p></div>
    </div>
</main>
</body>
</html>
