@extends('layouts.frontLayout.userdesign')
    @section('content')
<?php use App\Tourpackages; ?>

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
            <div class="row" style="margin-top: 30px;">

                <div class="col-md-12">
                <table class="table table-hover your-order">
                        <thead style="background-color:yellow;">
                            <tr>
                                <th>Tour</th>
                                <th></th>
                                <th>Tour Type</th>
                                <th>Price</th>
                                <th>No of Travellers</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                      <?php $total_amount = 0; ?>
                      @foreach($userwishlist as $wishlist)
                        <div class="row">
                            <tr>
                                <td style="width:100px;"><img class="img-responsive" src="{{ asset('images/backend_images/tours/large/'.$wishlist->Imageaddress) }}"></td>
                                <td><h4><small>{{ $wishlist->PackageName }}</small></h4>
                                    <h4><small>Tour Code: {{ $wishlist->PackageCode }}</small></h4>
                                    <p>  {{ $wishlist->TransportName }}</p>
                                </td>
                                <td><h4><small>{{ $wishlist->TourTypeName }}</small></h4></td>
                                <td>
                                    <?php $PackagePrice = Tourpackages::getPackagePrice($wishlist->Package_id, $wishlist->TourTypeName); ?>
                                    <p>GHS {{ $PackagePrice }}</p>
                                </td>
                                <td><h4><small>{{ $wishlist->Travellers }}</small></h4></td>
                                <td><p class="">GHS {{ $PackagePrice*$wishlist->Travellers }}.00</td>
                                    <form name="addtocartform" id="addtocartform" action="{{ url('add-cart') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="Package_id" value="{{ $wishlist->Package_id }}">
                                        <input type="hidden" name="PackageName" value="{{ $wishlist->PackageName }}">
                                        <input type="hidden" name="PackagePrice"  value="{{ $wishlist->PackagePrice }}">
                                        <input type="hidden" name="PackageCode"  value="{{ $wishlist->PackageCode }}">
                                        <input type="hidden" name="Travellers"  value="{{ $wishlist->Travellers }}">
                                        <input type="hidden" name="TourTypeName"  value="{{ $wishlist->id }}-{{ $wishlist->TourTypeName }}">
                                        <input type="hidden" name="TransportName"  value="{{ $wishlist->id }}-{{ $wishlist->TransportName }}">


                                        <td class="product-removal">
                                            <button class="button" id="cartbutton" type="submit" name="cartbutton" value="Add-to-cart">add to cart</button>
                                            <a class ="cart_quantity_delete button" href="{{ url('/wishlist/delete-tourpackage/'.$wishlist->id) }}"><i class="fa fa-trash"></i> </a>
                                        </td>
                                    </form>
                            </tr>


                        </div>
                        <hr>
                      <?php $total_amount = $total_amount + ($PackagePrice*$wishlist->Travellers);.00?>
                      @endforeach
                      </tbody>
                      </table>


                </div>




            </div>
        </div>
    </section>
@endsection

