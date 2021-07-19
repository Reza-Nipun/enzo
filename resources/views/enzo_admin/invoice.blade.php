<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Invoice</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="">
<link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet" type='text/css'>

<!-- favicon start -->
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('enzo_website_assets/images/favicon/apple-touch-icon.png') }}">
<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('enzo_website_assets/images/favicon/favicon-32x32.png') }}">
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('enzo_website_assets/images/favicon/favicon-16x16.png') }}">
<link rel="manifest" href="{{ asset('enzo_website_assets/images/favicon/site.webmanifest') }}">
<!-- favicon end -->

<style>
    /*body {*/
        /*-webkit-print-color-adjust: exact !important;*/
    /*}*/

    #invoice{
        padding: 30px;
    }

    .invoice {
        position: relative;
        background-color: #FFF;
        min-height: 680px;
        padding: 15px
    }

    .invoice header {
        padding: 10px 0;
        margin-bottom: 20px;
        border-bottom: 1px solid #3989c6
    }

    .invoice .company-details {
        text-align: right
    }

    .invoice .company-details .name {
        margin-top: 0;
        margin-bottom: 0
    }

    .invoice .contacts {
        margin-bottom: 20px
    }

    .invoice .invoice-to {
        text-align: left
    }

    .invoice .invoice-to .to {
        margin-top: 0;
        margin-bottom: 0
    }

    .invoice .invoice-details {
        text-align: right
    }

    .invoice .invoice-details .invoice-id {
        margin-top: 0;
        color: #3989c6;
        font-size: 1.5rem;
    }

    .invoice main {
        padding-bottom: 25px
    }

    .invoice main .thanks {
        margin-top: -100px;
        font-size: 2em;
        margin-bottom: 50px
    }

    .invoice main .notices {
        padding-left: 6px;
        border-left: 6px solid #3989c6
    }

    .invoice main .notices .notice {
        font-size: 1em
    }

    .invoice table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;
        margin-bottom: 10px;
    }

    .invoice table td,.invoice table th {
        padding: 15px;
        background: #eee;
        border-bottom: 1px solid #fff
    }

    .invoice table th {
        white-space: nowrap;
        font-weight: 500;
        font-size: 15px;
        border: 1px solid rgba(152, 231, 255, 0.52);
    }

    .invoice table td h3 {
        margin: 0;
        font-weight: 400;
        color: #3989c6;
        font-size: 1.2em
    }

    .invoice table .qty,.invoice table .total,.invoice table .unit {
        text-align: right;
        font-size: 15px;
    }

    .invoice table .no {
        color: #000000;
        font-size: 14px;
        background: #eee
    }

    .invoice table .unit {
        background: #ddd
    }

    .invoice table .total {
        background: #eee;
        color: #000000
    }

    .invoice table tbody > tr > td {
        border: 1px solid rgba(152, 231, 255, 0.52)
    }

    .invoice table tfoot td {
        background: 0 0;
        border-bottom: none;
        white-space: nowrap;
        text-align: right;
        padding: 10px 20px;
        font-size: 16px;
        border-top: 1px solid #aaa
    }

    .invoice table tfoot tr:first-child td {
        border-top: none
    }

    .invoice table tfoot tr:last-child td {
        color: #3989c6;
        font-size: 18px;
        border-top: 1px solid #3989c6
    }

    .invoice table tfoot tr td:first-child {
        border: none
    }

    .invoice footer {
        width: 100%;
        text-align: center;
        color: #777;
        border-top: 1px solid #aaa;
        padding: 8px 0
    }

    @media print {
        .invoice {
            font-size: 12px!important;
            overflow: hidden!important
        }

        .invoice footer {
            position: absolute;
            bottom: 10px;
            page-break-after: always
        }

        .invoice>div:last-child {
            page-break-before: always
        }

        .hidden-print{
            display: none !important;
        }
    }

    @page {
        size: auto !important;
    }
</style>

