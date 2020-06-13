@extends('layouts.frontLayout.userdesign')
    @section('content')


    <section>
        <div class="container">
            <div class="row" style="margin-top: 30px;">
                <section class="post-wrapper-top">
                    <div class="container">
                        <div class="breadcrumb withpadding1">
                            <ul class="breadcrumb">
                                <li><a href="{{ url('/') }}">Home</a></li>
                                <li><a href="{{ url('Bookings') }}">Booking</a></li>
                            </ul>
                        </div>
                    </div>
                </section>

                <section class="" style="padding-top: 50px;">
                    <div class="container">
                        <div class="heading" style="align:center">
                            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Booked TourPackage</th>
                                        <th>Payment Method</th>
                                        <th>Grand Total</th>
                                        <th>created on</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->id }}</td>
                                        <td class="withpadding1">
                                            @foreach($booking->bookings as $pro)
                                                <a href="{{ url('/Bookings/'.$booking->id) }}" >{{ $pro->PackageCode }}</a><br>
                                            @endforeach
                                        </td>
                                        <td>{{ $booking->Payment_method }}</td>
                                        <td>{{ $booking->Grand_total }}</td>
                                        <td>{{ $booking->created_at }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>

@endsection

