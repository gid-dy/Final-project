@extends('layouts.frontLayout.userdesign')
    @section('content')
    <?php use App\Tourpackages; ?>
  <section>
    <!-- checkout-area start -->
        <div class="checkout-area ptb-100">
            <div class="container">
                <div class="row col-md-12">
                    <div class="col-md-5">
                        <div class="billing-details">
                            <h3>Billing Details</h3>
                            <div class="form-group">
                                {{ $userDetails->SurName }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->OtherNames }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->Country }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->Mobile }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->OtherContact }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->Address }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->City }}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->State}}
                            </div>
                            <div class="form-group">
                                {{ $userDetails->ZipCode}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2"></div>
                    <div class="col-md-5">
                        <div class="travelling-details">
                            <h3>Travelling Details</h3>
                            <div class="form-group">
                                {{ $travellingDetails->SurName }}
                            </div>
                            <div class="form-group">
                                {{ $travellingDetails->OtherNames }}
                            </div>
                            <div class="form-group">
                                {{ $travellingDetails->Country }}
                            </div>
                            <div class="form-group">
                                {{ $travellingDetails->Mobile }}
                            </div>
                            <div class="form-group">
                                {{ $travellingDetails->OtherContact }}
                            </div>
                            <div class="form-group">
                                {{ $travellingDetails->Address }}
                            </div>
                            <div class="form-group">
                                {{ $travellingDetails->City }}
                            </div>
                            <div class="form-group">
                                {{ $travellingDetails->State }}
                            </div>
                            <div class="form-group">
                                {{ $travellingDetails->ZipCode }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="table-responsive">
                    <table class="table table-hover your-order">
                        <thead style="background-color:yellow;">
                            <tr>
                                <th>Tour</th>
                                <th></th>
                                <th>Tour Type</th>
                                <th>Price</th>
                                <th>No of Travellers</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total_amount = 0; ?>
                            @foreach($userCart as $cart)
                                <tr>
                                    <td style="width:150px;"><img class="img-responsive" src="{{ asset('images/backend_images/tours/large/'.$cart->Imageaddress) }}"></td>
                                    <td><h4><small>{{ $cart->PackageName }}</small></h4>
                                        <h4><small>Tour Code: {{ $cart->PackageCode }}</small></h4>
                                        <p>  {{ $cart->TransportName }}</p>
                                    </td>
                                    <td><h4><small>{{ $cart->TourTypeName }}</small></h4></td>
                                    <td>
                                        <?php $PackagePrice = Tourpackages::getPackagePrice($cart->Package_id, $cart->TourTypeName); ?>
                                        <p>GHS {{ $PackagePrice }}</p>
                                    </td>
                                    <td><h4><small>{{ $cart->Travellers }}</small></h4></td>
                                    <td><p class="">GHS {{ $PackagePrice*$cart->Travellers }}.00</td>
                                </tr>
                                <?php $total_amount = $total_amount + ($PackagePrice*$cart->Travellers);.00 ?>
                            @endforeach
                            <tr>
                                <td colspan="4">&nbsp;</td>
                                <td colspan="2">
                                    <table class="table table-condensed total-result">
                                        <tr>
                                            <td>Cart Sub Total</td>
                                            <td>GHS {{ $total_amount }}</td>
                                        </tr>
                                        <tr>
                                            <td>Discount Amount (-)</td>
                                            <td>@if(!empty(Session::get('CouponAmount')))
                                                GHS {{ Session::get('CouponAmount') }}
                                                @else
                                                    GHS 0
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Grand Total</td>
                                                <?php
                                                    $Grand_total = $total_amount - Session::get('CouponAmount');
                                                    $getCurrencyRates = Tourpackages::getCurrencyRates($total_amount); ?>
                                            <td ><span class="button" data-toggle="tooltip" data-html="true" title="USD {{ $getCurrencyRates['USD_Rate'] }}<br>
                                                GBP {{ $getCurrencyRates['GBP_Rate'] }}<br>
                                                EUR {{ $getCurrencyRates['EUR_Rate'] }}<br>
                                                FRF {{ $getCurrencyRates['FRF_Rate'] }}<br>
                                                BRL {{ $getCurrencyRates['BRL_Rate'] }}">GHS {{ $Grand_total  }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <form name="paymentform" id="paymentform" action="{{ url('/place-package') }}" method="post">
                    @csrf
                    <input type="hidden" name="Grand_total" value="{{ $Grand_total }}">
                    <div class="payment-method">
                        <div class="panel-group">
                            <span>Select Payment Method:</strong></label></span>
                        </div>
                         <span class="col-md-4">
                            <label><input type="radio" id="flutterwave" name="Payment_method" value="flutterwave">
                                CARD <img src="{{ asset('images/frontend_images/payment.png') }}"></label>
                        </span>
                        <span class="col-md-4">
                            <label><input type="radio" id="ipay" name="Payment_method" value="ipay">
                                MOBILE MONEY <img src="{{ asset('images/frontend_images/ipay.jpg') }}"></label>
                        </span><br><br><br>
                        <span class="col-md-4">
                        {{--  <label><input type="radio" id="COD" name="Payment_method" value="COD">
                                COD <img src="{{ asset('images/frontend_images/payment.png') }}"></label>
                        </span>  --}}
                        <hr>

                        <div class="order-button-payment">
                            <input type="submit" onclick="return selectPaymentMethod();" value="Proceed to Payment" />
                        </div>
                    </div>
                </form>
            </div>
            <hr>

        </div>
  </section>
@endsection
