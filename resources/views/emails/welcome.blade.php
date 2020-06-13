<html>
    <head>
        <title>Confirmation Email</title>
    </head>
    <body>
        <table>
            <tr><td>Dear {{ $SurName }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Your account has been successfully activated.</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Your account information is as below</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Email: {{ $UserEmail }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Password: ***** (as chosen by you)</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thanks $ Regards,</td></tr>
            <tr><td>GhanaTrek</td></tr>
        </table>
    </body>
</html>
