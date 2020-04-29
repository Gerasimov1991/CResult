<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>C Results</title>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600,700,800,900" rel="stylesheet">

</head>

<body style="background:#f1f1f1;padding-top:20px;padding-bottom:20px;">
    <center>
        <table class="" border="0" cellspacing="0" cellpadding="0" width="600"
            style="width:6.25in;background:#ffffff; border-collapse:collapse">
            <tbody>
                <tr>
                    <td height="10"></td>
                </tr>
               
                <tr>
                    <td>
                        <p style="color:#000000;font-size:16px;">
                            <b>Card Name:</b><span>{{ $card['name'] }}</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="color:#000000;font-size:16px;">
                            <b>Card Title:</b><span>{{ $card['title'] }}</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="color:#000000;font-size:16px;">
                            <b>Details:</b><span>{{ $card['package_details'] }}</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="color:#000000;font-size:16px;">
                            <b>Price:</b><span>{{ $card['package_price'] }}</span>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="color:#000000;font-size:16px;">
                            <b>Proof:</b><a download href="{{ $card['url'] }}">{{ $card['url'] }}</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td height="30"></td>
                </tr>
            </tbody>
        </table>


    </center>
</body>

</html>
