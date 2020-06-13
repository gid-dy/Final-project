@extends('layouts.frontLayout.userdesign')
    @section('content')
    <?php use App\Booking; ?>

    <section>
        <div class="container">
            <div class="row" style="margin-top: 30px;">
                <div class="jumbotron text-center">
                    <h3>CANCELLATION CONFIRMATION</h3>
                    <p>The booking has been successfully cancelled.</p>
                    <p>We're sorry this booking didn't work out for you <br> But we hope we will see you again...right?</p>

                    <hr>


            </div>
        </div>
    </section>

@endsection
<?php
Session::forget('Grand_total');
Session::forget('Booking_id');
?>
