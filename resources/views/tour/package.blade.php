
@extends('layouts.frontLayout.userdesign')
    @section('content')
    <?php
use App\Tourpackages;
?>



  <!--cat badges-->
    <section class="cat_badge">
        <div class="container">
            <div class="row label-bagdes">
                <div class="col-md-12">
                    <div align="center">
                        <li class="btn btn-default filter-button dest2" data-filter="hdpe">
                            @if(!empty($search_tour))
                                {{ $search_tour }}
                            @else
                                {{ $categoryDetails->CategoryName }}
                            @endif
                            ({{ count($tourpackagesAll)  }})
                        </li>
                    </div>
                </div>
            </div>
        </div><!--/.container-->
    </section>
    <section id="pack" class="packages">
        <div class="container">
                <div class="content pull-right col-lg-9 col-md-9 col-sm-9 col-xs-12 clearfix dest1">
                    <div class="row">
                        @foreach($tourpackagesAll as $tourpackages)
                            @if($tourpackages->Status=="1")
                                <div class="col-lg-4 col-md-4 col-xs-12">
                                    <a href="{{ url('tours/'.$tourpackages->id) }}" class="block-5">
                                        <img src="{{ asset('images/backend_images/tours/large/'.$tourpackages->Imageaddress) }}" alt="tour image" />
                                        <div class="text">
                                            <h4 class="heading">{{ $tourpackages->PackageName}}<span class="price pull-right"> GHS {{ $tourpackages->PackagePrice}}</span></h4>
                                            <div class="post-meta">
                                                <p class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                                                    <span class="price">
                                                        <i class="fa fa-angle-right"></i> {{ $tourpackages->AccommodationName}}
                                                    </span>
                                                    <span class="price">
                                                        {{-- <i class="fa fa-angle-right"></i>  {{ $tourpackages->Description}} --}}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="about-btn">
                                                <button  class="about-view packages-btn price pull-right">
                                                    book now
                                                </button>
                                            </div>
                                        </div>
                                    </a>
                                </div><!--/.col-->
                            @endif
                        @endforeach
                        @if(empty($search_tour))
                            <div align="center">{{ $tourpackagesAll->links() }}</div>
                        @endif
                    </div>
                    {{-- <div align="center">{{ $tourpackagesAll->links() }}</div> --}}
                </div>

                <!-- SIDEBAR -->
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 panel-group dest1" id="sidebar">
                    @include('layouts.frontLayout.user_sidebar')
                </div>
                <!-- end sidebar -->


        </div>
    </section><!--/.packages-->

@endsection



