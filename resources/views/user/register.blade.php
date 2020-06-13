@extends('layouts.frontLayout.userdesign')
    @section('content')

        <section class="post-wrapper-top">
            <div class="container">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <ul class="breadcrumb">
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li>Register</li>
                    </ul>
                    <h2>REGISTER</h2>
                </div>
            </div>
        </section>
        <!-- end post-wrapper-top -->

        <section class="section1">
            <div class="container clearfix">
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
                <div class="content col-lg-12 col-md-12 col-sm-12 clearfix">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h4 class="title"><span>Why Join Us?</span></h4>
                        <p>With all of our packages and features updated by our experts, we seek to provide quality and secured services for our clients.We pride ourselves on producing content that stands out from the crowd.</p>
                        <p>To provide of objective, accurate, informative and reliable travel content in various formats, to enable our clients have the best of travel experience.</p>

                        <p class="withpadding">Already having an account? <a href="{{ url('/login') }}">Click Here</a> to login now.</p>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <h4 class="title"><span>Register Form</span></h4>
                        <form id="" name="registerform" method="post" action="{{ url('/register') }}">
                            @csrf
                            <p class="h4 text-center">Sign up</p>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>SurName</label>
                                    <input id="SurName" type="text"  name="SurName" placeholder="SurName" />
                                    @if($errors->has('SurName'))
                                        <span style="color: red">{{ $errors->first('SurName') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Other names</label>
                                    <input id="OtherNames" type="text"  name="OtherNames" placeholder="OtherNames" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Email</label>
                                    <input id="UserEmail" type="text"  name="UserEmail" placeholder="UserEmail"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Mobile</label>
                                    <input id="Mobile" type="text"  name="Mobile" placeholder="Mobile" />
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Password</label>
                                    <input id="myPassword" type="password"  name="Password" placeholder="password"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Confirm Password</label>
                                    <input id="password-confirm" type="password"  name="Password_confirmation"  placeholder="password confirmation" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <input type="submit" class="button" value="register">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- end register -->
                </div>
                    <!-- end content -->
            </div>
            <!-- end container -->
        </section>
        <!-- end section -->
@endsection




