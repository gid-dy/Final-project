<?php
$current_month = date('M');
$last_month = date('M',strtotime("-1 month"));
$last_to_last_month = date('M', strtotime("-2 month"));

$dataPoints = array(
    array("y" => $current_month_users, "label" => $current_month),
    array("y" => $last_month_users, "label" => $last_month),
	array("y" => $last_to_last_month_users, "label" => $last_to_last_month),


);

?>

@extends('layouts.adminLayout.admin_design')
@section('content')
<script>
    window.onload = function () {

    var chart = new CanvasJS.Chart("chartContainer", {
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
    chart.render();

    }
</script>
<div id="content" class="col-lg-12">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Report</a> <a href="#" class="current">View Users Repoting</a> </div>
    <h1>Users Reporting</h1>

  </div>

  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>users reporting</h5>
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
