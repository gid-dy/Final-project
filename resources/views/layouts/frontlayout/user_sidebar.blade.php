<?php use App\Tourpackages; ?>
<form action="{{ url('/tours-filter') }}" method="post">
  @csrf
  @if(!empty($CategoryName))
      <input name="CategoryName" value="{{ $CategoryName }}" type="hidden">
   @endif
  <div class="widget">
      <h4 class="title"><span>Categories</span></h4>
      <ul class="categories">
          @foreach($tourpackagecategory  as $cat)
              <li>
                  <?php $tourpackagesCount = Tourpackages::tourpackagesCount($cat->id); ?>
                  @if($cat->CategoryStatus=="1")
                      <a href="{{ url('/tour/'.$cat->CategoryName) }}" class="">
                          {{-- <img src="{{ asset('images/backend_images/categories/large/'.$cat->Imageaddress) }}" alt="portfolio image" /> --}}
                          <div class="text">
                              <h4 class="mt-0">{{ $cat->CategoryName }}<span class="pull-right"> ({{ $tourpackagesCount }})</span></h4>
                              {{-- <p>{{ $cat->CategoryDescription }}</p> --}}
                          </div>
                      </a>
                      <hr>
                  @endif
              </li>
          @endforeach
      </ul>
  </div>
  @if(!empty($CategoryName))
      <div class="widget">
          <h4 class="title"><span>Tour Type Name</span></h4>
          @foreach($TourTypeNameArray as $TourTypeName)
              @if(!empty($_GET['TourTypeName']))
                  <?php $TourTypeNameArr = explode('-',$_GET['TourTypeName']) ?>
                  @if(in_array($TourTypeName, $TourTypeNameArr))
                      <?php $TourTypeNamecheck = "checked"; ?>
                  @else
                      <?php $TourTypeNamecheck=""; ?>
                  @endif
                  @else
                      <?php $TourTypeNamecheck=""; ?>
              @endif
              <ul class="categories">
                  <li>
                      <div class="text">
                          <h4 class="mt-0"><input name="TourTypeNameFilter[]" onchange="javascript:this.form.submit();" id="{{ $TourTypeName }}" value="{{ $TourTypeName }}" type="checkbox" {{ $TourTypeNamecheck }}>&nbsp;&nbsp;<span>{{ $TourTypeName }}</span></h4>
                      </div>
                      <hr>
                  </li>
              </ul>
          @endforeach
      </div>
  @endif
</form>
