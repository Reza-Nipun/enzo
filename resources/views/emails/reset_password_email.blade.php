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
<p>Dear {{ $name }} ,</p>
<p>You are receiving this email because we received a password reset request for your account.</p>

<a href="{{ route('customer_reset_password_link', [$email, $token]) }}" class="button">Click Here to Reset Your Password</a>

<p>This password reset link will expire in 60 minutes.</p>
<p>If you did not request a password reset, no further action is required.</p>

<br />
<br />
<p>Regards,</p>
<p><a href="{{ route('index') }}" target="_blank">ENZO.FASHION</a></p>
</body>
</html>