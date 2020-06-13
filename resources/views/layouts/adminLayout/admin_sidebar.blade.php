<?php $url = url()->current(); ?>
{{-- sidebar-menu --}}
<div id="sidebar"><a href="#" class="visible-phone"><i class="icon icon-home"></i> Dashboard</a>
  <ul>
    <li <?php if (preg_match("/dashboard/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('admin/dashboard') }}"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
    @if(Session::get('adminDetails')['Categories_access']==1)
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Categories</span> <span class="label label-important">2</span></a>
            <ul <?php if (preg_match("/categor/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if (preg_match("/add-category/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-category') }}">Add Category</a></li>
                <li <?php if (preg_match("/view-categories/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-categories') }}">View Categories</a></li>
            </ul>
        </li>
    @endif
    @if(Session::get('adminDetails')['Tourpackages_access']==1)
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Tour Package</span> <span class="label label-important">2</span></a>
            <ul <?php if (preg_match("/tourpackage/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if (preg_match("/add-tour/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-tour') }}">Add Tour Package</a></li>
                <li <?php if (preg_match("/view_tourpackages/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view_tourpackages') }}">View Tour Package</a></li>
            </ul>
        </li>
    @endif
    @if(Session::get('adminDetails')['Type']=="Admin")
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Coupon</span> <span class="label label-important">2</span></a>
            <ul <?php if (preg_match("/coupon/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if (preg_match("/add-coupon/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-coupon') }}">Add Coupon</a></li>
                <li <?php if (preg_match("/view-coupons/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-coupons') }}">View Coupon</a></li>
            </ul>
        </li>
    @endif
    @if(Session::get('adminDetails')['Type']=="Admin")
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Banner</span> <span class="label label-important">2</span></a>
            <ul <?php if (preg_match("/banner/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if (preg_match("/add-banner/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-banner') }}">Add Banner</a></li>
                <li <?php if (preg_match("/view-banners/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-banners') }}">View Banner</a></li>
            </ul>
        </li>
    @endif
    @if(Session::get('adminDetails')['Bookings_access']==1)
        <?php $base_booking_url = trim(basename($url)); ?>
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Bookings</span> <span class="label label-important">1</span></a>
            <ul <?php if (preg_match("/booking/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if ($base_booking_url == "view-bookings"){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-bookings') }}">View Bookings</a></li>
                <li <?php if ($base_booking_url == "view-bookings-chart"){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-bookings-chart') }}">View Booking Chart</a></li>
            </ul>
        </li>
    @endif
    @if(Session::get('adminDetails')['Users_access']==1)
        <?php $base_user_url = trim(basename($url)); ?>
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Users</span> <span class="label label-important">1</span></a>
            <ul <?php if (preg_match("/users/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if ($base_user_url == "view-users"){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-users') }}">View Users</a></li>
                <li <?php if ($base_user_url == "view-users-chart"){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-users-chart') }}">View Users Chart</a></li>
            </ul>
        </li>
    @endif
    @if(Session::get('adminDetails')['Type']=="Admin")
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Admin/Sub-Admins</span> <span class="label label-important">2</span></a>
            <ul <?php if (preg_match("/admins/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if (preg_match("/add-admin/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-admin') }}">Add Admin/Sub-Admin</a></li>
                <li <?php if (preg_match("/view-admins/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-admins') }}">View Admins/Sub-Admins</a></li>
            </ul>
        </li>
    @endif
    @if(Session::get('adminDetails')['Type']=="Admin")
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Feedbacks</span> <span class="label label-important">1</span></a>
            <ul <?php if (preg_match("/feedback/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if (preg_match("/view-feedbacks/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-feedbacks') }}">View Feedbacks</a></li>
            </ul>
        </li>
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>CMS Pages</span> <span class="label label-important">2</span></a>
            <ul <?php if (preg_match("/cms-page/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if (preg_match("/add-cms-page/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-cms-page') }}">Add CMS Page</a></li>
                <li <?php if (preg_match("/view-cms-pages/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-cms-pages') }}">View CMS Pages</a></li>
            </ul>
        </li>
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Enquiries</span> <span class="label label-important">1</span></a>
            <ul <?php if (preg_match("/enquiries/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if (preg_match("/get-contact/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/get-contact') }}">View Enquiries</a></li>
            </ul>
        </li>
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Currencies</span> <span class="label label-important">2</span></a>
            <ul <?php if (preg_match("/currencies/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if (preg_match("/add-currency/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/add-currency') }}">Add Currency</a></li>
                <li <?php if (preg_match("/view-currencies/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-currencies') }}">View Currencies</a></li>
            </ul>
        </li>
        <li class="submenu"> <a href="#"><i class="icon icon-th-list"></i> <span>Newsletter Subscribers</span> <span class="label label-important">1</span></a>
            <ul <?php if (preg_match("/newsletter/i", $url)){ ?> style="display:block;" <?php } ?>>
                <li <?php if (preg_match("/view-newsletter-subscribers/i", $url)){ ?> class="active" <?php } ?>><a href="{{ url('/admin/view-newsletter-subscribers') }}">View Newsletter</a></li>
            </ul>
        </li>
    @endif

  </ul>
</div>
{{-- sidebar-menu --}}