<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<body>

<div id="invoice">

    <div class="toolbar hidden-print">
        <div class="text-right">
            <button id="printInvoice" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
        </div>
        <hr>
    </div>
    <div class="invoice overflow-auto">
        <div style="min-width: 600px">
            <header>
                <div class="row">
                    <div class="col-8">
                        <a target="_blank" href="https://lobianijs.com">
                            <img src="{{ asset('storage/uploads/'.$company_info[0]->company_logo) }}" width="250" data-holder-rendered="true" />
                        </a>
                    </div>
                    <div class="col-4 company-details">
                        <h2 class="name">
                             {{ $company_info[0]->company_name }}
                        </h2>
                        <div>{{ $company_info[0]->company_full_address }}</div>
                        <div>{{ $company_info[0]->company_phone }}</div>
                        <div>{{ $company_info[0]->company_email }}</div>
                    </div>
                </div>
            </header>
            <main>
                <div class="row contacts">
                    <div class="col invoice-to">
                        <div class="text-gray-light">SHIPMENT TO:</div>
                        <h5 class="to">{{ $order_info->contact_person_name }}</h5>
                        <div class="address">Address: {{ $order_info->contact_person_shipping_address }}</div>
                        <div class="email">Email: {{ $order_info->contact_person_email }}</div>
                        <div class="email">Phone: {{ $order_info->contact_person_contact_no }}</div>
                    </div>
                    <div class="col invoice-details">
                        <h1 class="invoice-id">INVOICE# {{ $order_info->invoice_no }}</h1>
                        <div class="date">Date of Invoice: {{ date('Y-m-d') }}</div>
                    </div>
                </div>
                <table border="0" cellspacing="0" cellpadding="0">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">PRODUCT NAME</th>
                            <th class="text-center">COLOR</th>
                            <th class="text-center">SIZE</th>
                            <th class="text-center">QUANTITY</th>
                            <th class="text-center">UNIT PRICE</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($order_detail as $k => $order)
                        <tr>
                            <td class="text-center no">{{ $k+1 }}</td>
                            <td class="text-center no">
                                {{ $order->product_name }}
                            </td>
                            <td class="text-center no">
                                {{ $order->color }}
                            </td>
                            <td class="text-center no">
                                {{ $order->size }}
                            </td>
                            <td class="total text-center">
                                {{ $order->quantity }}
                            </td>
                            <td class="total text-center">
                                {{ $order->price }}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">SUBTOTAL</td>
                        <td class="text-center">৳ {{ $order_info->total_amount }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">SHIPMENT CHARGE</td>
                        <td class="text-center">৳ {{ $order_info->shipment_charge }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">VAT({{ $company_info[0]->vat_percentage }}%)</td>
                        <td class="text-center">৳ {{ $order_info->vat_amount }}</td>
                    </tr>
                    <tr>
                        <td colspan="3"></td>
                        <td colspan="2">NET AMOUNT</td>
                        <td class="text-center">
                            ৳ {{ $order_info->net_amount }}
                            @if($order_info->payment_status == 1)
                                <span class="badge badge-success">Paid</span>
                            @elseif($order_info->payment_status == 0)
                                <span class="badge badge-danger">Not Paid</span>
                            @endif
                        </td>
                    </tr>
                    </tfoot>
                </table>
                {{--<div class="thanks">Thank you!</div>--}}
                <div class="notices">
                    {{--<div>NOTICE:</div>--}}
                    <div class="notice">Have a great day! Thank you for shopping on ENZO.</div>
                </div>
            </main>
            <footer>
                Invoice was created on a computer and is valid without the signature and seal.
            </footer>
        </div>
        <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
        <div></div>
    </div>
</div>
<script type="text/javascript">
    $('#printInvoice').click(function(){
        Popup($('.invoice')[0].outerHTML);
        function Popup(data)
        {
            window.print();
            return true;
        }
    });
</script>

</body>
</html>