@extends('layouts.adminLayout.admin_design')
@section('content')
<!--main-container-part-->
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#" class="current">Booking</a> </div>
            <h1>Booking #{{ $bookingDetails->id }}</h1>
            @if (Session::has('flash_message_success'))
                <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss='alert'></button>
                    <strong>{!! session('flash_message_success') !!}</strong>
                </div>
            @endif
        </div>
        <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                    <h5>Client Details</h5>
                    </div>
                    <div class="widget-content nopadding">
                    <table class="table table-striped table-bordered">
                        <tbody>
                        <tr>
                            <td class="taskDesc">Booking Date</td>
                            <td class="taskStatus">{{ $bookingDetails->created_at }}</td>
                        </tr>
                        <tr>
                            <td class="taskDesc">Booking Status</td>
                            <td class="taskStatus">{{ $bookingDetails->Status }}</td>
                        </tr>
                        <tr>
                            <td class="taskDesc">Grand_total</td>
                            <td class="taskStatus">GHS {{ $bookingDetails->Grand_total }}</td>
                        </tr>
                        <tr>
                            <td class="taskDesc">Coupon Code</td>
                            <td class="taskStatus">{{ $bookingDetails->CouponCode }}</td>
                        </tr>
                        <tr>
                            <td class="taskDesc">Coupon Amount</td>
                            <td class="taskStatus">GHS {{ $bookingDetails->Amount }}</td>
                        </tr>
                        <tr>
                            <td class="taskDesc">Payment Method</td>
                            <td class="taskStatus">{{ $bookingDetails->Payment_method }}</td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>


                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="accordion-heading">
                            <div class="widget-title">
                                <h5>Billing Address</h5>
                            </div>
                        </div>
                        <div class="collapse in accordion-body" id="collapseGOne">
                            <div class="widget-content">
                                {{ $userDetails->SurName}} {{ $userDetails->OtherNames}}</br>
                                {{ $userDetails->Country}}</br>
                                {{ $userDetails->Address}}</br>
                                {{ $userDetails->City}}</br>
                                {{ $userDetails->State}}</br>
                                {{ $userDetails->ZipCode}}</br>
                                {{ $userDetails->Mobile}}</br>
                                {{ $userDetails->OtherContact }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title">
                    <h5>Client Details</h5>
                    </div>
                    <div class="widget-content nopadding">
                    <table class="table table-striped table-bordered">
                        <tbody>
                        <tr>
                            <td class="taskDesc">Client Name</td>
                            <td class="taskStatus">{{ $bookingDetails->SurName }} {{ $bookingDetails->OtherNames }}</td>
                        </tr>
                        <tr>
                            <td class="taskDesc">Client Email</td>
                            <td class="taskStatus">{{ $bookingDetails->UserEmail }}</td>
                        </tr>
                        </tbody>
                    </table>
                    </div>
                </div>


                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="accordion-heading">
                            <div class="widget-title">
                                <h5>Update Booking Status</h5>
                            </div>
                        </div>
                        <div class="collapse in accordion-body" id="collapseGOne">
                            <div class="widget-content">
                                <form action="{{ url('admin/update-booking-status') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="Booking_id" value="{{ $bookingDetails->id }}">
                                    <table width="100%">
                                        <tr>
                                            <td>
                                                <select name="Status" id="Status" class="control-label" required="">
                                                    <option value="New" @if($bookingDetails->Status == "New") selected @endif</option>New</option>
                                                    <option value="Pending" @if($bookingDetails->Status == "Pending") selected @endif>Pending</option>
                                                    <option value="Cancelled" @if($bookingDetails->Status == "Cancelled") selected @endif>Cancelled</option>
                                                    <option value="In Progress" @if($bookingDetails->Status == "In Progress") selected @endif>In Progress</option>
                                                    <option value="Delivered" @if($bookingDetails->Status == "Delivered") selected @endif>Delivered</option>
                                                    <option value="Paid" @if($bookingDetails->Status == "Paid") selected @endif>Paid</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="submit" value="Update Status">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion" id="collapse-group">
                    <div class="accordion-group widget-box">
                        <div class="accordion-heading">
                            <div class="widget-title">
                                <h5>Travelling Details</h5>
                            </div>
                        </div>
                        <div class="collapse in accordion-body" id="collapseGOne">
                            <div class="widget-content">
                                {{ $bookingDetails->SurName}} {{ $userDetails->OtherNames}}</br>
                                {{ $bookingDetails->Country}}</br>
                                {{ $bookingDetails->Address}}</br>
                                {{ $bookingDetails->City}}</br>
                                {{ $bookingDetails->State}}</br>
                                {{ $bookingDetails->ZipCode}}</br>
                                {{ $bookingDetails->Mobile}}</br>
                                {{ $bookingDetails->OtherContact }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row-fluid">
            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>PackageCode</th>
                        <th>PackageName</th>
                        <th>TourTypeName</th>
                        <th>PackagePrice</th>
                        <th>Travellers</th>
                </thead>
                <tbody>
                    @foreach($bookingDetails->bookings as $pro)
                    <tr>
                        <td>{{ $pro->PackageCode }}</td>
                        <td>{{ $pro->PackageName }}</td>
                        <td>{{ $pro->TourTypeName }}</td>
                        <td>{{ $pro->PackagePrice }}</td>
                        <td>{{ $pro->Travellers }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<!--main-container-part-->
@endsection
