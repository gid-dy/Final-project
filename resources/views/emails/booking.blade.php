<html>
    <body>
        <table width='700px'>
            <tr>
                <td>Dear {{ $SurName }}</td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td><h4>GHANA<span style="color: #fafd44;">TREK</span></h4></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Hello {{ $SurName }} {{ $OtherNames }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Thank you for booking a tour with us. Your booking details are as below :-</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Booking No: {{ $Booking_id }}</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    <table width='95%' cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                        <tr bgcolor="#CCCCCC">
                            <td>Package Name</td>
                            <td>Package Code</td>
                            <td>TourTypeName</td>
                            <td>Travellers</td>
                            <td>Package Price</td>
                        </tr>
                        @foreach($tourpackagesDetails['bookings'] as $tourpackage)
                            <tr>
                                <td>{{ $tourpackage['PackageName'] }}</td>
                                <td>{{ $tourpackage['PackageCode'] }}</td>
                                <td>{{ $tourpackage['TourTypeName'] }}</td>
                                <td>{{ $tourpackage['Travellers'] }}</td>
                                <td>{{ $tourpackage['PackagePrice'] }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" align="right">Coupon Discount</td>
                            <td>GHS {{ $tourpackagesDetails['Amount'] }}</td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">Grand Total</td>
                            <td>GHS {{ $tourpackagesDetails['Grand_total'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td>
                    <table width="100%">
                        <tr>
                            <td width="50%">
                                <table>
                                    <tr>
                                        <td><strong>Billing Address:-</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['SurName'] }} {{ $userDetails['OtherNames'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['Country'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['Address'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['City'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['State'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['ZipCode'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['Mobile'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $userDetails['OtherContact'] }}</td>
                                    </tr>
                                </table>
                            </td>
                            <td width="50%">
                                <table>
                                    <tr>
                                        <td><strong>Travelling Address:-</strong></td>
                                    </tr>
                                    <tr>
                                        <td>{{ $tourpackagesDetails['SurName'] }} {{ $tourpackagesDetails['OtherNames'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $tourpackagesDetails['Country'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $tourpackagesDetails['Address'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $tourpackagesDetails['City'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $tourpackagesDetails['State'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $tourpackagesDetails['ZipCode'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $tourpackagesDetails['Mobile'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $tourpackagesDetails['OtherContact'] }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>For any enquiries, you can contact us at <a href="mailto:info@ghanatrek.com">info@ghanatrek.com</a></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>Regards,<br> Team GhanaTrek</td></tr>
            <tr><td>&nbsp;</td></tr>
        </table>
    </body>
</html>
