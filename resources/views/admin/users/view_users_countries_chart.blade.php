<script>
    window.onload = function() {

    var chart = new CanvasJS.Chart("chartContainer", {
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
                {y: <?php echo $getUserCountries[3]['count']; ?>, label: "<?php echo $getUserCountries[3]['Country']; ?>"},
                {y: <?php echo $getUserCountries[4]['count']; ?>, label: "<?php echo $getUserCountries[4]['Country']; ?>"},

            ]
        }]
    });
    chart.render();

    }
</script>
@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content" class="col-lg-12">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Report</a> <a href="#" class="current">View Users Repoting</a> </div>
    <h1>Users Reporting</h1>

  </div>
    <div style="margin-left:20px;">
        <a href="{{ url('/admin/export-users') }}" class="btn btn-primary btn-mini">Export</a>
    </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Users Country Reporting</h5>
          </div>

          <div class="widget-content nopadding">
            <div id="chartContainer" style="height: 300px; width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
@endsection

