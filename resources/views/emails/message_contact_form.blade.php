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
            background-color: green; /* Green */
            color: #ffffff;
            padding: 5px;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 20px;
            font-weight: 700;
        }
    </style>
</head>
<body>

<p>{!! $query_message !!}</p>

<br />
<br />
<p>Regards,</p>
<p>{{ $name }}</p>
<p>Contact: {{ $contact_no }}</p>
<p>Email: {{ $email_address }}</p>
</body>
</html>