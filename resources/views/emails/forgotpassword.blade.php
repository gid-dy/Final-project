<html>
    <head>
        <title>Forgot Password Email</title>
    </head>
    <body>
        <table>
            <tr><td>Dear {{ $SurName }} {{ $OtherNames }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Your account has been successfully updated.<br>
                    Your account information is as below with new password:
            </td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Email: {{ $UserEmail }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>New Password: {{ $Password }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thanks $ Regards,</td></tr>
            <tr><td>GhanaTrek</td></tr>
        </table>
    </body>
</html>
