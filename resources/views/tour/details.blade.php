@extends('layouts.frontLayout.userdesign')
    @section('content')
<?php use App\Tourpackages; ?>
<?php use App\Feedback; ?>
    <section>
        <div class="container">
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
            <div class="card">
                <div class="container-fliud">
                    <div class="wrapper row">
                        <div class="col-md-6">
                            <div class="preview-pic tab-content">
                                <img class="mainImage" src="{{ asset('images/backend_images/tours/large/'.$tourpackagesDetails->Imageaddress) }}" />
                                    <div>
                                        @foreach($tourAltImage as $altimage)
                                            <img class="changeImage" src="{{ asset('images/backend_images/tours/large/'.$altimage->Image) }}" style="width:80px; display:inline;float:left;margin-top:20px; padding-right:10px; cursor:pointer;" />
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="details col-md-6">
                                <form name="addtocartform" id="addtocartform" action="{{ url('add-cart') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="Package_id" value="{{ $tourpackagesDetails->id }}">
                                    <input type="hidden" name="PackageName" value="{{ $tourpackagesDetails->PackageName }}">
                                    <input type="hidden" name="PackagePrice" id="PackagePrice" value="{{ $tourpackagesDetails->PackagePrice }}">
                                    <input type="hidden" name="PackageCode" id="PackageCode" value="{{ $tourpackagesDetails->PackageCode }}">

                                    <div class="tour-details">
                                        <h3 class="product-title">{{ $tourpackagesDetails->PackageName}}</h3>
                                        <p>Tour Code: {{ $tourpackagesDetails->PackageCode}}</p>
                                        <p>
                                            <select id="SelType" name="TourTypeName">
                                                <option value="">Select Tour Type</option>
                                                @foreach($tourpackagesDetails->tourtypes as $tourtype)
                                                <option value="{{ $tourpackagesDetails->id }}-{{ $tourtype->TourTypeName }}">{{ $tourtype->TourTypeName }}</option>
                                                @endforeach
                                            </select>
                                        </p>

                                        <span>
                                            <?php $getCurrencyRates =Tourpackages::getCurrencyRates($tourpackagesDetails->PackagePrice); ?>
                                            <span id="getPackagePrice">GHS {{ $tourpackagesDetails->PackagePrice }}<br>
                                                <h4>
                                                    USD {{ $getCurrencyRates['USD_Rate'] }}<br>
                                                    GBP {{ $getCurrencyRates['GBP_Rate'] }}<br>
                                                    EUR {{ $getCurrencyRates['EUR_Rate'] }}<br>
                                                </h4>
                                            </span>
                                            {{-- <p>
                                                <select id="SelTran" name="TransportName">
                                                    <option value="">Select Transportation</option>
                                                    @foreach($tourpackagesDetails->tourtransports as $tourtransportation)
                                                    <option value="{{ $tourpackagesDetails->id }}-{{ $tourtransportation->TransportName }}">{{ $tourtransportation->TransportName }}</option>
                                                    @endforeach
                                                </select>
                                            </p>
                                            <h4 class="price">cost: <span id="getTransportCost" hidden>GHS  0</span></h4> --}}
                                                <p><b>Availability:</b> <span id="Availability"> @if($total_availability>0) Available @else Sold Out @endif </span></p>
                                                <div>
                                                    <p><i class="fa fa-check" aria-hidden="true"></i>Free Cancellation up to 24 hours in advance</p>
                                                    <p><i class="fa fa-check" aria-hidden="true"></i>Low Price Guarantee</p>
                                                    <p><i class="fa fa-check" aria-hidden="true"></i>Reserve Now & Pay Later</p>
                                                </div>
                                        </span>
                                        <span>
                                            <label>Number of Travellers</label>
                                            <input id="nt" type="number"  min="1" max="1"  name="Travellers" value="1" />
                                        </span>
                                        <span id="next-action">
                                            @if($total_availability>0)
                                                <button class="add-to-cart btn" id="cartbutton" type="submit" name="cartbutton " value="Add to cart">add to cart</button>
                                            @endif
                                            <button class="like btn"  id="wishlistbutton" type="submit" name="wishlistbutton" value="Add to wishlist">Add to wishlist <span class="fa fa-heart"></span></button>
                                            <div class="sharethis-inline-share-buttons" style="margin-top:10px;"></div>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="container">
            <div class="row">
                <div class="weather col-sm-12">
                    @foreach($tourpackagesDetails->tourlocations as $tourlocation)
                        <div class="col-sm-8">
                            <?php echo nl2br($tourlocation->Weather); ?>
                        </div>
                        <div class="col-sm-4">
                            <?php echo nl2br($tourlocation->WeatherDetails); ?>
                        </div>
                    @endforeach
                </div>
            </div>




                <div class="col-lg-12 col-sm-12">
                    <div class="row center">
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document" style="width: 1200px;">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">{{ $tourpackagesDetails->PackageName}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </div>
                                    <div class="modal-body col-lg-12 col-sm-12">
                                        @foreach($tourpackagesDetails->tourlocations as $tourlocation)
                                            {{--  <div id="map-canvas"></div>  --}}
                                            <div id="map" style="height: 1000px; "></div>
                                        <script>
                                             var map, infoWindow;
                                            function initMap(){
                                                // Map options
                                                var options = {
                                                zoom:8,
                                                center:{lat:{{ $tourlocation->Latitude }},lng:{{ $tourlocation->Longitude }} }
                                                }

                                                // New map
                                                var map = new
                                                google.maps.Map(document.getElementById('map'), options);

                                                // Add marker
                                                var marker = new google.maps.Marker({
                                                    position:{lat:{{ $tourlocation->Latitude }},lng:{{ $tourlocation->Longitude }} },
                                                    map:map,
                                                });

                                                infoWindow = new google.maps.InfoWindow;

                                                    // Try HTML5 geolocation.
                                                    if (navigator.geolocation) {
                                                        navigator.geolocation.getCurrentPosition(function(position) {
                                                        var pos = {
                                                            lat: position.coords.latitude,
                                                            lng: position.coords.longitude
                                                        };

                                                        infoWindow.setPosition(pos);
                                                        infoWindow.setContent('Location found.');
                                                        infoWindow.open(map);
                                                        map.setCenter(pos);
                                                        }, function() {
                                                        handleLocationError(true, infoWindow, map.getCenter());
                                                        });
                                                        } else {
                                                        // Browser doesn't support Geolocation
                                                        handleLocationError(false, infoWindow, map.getCenter());
                                                        }
                                                    }

                                                    function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                                                    infoWindow.setPosition(pos);
                                                    infoWindow.setContent(browserHasGeolocation ?
                                                                            'Error: The Geolocation service failed.' :
                                                                            'Error: Your browser doesn\'t support geolocation.');
                                                    infoWindow.open(map);


                                                // Listen for click on map
                                                google.maps.event.addListener(map, 'click', function(event){
                                                // Add marker
                                                addMarker({coords:event.latLng});
                                                });
                                                function getLocation() {
                                                    if (navigator.geolocation) {
                                                    navigator.geolocation.getCurrentPosition(showPosition);
                                                    } else {
                                                    alert("Geolocation is not supported by this browser.");
                                                    }
                                                }
                                                function showPosition(position) {
                                                    var lat = position.coords.latitude;
                                                    var lng = position.coords.longitude;
                                                    map.setCenter(new google.maps.LatLng(lat, lng));
                                                }
                                            }


                                        </script>
                                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBpBlWKR3Uy7ZIVYtShVwPAC7ebaE3vZqg&callback=initMap" async="" defer="defer" type="text/javascript">
                                        </script>
                                        @endforeach
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                </div>
            </div>

        </section>


    <section>

        <div class="container" style="margin-top: 40px;">
            <div class="row">
                <!-- Nav tabs -->
                <div class="col-xs-12">
                    <ul class="pro-info-tab-list withpadding1" style="list-style-type: none">
                        <li class="active"><a href="#more-info" data-toggle="tab">Description</a></li>
                        <li><a href="#data-sheet" data-toggle="tab">All You need to know</a></li>
                        <li><a href="#reviews" data-toggle="tab">Reviews</a></li>
                        <li data-toggle="modal" data-target="#exampleModal"><a href="#exampleModal" data-toggle="tab">View map</a></li>
                    </ul>
                </div>
                <!-- Tab panes -->
                <div class="tab-content col-xs-12">

                        <p style="font-weight: 700;"><?php echo nl2br($tourpackagesDetails->Description); ?></p>
                        <hr>
                        <div class="pro-info-tab tab-pane active" id="more-info">
                                <label class="control-label"><h4>EXTRA</h4></label>
                        @foreach($tourpackagesDetails->tourincludes as $tourinclude)
                        <p style="font-weight: 700;">{{ $tourinclude->TourIncludeInfo }}</p>
                        @endforeach
                        <hr>

                            <label class="control-label"><h4>Accomodation</h4></label>
                        @foreach($tourpackagesDetails->accommodations as $accommodation)
                        <p style="font-weight: 700;">{{ $accommodation->AccommodationName }}</p>
                        @endforeach
                        <hr>

                        <label class="control-label"><h4>Important Information</h4></label>
                        <ul style=" font-size:16px;font-weight: 700;line-height:2">
                            <li>Passport or ID card for children</li>
                            <li>Children will need a valid ID in order to prove their age at the time of the activity (applicable for 4 to 17-year-olds)</li>
                            <li>Passport or ID card for children</li>
                            <li>Passport or ID card for children</li>
                        </ul>
                    </div>
                    <div class="pro-info-tab tab-pane" id="data-sheet">
                        <label class="control-label"><strong>Include</strong></label>
                            @foreach($tourpackagesDetails->tourincludes as $tourinclude)
                                <p style=""><i class="fa fa-check-circle"></i> {{ $tourinclude->IncludeName }}</p>
                            @endforeach
                            <label class="control-label"><strong>Exclude</strong></label>
                             @foreach($tourpackagesDetails->tourincludes as $tourinclude)
                                <p style=""><i class="fa fa-times-circle"></i> {{ $tourinclude->TourExcludeName }}</p>
                            @endforeach
                    </div>
                    <div class="pro-info-tab tab-pane" id="reviews">
                        <div class="page-header">
                            <h3 class="reviews">Leave your comment</h3>
                        </div>
                        <div class=" col-md-12">
                            <div class="review-block">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li style="list-style-type:none;">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                                @foreach ($feedbacks as $feedback)
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <h2 class="circle-name">{{ $feedback->SurName }} {{ $feedback->OtherNames }}</h2><br>
                                            <div class="review-block-date">{{date('H:i', strtotime($feedback->created_at)) }} <span style="margin:10px; color:orange">{{date('F j, Y', strtotime($feedback->created_at)) }}</span></div>
                                        </div>
                                        <div class="col-sm-9">
                                            <div class="review-block-description">{{ $feedback->Message }}</div>
                                        </div>
                                    </div>
                                    <hr/><br>
                                @endforeach

                            </div>
                        </div>
                        <div class="col-md-12 col-xl-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <form class="form-horizontal" method="post" action="{{ url('/feedback') }}">
                                        @csrf
                                        <input type="hidden" name="$tourpackagesDetails->Package_id"  value="{{ $tourpackagesDetails->id }}" />
                                        <div class="col-md-6">
                                            <label for="name" class="cols-sm-2 control-label">SurName</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                <input type="text" class="form-control" name="SurName" id="SurName" placeholder="Enter your SurName" />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name" class="cols-sm-2 control-label">Other Names</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-user fa" aria-hidden="true"></i></span>
                                                <input type="text" class="form-control" name="OtherNames" id="OtherNames" placeholder="Enter your Other names" />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="name" class="cols-sm-2 control-label">Email</label>
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-envelope fa" aria-hidden="true"></i></span>
                                                <input type="text" class="form-control" name="UserEmail" id="UserEmail" placeholder="Enter your Email" />
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="name" class="cols-sm-2 control-label">Message</label>
                                            <textarea placeholder="message" name="Message" cols="30" rows="10"></textarea>

                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" class="button main-btn pull-right">Submit</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Relate Product -->
    <section>
        <div class="container">
            <div class="row col-md-12">
                <div class="row">
                    <div class="col-md-9">
                        <h3>
                            Related Tour</h3>
                    </div>
                    <div class="col-md-3">
                        <!-- Controls -->
                        <div class="controls pull-right">
                            <a class="left fa fa-chevron-left btn btn-primary" href="#carousel-example-generic" data-slide="prev"></a>
                            <a class="right fa fa-chevron-right btn btn-primary" href="#carousel-example-generic" data-slide="next"></a>
                        </div>
                    </div>
                </div>
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <?php $count=1; ?>
                        @foreach($relatedTour->chunk(3) as $chunk)
                            <div <?php if($count==1){ ?> class="item active" <?php } else { ?> class="item" <?php } ?>>
                                @foreach($chunk as $tour)
                                    <div class="col-sm-4">
                                        <div class="col-item">
                                            <div class="photo box19">
                                                <img src="{{ asset('images/backend_images/tours/large/'.$tour->Imageaddress) }}"  alt="a" />
                                                <div class="box-content">
                                                    <ul class="title">
                                                        <li><i class="fa fa-list"></i><a href="{{ url('tours/'.$tour->id) }}" class="hidden-sm">More details</a> </li>
                                                    </ul>

                                                    <ul class="title">
                                                        <li><i class="fa fa-shopping-cart"></i><a href="{{ url('cart') }}" class="hidden-sm">Add to cart</a></li>
                                                    </ul>

                                                </div>
                                            </div>
                                            <div class="info">
                                                <div class="separator clear-left">
                                                    <p class="btn-add">
                                                        {{ $tour->PackageName }}</p>
                                                    <p class="btn-details">
                                                        GHS {{ $tour->PackagePrice }}</p>
                                                </div>

                                                <div class="clearfix">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach
                            </div>
                            <?php $count++; ?>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
