@extends('layouts.frontLayout.userdesign')
    @section('content')
    <?php use App\Booking; ?>


    <section>
        <div class="container">
            <div class="row" style="margin-top: 30px;">
                <div class="jumbotron text-center">
                    <h3>YOUR BOOKING HAS BEEN PLACED</h3>
                    <p class="lead">Your booking number is <strong>{{ Session::get('Booking_id') }}</strong> and total payable about is <strong>GHS {{ Session::get('Grand_total') }}</strong></p>
                    <p>Please make payment by clicking on below Payment Button</p>
                    <?php $bookingDetails = Booking::getBookingDetails(Session::get('Booking_id'));
                        $bookingDetails =json_decode(json_encode($bookingDetails));
                    ?>

                    <form>
                        <a class="flwpug_getpaid"
                        data-PBFPubKey="FLWPUBK_TEST-5965fb4812dc969ac15790abd7ffffa2-X"
                        data-txref="RV128954"
                        data-amount="{{  $bookingDetails->Grand_total }}"
                        data-customer_email="{{  $bookingDetails->UserEmail }}"
                        data-meta-flightID="APX0093GHK"
                        data-currency="GHS"
                        data-type="mobile_money_ghana"
                        data-voucher="143256743"
                        data-network="MTN"
                        data-pay_button_text="Pay Now"
                        data-country="GH"
                        data-redirect_url="{{ url('flutterwave/thanks') }}"></a>

                        <script type="text/javascript" src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                    </form>
                    <hr>


            </div>
        </div>
    </div>
    </section>

@endsection
<?php
Session::forget('Grand_total');
Session::forget('Booking_id');
?>
