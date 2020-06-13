<?php
use App\Tourpackages;
?>
@extends('layouts.frontLayout.userdesign')
    @section('content')
    <section>
        <div class="container">
            <div class="col-md-12">
                <h3 style="text-align: center">{{ $cmsPagesDetails->Title }}</h3>
                <p><?php echo nl2br($cmsPagesDetails->Description); ?></p>
            </div>
        </div>
    </section>
    <script>
        $('.collapse').collapse()
    </script>

   @endsection






