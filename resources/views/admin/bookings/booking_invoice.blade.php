<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <h2 style="text-align:center">GHANA<span style="color: #fafd44;">TREK</span></h2>
    		<div class="invoice-title">
                <h4>Invoice</h4><h3 class="pull-right">Booking #{{ $bookingDetails->id }}<br><br>
                    <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($bookingDetails->id, "C39")}}" alt="barcode" /><h3>
    		</div>
            <hr>
            <br><br>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<strong>Billed To:</strong><br>
                    {{ $userDetails->SurName}} {{ $userDetails->OtherNames}}</br>
                    {{ $userDetails->Country}}</br>
                    {{ $userDetails->Address}}</br>
                    {{ $userDetails->City}}</br>
                    {{ $userDetails->State}}</br>
                    {{ $userDetails->ZipCode}}</br>
                    {{ $userDetails->Mobile}}</br>
                    {{ $userDetails->OtherContact }}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<strong>Shipped To:</strong><br>
                    {{ $bookingDetails->SurName}} {{ $bookingDetails->OtherNames}}</br>
                    {{ $bookingDetails->Country}}</br>
                    {{ $bookingDetails->Address}}</br>
                    {{ $bookingDetails->City}}</br>
                    {{ $bookingDetails->State}}</br>
                    {{ $bookingDetails->ZipCode}}</br>
                    {{ $bookingDetails->Mobile}}</br>
                    {{ $bookingDetails->OtherContact }}
    				</address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br>
    					{{ $bookingDetails->Payment_method }}
    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Booking Date:</strong><br>
    					{{ $bookingDetails->created_at }}<br><br>
    				</address>
    			</div>
    		</div>
    	</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Booking summary</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td style="width:10%"><strong>PackageCode</strong></td>
        							<td style="width:10%" class="text-center"><strong>TourTypeName</strong></td>
        							<td style="width:10%" class="text-center"><strong>PackagePrice</strong></td>
        							<td style="width:10%" class="text-center"><strong>Travellers</strong></td>
        							<td style="width:10%" class="text-right"><strong>Total</strong></td>
                                </tr>
    						</thead>
    						<tbody>
    							<?php $Subtotal = 0; ?>
                                    @foreach($bookingDetails->bookings as $pro)
                                    <tr>
                                        <td class="text-left">{{ $pro->PackageCode }}</td>
                                        <td class="text-center">{{ $pro->TourTypeName }}</td>
                                        <td class="text-center">GHS {{ $pro->PackagePrice }}</td>
                                        <td class="text-center">{{ $pro->Travellers }}</td>
                                        <td class="text-right">GHS {{ $pro->PackagePrice * $pro->Travellers }}</td>
                                    </tr>
                                    <?php $Subtotal = $Subtotal + ($pro->PackagePrice * $pro->Travellers); ?>
                                    @endforeach
    							<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><strong>Subtotal</strong></td>
    								<td class="thick-line text-right">GHS {{ $Subtotal }}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Coupon Discount (-)</strong></td>
    								<td class="no-line text-right">GHS {{ $bookingDetails->Amount }}</td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><strong>Grand Total</strong></td>
    								<td class="no-line text-right">GHS {{ $bookingDetails->Grand_total }}</td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>
