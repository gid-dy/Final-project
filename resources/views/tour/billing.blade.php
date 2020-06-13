@extends('layouts.frontLayout.userdesign')
    @section('content')

  <section>
    <!-- checkout-area start -->
        <div class="checkout-area ptb-100">
        @if (Session::has('flash_message_error'))
                <div class="alert alert-error alert-block" style="background-color: #f2dfd0">
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
            <div class="container">
                <div class="row">
                    <form action="{{ url('/billing') }}" method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-5">
                                <div class="billing-details">
                                    <h3>Billing Details</h3>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>SurName</label>
                                            <input @if(!empty($userDetails->SurName)) value="{{ $userDetails->SurName }}"@endif id="billing_SurName" type="text"  name="billing_SurName" placeholder="SurName" />

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Other names</label>
                                            <input @if(!empty($userDetails->OtherNames)) value="{{ $userDetails->OtherNames }}"@endif id="billing_OtherNames" type="text"  name="billing_OtherNames" placeholder="OtherNames" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="country-select">
                                            <label>Country</label>
                                            <select  id="billing_Country" name="billing_Country" >
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                <option value="{{ $country->Country }}" @if(!empty($userDetails->Country) && $country->Country == $userDetails->Country)selected @endif>{{ $country->Country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Mobile</label>
                                            <input @if(!empty($userDetails->Mobile)) value="{{ $userDetails->Mobile }}"@endif id="billing_Mobile" type="text"  name="billing_Mobile" placeholder="Mobile"  />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Other Contact</label>
                                            <input @if(!empty($userDetails->OtherContact)) value="{{ $userDetails->OtherContact }}"@endif id="billing_OtherContact" type="text"  name="billing_OtherContact" placeholder="Other Contact"  />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Address</label>
                                            <input @if(!empty($userDetails->Address)) value="{{ $userDetails->Address }}"@endif id="billing_Address" type="text"  name="billing_Address" placeholder="Address"  />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>City</label>
                                            <input @if(!empty($userDetails->City)) value="{{ $userDetails->City }}"@endif id="billing_City" type="text"  name="billing_City" placeholder="City"  />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>State</label>
                                            <input @if(!empty($userDetails->State)) value="{{ $userDetails->State}}"@endif id="billing_State" type="text"  name="billing_State" placeholder="State" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Postal/Zip Code</label>
                                            <input @if(!empty($userDetails->ZipCode)) value="{{ $userDetails->ZipCode}}"@endif id="billing_ZipCode" type="text"  name="billing_ZipCode" placeholder="ZipCode" />
                                        </div>
                                    </div>
                                    <div class="form-check">
                                        <input value="{{ $userDetails->SurName }} {{ $userDetails->OtherNames }}" type="checkbox" class="form-check-input" id="ship-box"  />
                                        <label class="form-check-label" for="ship-box">DIFFERENT TRAVELING DETAILS ?<label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2"></div>
                            <div class="col-md-5">
                                <div class="travelling-details">
                                    <h3>Travelling Details</h3>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>SurName</label>
                                            <input @if(!empty($travellingDetails->SurName)) value="{{ $travellingDetails->SurName }}"@endif  id="travelling_SurName" type="text"  name="travelling_SurName" placeholder="SurName" />

                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="checkout-form-list">
                                            <label>Other names</label>
                                            <input @if(!empty($travellingDetails->OtherNames)) value="{{ $travellingDetails->OtherNames }}"@endif  id="travelling_OtherNames" type="text"  name="travelling_OtherNames" placeholder="OtherNames" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="country-select">
                                            <label>Country</label>
                                            <select  id="travelling_Country" name="travelling_Country" >
                                                <option value="">Select Country</option>
                                                @foreach($countries as $country)
                                                <option value="{{ $country->Country }}"@if(!empty($travellingDetails->Country) && $country->Country == $travellingDetails->Country)selected @endif>{{ $country->Country }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Mobile</label>
                                            <input @if(!empty($travellingDetails->Mobile)) value="{{ $travellingDetails->Mobile }}"@endif  id="travelling_Mobile" type="text"  name="travelling_Mobile" placeholder="Mobile" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Other Contact</label>
                                            <input @if(!empty($travellingDetails->OtherContact)) value="{{ $travellingDetails->OtherContact }}"@endif  id="travelling_OtherContact" type="text"  name="travelling_OtherContact" placeholder="Other Contact"  />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Address</label>
                                            <input @if(!empty($travellingDetails->Address)) value="{{ $travellingDetails->Address }}"@endif  id="travelling_Address" type="text"  name="travelling_Address" placeholder="Address"  />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>City</label>
                                            <input @if(!empty($travellingDetails->City)) value="{{ $travellingDetails->City }}"@endif  id="travelling_City" type="text"  name="travelling_City" placeholder="City"  />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>State</label>
                                            <input @if(!empty($travellingDetails->State)) value="{{ $travellingDetails->State }}"@endif  id="travelling_State" type="text"  name="travelling_State" placeholder="State" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="checkout-form-list">
                                            <label>Postal/Zip Code</label>
                                            <input @if(!empty($travellingDetails->ZipCode)) value="{{ $travellingDetails->ZipCode }}"@endif  id="travelling_ZipCode" type="text"  name="travelling_ZipCode" placeholder="ZipCode" />
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="order-button-payment">
                                            <button type="submit" class="button">Checkout</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-lg-5 col-md-5">
                            <div class="your-order">
                                <h3>Your Tour Package</h3>
                                <div class="your-order-table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th class="product-name">Tour Package</th>
                                                <th class="product-total">Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="cart_item">
                                                <td class="product-name">
                                                    Nzulezu
                                                </td>
                                                <td class="product-total">
                                                    <span class="amount">£165.00</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr class="cart-subtotal">
                                                <th>Cart Subtotal</th>
                                                <td><span class="amount">£165.00</span></td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>Package Total</th>
                                                <td><strong><span class="amount">£165.00</span></strong>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div> --}}
                    </form>
                </div>
            </div>
            <hr>
        </div>
        <!-- checkout-area end -->
  </section>

   @endsection
