<?php
$current_month = date('M');
$last_month = date('M',strtotime("-1 month"));
$last_to_last_month = date('M', strtotime("-2 month"));

$dataPoints = array(
	array("y" => $last_to_last_month_users, "label" => $last_to_last_month),
    array("y" => $last_month_users, "label" => $last_month),
    array("y" => $current_month_users, "label" => $current_month),

);

?>
@extends('layouts.adminLayout.admin_design')
@section('content')
<script>
    window.onload = function () {
    var chart1 = new CanvasJS.Chart("users", {
        title: {
            text: "Users Reporting"
        },
        axisY: {
            title: "Number of Users"
        },
        data: [{
            type: "line",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    var chart2 = new CanvasJS.Chart("booking", {
        animationEnabled: true,
        theme: "light2", // "light1", "light2", "dark1", "dark2"
        title:{
            text: "Booking Reporting"
        },
        axisY: {
            title: "Number of bookings"
        },
        data: [{
            type: "column",
            showInLegend: true,
            legendMarkerColor: "grey",
            legendText: "last 3 Months",
            dataPoints: [
                { y: <?php echo $last_to_last_month_booking; ?>,  label: "<?php echo $last_to_last_month; ?>" },
                { y: <?php echo $last_month_booking; ?>,  label: "<?php echo $last_month; ?>" },
                { y: <?php echo $current_month_booking; ?>, label: "<?php echo $current_month; ?>" }
            ]
        }]
    });
    var chart3 = new CanvasJS.Chart("country", {
        animationEnabled: true,
        title: {
            text: "Registered Users Country Count"
        },
        data: [{
            type: "pie",
            startAngle: 240,
            //yValueFormatString: "##0.00\"%\"",
            indexLabel: "{label} {y}",
            dataPoints: [
                {y: <?php echo $getUserCountries[0]['count']; ?>, label: "<?php echo $getUserCountries[0]['Country']; ?>"},
                {y: <?php echo $getUserCountries[1]['count']; ?>, label: "<?php echo $getUserCountries[1]['Country']; ?>"},
                {y: <?php echo $getUserCountries[2]['count']; ?>, label: "<?php echo $getUserCountries[2]['Country']; ?>"},

            ]
        }]
    });
    chart1.render();
    chart2.render();
    chart3.render();
}
</script>

{{-- main-container-part --}}
<div id="content">
    <!--breadcrumbs-->
    <div id="content-header">
            <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a></div>
    </div>
    <!--End-breadcrumbs-->
    @if (Session::has('flash_message_error'))
            <div class="alert alert-error alert-block">
                <button type="button" class="close" data-dismiss='alert'></button>
                <strong>{!! session('flash_message_error') !!}</strong>
            </div>
        @endif
        @if (Session::has('flash_message_success'))
            <div class="alert alert-success alert-block">
                <button type="button" class="close" data-dismiss='alert'></button>
                <strong>{!! session('flash_message_success') !!}</strong>
            </div>
        @endif

    <!--Action boxes-->
    <div class="container-fluid">
        <div class="quick-actions_homepage">
            <ul class="quick-actions">
                <li class="bg_lb"> <a href="{{ url('admin/dashboard') }}"> <i class="icon-dashboard"></i> <span class="label label-important"></span> My Dashboard </a> </li>
                {{-- <li class="bg_lg span3"> <a href="charts.html"> <i class="icon-signal"></i> Charts</a> </li> --}}
                @if(Session::get('adminDetails')['Categories_access']==1)
                    <li class="bg_ly"> <a href="{{ url('admin/add-category') }}"> <i class="icon-inbox"></i><span class="label label-success"></span> Categories </a> </li>
                @endif
                @if(Session::get('adminDetails')['Tourpackages_access']==1)
                    <li class="bg_lr"> <a href="{{ url('admin/add-tour') }}"> <i class="icon-inbox"></i><span class="label label-success"></span> Tourpackages </a> </li>
                @endif
                @if(Session::get('adminDetails')['Bookings_access']==1)
                    <li class="bg_lg"> <a href="{{ url('admin/view-bookings') }}"> <i class="icon-inbox"></i><span class="label label-success"></span> Bookings </a> </li>
                @endif
                    @if(Session::get('adminDetails')['Users_access']==1)
                    <li class="bg_ls"> <a href="{{ url('admin/view-users') }}"> <i class="icon-inbox"></i><span class="label label-success"></span> Users </a> </li>
                @endif

            </ul>
        </div>
        <!--End-Action boxes-->

        <!--Chart-box-->
        <div class="row-fluid">
        <div class="widget-box">
            <div class="widget-title bg_lg"><span class="icon"><i class="icon-signal"></i></span>
            <h5>Users Reporting</h5>
            </div>
            <div class="widget-content" >
            <div class="row-fluid">
                <div class="span12">
                    <div id="users" style="height: 370px; width: 100%;"></div>
                </div>

            </div>
            </div>
        </div>
        </div>
        <!--End-Chart-box-->
        <hr/>
        <div class="row-fluid">
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title bg_ly" ><span class="icon"><i class="icon-chevron-down"></i></span>
                        <h5>Bookings Reporting</h5>
                    </div>
                    <div class="widget-content nopadding collapse in" id="collapseG2">
                        <div id="booking" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
            <div class="span6">
                <div class="widget-box">
                    <div class="widget-title bg_ly" ><span class="icon"><i class="icon-chevron-down"></i></span>
                        <h5>Registered Users by Country</h5>
                    </div>
                    <div class="widget-content nopadding collapse in" id="collapseG2">
                        <div id="country" style="height: 370px; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--end-main-container-part-->
@endsection
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
