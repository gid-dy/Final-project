@extends('layouts.frontLayout.userdesign')
    @section('content')


    <section class="contact pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 mx-auto text-center">
                    <div class="section-title mb-100">
                        <p>get in touch</p>
                        <h4>contact Us</h4>
                        @if (Session::has('flash_message_success'))
                            <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss='alert'></button>
                                <strong>{!! session('flash_message_success') !!}</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="list-style-type:none;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-md-8">
                <form action="{{ url('/page/contact') }}" method="post" class="contact-form">
                    @csrf
                        <div class="col-md-6">
                            <input id="SurName" type="text"  name="SurName" placeholder="SurName" />
                        </div>
                        <div class="col-md-6">
                            <input id="OtherNames" type="text"  name="OtherNames" placeholder="OtherNames" />
                        </div>
                        <div class="col-md-12">
                            <input id="UserEmail" type="text"  name="UserEmail" placeholder="UserEmail" />
                        </div>
                        <div class="col-md-12">
                            <input id="Subject" type="text"  name="Subject" placeholder="Subject" />
                        </div>
                        <div class="col-md-12">
                            <textarea placeholder="message" name="message" cols="30" rows="10"></textarea>
                        </div>
                        <div>
                            <button type="submit" class="button">send message</button>
                        </div>
                </form>
            </div>
            <div class="col-md-4">
                <div class="single-contact">
                    <i class="fa fa-map-marker"></i>
                    <h5>Address</h5>
                    <p>Kotei near KNUST, AK 566-0554 Kumasi, Ghana</p>
                </div>
                <div class="single-contact">
                    <i class="fa fa-phone"></i>
                    <h5>Phone</h5>
                    <p>(+233) 542 500 599</p>
                    <p>(+233) 501 591 654</p>
                </div>
                <div class="single-contact">
                    <i class="fa fa-envelope"></i>
                    <h5>Email</h5>
                    <p>einsteingideon@gmail.com</p>
                </div>
            </div>

        </div>
    </section>

   @endsection





