<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@if(!empty($meta_title)) {{ $meta_title }} @else Home | Ghana-Trek @endif </title>
    @if(!empty($meta_description))
        <meta name="description" content="{{ $meta_description }}">
    @endif

    @if(!empty($meta_keywords))
        <meta name="keywords" content="{{ $meta_keywords }}">
    @endif
  <!-- Favicons -->

  <link rel="shortcut icon" href="{{ asset('images/frontend_images/icon.png') }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('images/frontend_images/icon.png') }}" type="image/x-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Ruda:400,900,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="{{ asset('lib/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="{{ asset('lib/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
  <link href="{{ asset('lib/prettyphoto/css/prettyphoto.css') }}" rel="stylesheet">
  <link href="{{ asset('lib/hover/hoverex-all.css') }}" rel="stylesheet">
  <link href="{{ asset('lib/jetmenu/jetmenu.css') }}" rel="stylesheet">
  <link href="{{ asset('lib/owl-carousel/owl-carousel.css') }}" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link rel="stylesheet" href="{{ asset('css/frontend_css/style.css') }}" >
  <link rel="stylesheet" href="{{ asset('css/frontend_css/easyzoom.css') }}" >
  <link rel="stylesheet" href="{{ asset('css/frontend_css/colors/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('css/frontend_css/colors/blue.css') }}">
  <link rel="stylesheet" href="{{ asset('css/frontend_css/shop.css') }}">
  <link rel="stylesheet" href="{{ asset('css/frontend_css/passtrength.css') }}">
  {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css"> --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.2.0/flexslider-min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css">
  <script type='text/javascript' src='https://platform-api.sharethis.com/js/sharethis.js#property=5e8d2b907daa0a0012e7bee3&product=inline-share-buttons&cms=website' async='async'></script>

</head>
</body>

    @include('layouts.frontLayout.user_topbar')
    @include('layouts.frontLayout.user_header')
    @yield('content')
    @include('layouts.frontLayout.user_subscription')
    @include('layouts.frontLayout.user_footer')
{{--  <!-- JavaScript Libraries -->  --}}

    <script src="{{ asset('lib/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.min.js') }}"></script>
    {{-- <script src="{{ asset('lib/php-mail-form/validate.js') }}"></script> --}}
    <script src="{{ asset('lib/prettyphoto/js/prettyphoto.js') }}"></script>
    <script src="{{ asset('lib/isotope/isotope.min.js') }}"></script>
    <script src="{{ asset('lib/hover/hoverdir.js') }}"></script>
    <script src="{{ asset('lib/hover/hoverex.min.js') }}"></script>
    <script src="{{ asset('lib/unveil-effects/unveil-effects.js') }}"></script>
    <script src="{{ asset('lib/owl-carousel/owl-carousel.js') }}"></script>
    <script src="{{ asset('lib/jetmenu/jetmenu.js') }}"></script>
    <script src="{{ asset('lib/animate-enhanced/animate-enhanced.min.js') }}"></script>
    <script src="{{ asset('lib/jigowatt/jigowatt.js') }}"></script>
    <script src="{{ asset('lib/easypiechart/easypiechart.min.js') }}"></script>



    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flexslider/2.2.0/jquery.flexslider-min.js"></script>


    {{--  <!-- Template Main Javascript File -->  --}}
    <script src="{{ asset('js/frontend_js/main.js') }}"></script>
    <script src="{{ asset('js/frontend_js/jquery.validate.js') }}"></script>
    <script src="{{ asset('js/frontend_js/easyzoom.js') }}"></script>
    <script src="{{ asset('js/frontend_js/passtrength.js') }}"></script>
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}



    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
    <script>
        $('.flexslider').flexslider({
       animation: "slide",
       controlNav: false
   })
   </script>



</body>
</html>
