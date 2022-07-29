<?php
use App\Tourpackages;
$cartCount = Tourpackages::cartCount();
?>
<header class="header">
    <div class="container">
        <div class="site-header clearfix">
            <div class="col-lg-2 col-md-2 col-sm-12 title-area">
                <div class="site-title" id="title">
                    <a href="{{ url('/') }}" title="">
                    <h4>GHANA<span>TREK</span></h4>
                    </a>
                </div>
            </div>
            <!-- title area -->
            <div class="col-lg-10 col-md-12 col-sm-12">
                <div id="nav" class="right">
                    <div class="container clearfix">
                        <ul id="jetmenu" class="jetmenu blue">
                            <li class="active"><a href="{{ url('/') }}">{{ __('Home') }}</a></li>
                            <li><a href="{{ url('wishlist') }}"><i class="fa fa-star"></i> {{ __('Wishlist') }}</a></li>
                            <li><a href="{{ url('cart') }}"><i class="fa fa-shopping-cart"></i> {{ __('Cart') }}({{ $cartCount }})</a></li>
                            <li><a href="{{ url('Bookings') }}"><i class="fa fa-shopping-cart"></i> {{ __('Recent Activities') }}</a></li>
                            <li style="padding-top:10px; ">
                                <form class="form-inline ml-auto" action="{{ url('/search-tour') }}" method="post">
                                    @csrf
                                    <input class="form-control " placeholder="Search Tour" name="tour" />
                                        <button class="btn btn-outline-success bg-success button" style="border=0px;" type="submit"><i class="fa fa-search"></i></button>
                                </form>
                            </li>
                            <li><a href="{{ url('register') }}"><i class="fa fa-user-plus"></i> {{ __('Sign Up') }}</a></li>
                            @if(empty(Auth::check()))
                                        <li><a href="{{ url('login') }}"><i class="fa fa-sign-in"></i> {{ __('Sign In') }}</a></li>
                                @else
                                <li class="nav-item dropdown" style="float:right;">
                                    <a id="navbarDropdown" class="dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                        {{ Auth::user()->SurName }} <span class="caret"></span>
                                    </a>
                                    <div class=" user-side dropdown-menu " aria-labelledby="navbarDropdown">
                                        <div>
                                            <a href="{{ url('account') }}"><i class="fa fa-user"></i> {{ __('Account') }}</a>
                                        </div>
                                        <a class="dropdown-item" href="{{ url('logout') }}"><i class="fa fa-sign-out"></i>
                                            {{ __('Logout') }}
                                        </a>
                                    </div>
                                </li>
                            @endif

                        </ul>
                    </div>
                </div>
            </div>
            <!-- title area -->
        </div>
      <!-- site header -->
    </div>
    <!-- end container -->
</header>
  <!-- end header -->
