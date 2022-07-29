<?php use App\Tourpackages; ?>
@extends('layouts.frontLayout.userdesign')
    @section('content')



    <div class="flexslider">
        <ul class="slides">
            @foreach($banners as $key => $banner)
            <li class=" @if($key==0) active @endif">
                <img src="images/frontend_images/banners/{{ $banner->Image }}">
                <div class="meta">
                    <h4>{{ $banner->Title }}</h4>
                    <h4>Lorem ipsum dolor sit.</h4>
                </div>
            </li>
            @endforeach

        </ul>
    </div>

    {{-- <div class="video_banner">
	    <div class="overlay"></div>
        <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
            <source src="{{ asset('images/frontend_images/tour.mp4') }}" type="video/mp4">
        </video>
        <div class="container h-100">
            <div class="d-flex text-center h-100">
                <div class="my-auto w-100 text-white">
                    <h1 class="display-3">Great Offers</h1>
                    <h2>Experience the best from us</h2>
                </div>
            </div>
        </div>
	</div> --}}


    <section class="section1">
        <div class="container clearfix">
            <div class="gallery-box">
                <div class="gallery-content">
                    <div class="filtr-container">
                        <div class="content pull-right col-lg-8 col-md-8 col-sm-8 col-xs-12 clearfix dest">
                            <h2 class="text-center">Top destination</h2>
                            <h4 class="text-center"> Where do you wanna go? How much you wanna explore? </h4>
                                @foreach($tourpackagesAll as $tourpackages)
                                    @if($tourpackages->Status=="1")
                                    <div class="col-md-6 col-xs-6">
                                        <div class="filtr-item">
                                            <a href="{{ url('/tours/'.$tourpackages->id) }}">
                                                <img src="{{ asset('images/backend_images/tours/large/'.$tourpackages->Imageaddress) }}" alt="tour image" />
                                                <div class="item-title">
                                                    <h4 class="heading">{{ $tourpackages->PackageName}}</h4>
                                                    <p class="price">GHS {{ $tourpackages->PackagePrice}}</p>
                                                </div> <!-- /.item-title-->
                                            </a>
                                        </div><!-- /.filtr-item -->
                                    </div><!-- /.col -->
                                    @endif
                                @endforeach
                            <div align="center">{{ $tourpackagesAll->links() }}</div>
                        </div>

                        <!-- SIDEBAR -->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 panel-group dest" id="sidebar">
                            @include('layouts.frontLayout.user_sidebar')
                        </div>
                        <!-- end sidebar -->
                    </div>
                </div>
            </div>
        </div><!-- end container -->
    </section>


   @endsection







