@extends('layouts.frontLayout.userdesign')
    @section('content')
    <?php use App\Booking; ?>

    <section>
        <div class="container">
            <div class="row" style="margin-top: 30px;">
                <div class="jumbotron text-center">
                    <h3>YOUR IPAY BOOKING HAS BEEN PLACED</h3>
                    <p>Thanks for the payment. We will process your booking very soon</p>
                    <hr>


            </div>
        </div>
    </section>

@endsection
<?php
Session::forget('Grand_total');
Session::forget('Booking_id');
?>
