<html lang="en-US">
<head>
    <meta charset="text/html">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }

        .button {
            background-color: yellow; /* Green */
            color: #000000;
            padding: 5px;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 20px;
            font-weight: 700;
        }

        .button_2 {
            background-color: #90d846; /* Green */
            color: #000;
            padding: 5px;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 20px;
            font-weight: 700;
        }
    </style>
</head>
<body>
<p>Dear {{ $name }} ,</p>
<p>Your order#<a href="{{ route('order_detail', $invoice_no) }}" class="button_2">{{ $invoice_no }}</a> is {{ $status }}. {{ $request_message }}</p>
<p>{{ $note_message }}​</p>

<br />
<p>Regards,</p>
<p><a href="{{ route('index') }}" target="_blank">ENZO.FASHION</a></p>
</body>
</html>