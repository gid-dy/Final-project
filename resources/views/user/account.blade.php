@extends('layouts.frontLayout.userdesign')
    @section('content')


        <section class="post-wrapper-top">
          <div class="container">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <ul class="breadcrumb withpadding1">
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>Account</li>
              </ul>
              <h2>Update Account</h2>
            </div>

          </div>
        </section>
        <!-- end post-wrapper-top -->

        <section class="section1">
                <div class="container clearfix">
                    <ul class="withpadding1" style="list-style-type:none; display:inline-flex; float-left;">
                      <li class="active" style="margin-right:30px; color:red"><a href="{{ url('account') }}"><i class="fa fa-user"></i> Setting</a></li>
                      <li style="margin-right:30px;"><a href="{{ url('wishlist') }}"><i class="fa fa-star"></i> Wishlist</a></li>
                      <li style="margin-right:30px;"><a href="{{ url('Bookings') }}"><i class="fa fa-shopping-cart"></i> {{ __('Recent Activities') }}</a></li>
                    </ul>

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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li style="list-style-type:none;">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="contact-container">
                        <div class="btn-pref btn-group btn-group-justified btn-group-lg" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <button type="button" id="stars" style="padding:40px; border-radius: 50%;" href="#tab1" data-toggle="tab"><span class="fa fa-user" aria-hidden="true"></span>
                                    <div class="hidden-xs">Profile</div>
                                </button>
                            </div>
                            <div class="btn-group" role="group">
                                <button type="button" id="favorites" style="padding:40px; border-radius: 50%;" href="#tab2" data-toggle="tab"><span class="fa fa-lock" aria-hidden="true"></span>
                                    <div class="hidden-xs">Password</div>
                                </button>
                            </div>
                        </div>

                        <div class="well">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab1">
                                    <h2>Profile Details</h2>
                                    <hr>
                                    <div class="row">
                                        <form id="" name="accountform" method="post" action="{{ url('/account') }}">
                                            @csrf
                                            <div class="col-md-12">
                                                <div class="checkout-form-list">
                                                    <label>SurName</label>
                                                    <input value="{{ $userDetails->SurName }}" id="SurName" type="text"  name="SurName" placeholder="SurName" required />
                                                    @if($errors->has('SurName'))
                                                        <span style="color: red">{{ $errors->first('SurName') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkout-form-list">
                                                    <label>Other names</label>
                                                    <input value="{{ $userDetails->OtherNames }}" id="OtherNames" type="text"  name="OtherNames" placeholder="OtherNames" required />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkout-form-list">
                                                    <label>Email</label>
                                                    <input value="{{ $userDetails->UserEmail }}" id="UserEmail" type="email"  name="UserEmail" placeholder="UserEmail" required/>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="country-select">
                                                    <label>Country</label>
                                                    <select  id="Country" name="Country" >
                                                        <option value="">Select Country</option>
                                                        @foreach($countries as $country)
                                                        <option value="{{ $country->Country }}" @if($country->Country == $userDetails->Country)selected @endif>{{ $country->Country }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>Mobile</label>
                                                    <input value="{{ $userDetails->Mobile }}" id="Mobile" type="text"  name="Mobile" placeholder="Mobile" required />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>Other Contact</label>
                                                    <input value="{{ $userDetails->OtherContact }}" id="OtherContact" type="text"  name="OtherContact" placeholder="Other Contact"  />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>Address</label>
                                                    <input value="{{ $userDetails->Address }}" id="Address" type="text"  name="Address" placeholder="Address"  />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>City</label>
                                                    <input value="{{ $userDetails->City }}" id="City" type="text"  name="City" placeholder="City"  />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>State</label>
                                                    <input value="{{ $userDetails->State}}" id="State" type="text"  name="State" placeholder="State" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="checkout-form-list">
                                                    <label>Postal/Zip Code</label>
                                                    <input value="{{ $userDetails->ZipCode}}" id="ZipCode" type="text"  name="ZipCode" placeholder="Zip Code" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkout-form-list">
                                                    <input type="submit" class="button" value="Update Account">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="tab-pane fade in" id="tab2">
                                    <h2>Change Password</h2>
                                    <hr>
                                    <div class="row">
                                        <form id="passwordform" name="passwordform" method="POST" action="{{ url('/update-user-pwd') }}">
                                            @csrf
                                            <div class="col-md-12">
                                                <label>Current Password</label>
                                                <span id="chkPwd"></span>
                                                <div class="form-group">
                                                    <input type="password" class="form-control"  name="current_pwd" id="current_pwd" placeholder="Current Password">
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <label>New Password</label>
                                                <div class="form-group">
                                                    <input type="password" class="form-control"  name="new_pwd"  id="new_pwd" placeholder="New Password">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <label>Confirm Password</label>
                                                <div class="form-group">
                                                    <input type="password" class="form-control"   name="confirm_pwd"  id="confirm_pwd" placeholder="Confirm Password">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="checkout-form-list">
                                                    <input type="submit" class="button" value="change Password">
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                </div>

        </section>
  {{-- <section id="subs" class="subscribe">

    <div class="subscribe-title text-center">
      <h2>
        Join our Subscribers List to Get Regular Update
      </h2>
      <p>
        Subscribe Now. We will send you Best offer for your Trip
      </p>
    </div>
    <form>
      <div class="row">
        <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
          <div class="custom-input-group">
            <input type="email" class="form-control" placeholder="Enter your Email Here">
            <button class="appsLand-btn subscribe-btn">Subscribe</button>
            <div class="clearfix"></div>
            <i class="fa fa-envelope"></i>
          </div>

        </div>
      </div>
    </form>
</section> --}}




@endsection




