<?php
$current_month = date('M');
$last_month = date('M',strtotime("-1 month"));
$last_to_last_month = date('M', strtotime("-2 month"));


?>

@extends('layouts.adminLayout.admin_design')
@section('content')

<script>
    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
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
                { y: <?php echo $current_month_booking; ?>, label: "<?php echo $current_month; ?>" },
                { y: <?php echo $last_month_booking; ?>,  label: "<?php echo $last_month; ?>" },
                { y: <?php echo $last_to_last_month_booking; ?>,  label: "<?php echo $last_to_last_month; ?>" }

            ]
        }]
    });
    chart.render();

    }
    </script>

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Tour Packages</a> <a href="#" class="current">Add Tour Package</a> </div>
    <h1>Tour Packages</h1>

  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Tour Package</h5>
          </div>

          <div class="widget-content nopadding">
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
