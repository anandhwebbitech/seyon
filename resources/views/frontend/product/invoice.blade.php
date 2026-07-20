<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Invoice</title>

<style>
    body{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        color:#000;
    }
    table{
        width:100%;
        border-collapse:collapse;
    }
    .text-right{ text-align:right; }
    .text-center{ text-align:center; }
    .mb-10{ margin-bottom:10px; }
    .mb-20{ margin-bottom:20px; }

    .invoice-box{
        max-width:800px;
        margin:auto;
        border:1px solid #000;
        padding:15px;
    }

    .header{
        display:flex;
        justify-content:space-between;
        align-items:center;
        border-bottom:1px solid #000;
        padding-bottom:10px;
    }

    .header img{
        max-width:180px;
    }

    .invoice-title{
        font-size:18px;
        font-weight:bold;
    }

    .address-table td{
        vertical-align:top;
        padding:5px 0;
    }

    .product-table th,
    .product-table td{
        border:1px solid #000;
        padding:6px;
    }

    .product-table th{
        background:#f2f2f2;
    }

    .total-table td{
        padding:6px;
    }

    .total-table tr td:last-child{
        text-align:right;
    }

    .signature{
        margin-top:40px;
        text-align:right;
    }
</style>
</head>

<body>

<div class="invoice-box">

    <!-- HEADER -->
    <div class="header mb-20">
        <img src="{{ public_path('frontend/img/logo.png') }}" width="120">
        <div class="invoice-title">INVOICE</div>
    </div>

    <!-- INVOICE DETAILS -->
    <table class="mb-20">
        <tr>
            <td>
                <strong>Invoice No:</strong> {{ $data['invoiceNumber'] }}<br>
                <strong>Date:</strong> {{ date('d-m-Y', strtotime($data['order']->created_at)) }}
            </td>
            <td class="text-right">
                <strong>Order No:</strong> {{ $data['order']->id }}
            </td>
        </tr>
    </table>

    <!-- ADDRESS -->
    <table class="address-table mb-20">
        <tr>
            <td width="50%">
                <strong>From:</strong><br>
                <b>Webbitech</b><br>
                Coimbatore,<br>
                Tamil Nadu<br>
                Phone: +91 8012580100
            </td>

            <td width="50%">
                <strong>Ship To:</strong><br>
                {{ $data['shipping_address']->shipping_name }}<br>
                {{ $data['shipping_address']->shipping_address }}<br>
                {{ $data['shipping_address']->cityDetail->name }}, {{ $data['shipping_address']->stateDetail->name }}<br>
                {{ $data['shipping_address']->countryDetail->name }} - {{ $data['shipping_address']->pincode }}<br>
                Phone: {{ $data['shipping_address']->shipping_phone }}
            </td>
        </tr>
    </table>

    <!-- PRODUCT TABLE -->
    <table class="product-table mb-20">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th>Product</th>
                <th width="15%">Rate</th>
                <th width="10%">Qty</th>
                <th width="15%">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $subTotal = 0; @endphp
            @foreach($data['order_details'] as $key => $item)
                @php
                    $lineTotal = $item->offer_price * $item->quantity;
                    $subTotal += $lineTotal;
                @endphp
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td>{{ $item->productname }}</td>
                    <td class="text-right">{{ number_format($item->offer_price,2) }}</td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($lineTotal,2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- TOTALS -->
    @php
        $coupon = $data['order']->coupon_discount ?? 0;
        $shipping = $data['order']->shipping_cost ?? 0;
        $gift = $data['order_details']->first()->giftWrap->price ?? 0;
        $grandTotal = $subTotal - $coupon + $shipping + $gift;
    @endphp

    <table class="total-table" width="40%" align="right">
        <tr>
            <td>Sub Total</td>
            <td>{{ number_format($subTotal,2) }}</td>
        </tr>
        <tr>
            <td>Coupon Discount</td>
            <td>- {{ number_format($coupon,2) }}</td>
        </tr>
        <tr>
            <td>Shipping</td>
            <td>{{ number_format($shipping,2) }}</td>
        </tr>
        @if($gift > 0)
        <tr>
            <td>Gift Wrap</td>
            <td>{{ number_format($gift,2) }}</td>
        </tr>
        @endif
        <tr>
            <td><strong>Grand Total</strong></td>
            <td><strong>{{ number_format($grandTotal,2) }}</strong></td>
        </tr>
    </table>

    <!-- SIGNATURE -->
    <div class="signature">
        <img src="{{ public_path('frontend/img/logo.png') }}" width="120"><br>
        <strong>Authorized Signatory</strong>
    </div>

</div>

</body>
</html>
