@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Tour Packages</a> <a href="#" class="current">Edit Tour Package</a> </div>
    <h1>Tour Packages</h1>
     @if (Session::has('flash_message_error'))
            <div class="alert alert-error alert-block">
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
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Tour Package</h5>
          </div>

          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/edit-tour/'.$tourpackagesDetails->id) }}" name="edit_tour" id="edit_tour" novalidate="novalidate">
                @csrf
                <div class="control-group">
                    <label class="control-label">Under Category</label>
                    <div class="controls">
                        <select name="Category_id" id="Category_id" style="width: 220px;">
                            <?php echo $tourpackagecategory_dropdown; ?>
                        </select>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Package Name</label>
                    <div class="controls">
                        <input type="text" name="PackageName" id="PackageName" value="{{ $tourpackagesDetails->PackageName}}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Package Code</label>
                    <div class="controls">
                        <input type="text" name="PackageCode" id="PackageCode" value="{{ $tourpackagesDetails->PackageCode}}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                        <textarea name="Description" id="Description">{{ $tourpackagesDetails->Description}}</textarea>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Package Price</label>
                    <div class="controls">
                        <input type="text" name="PackagePrice" id="PackagePrice" value="{{ $tourpackagesDetails->PackagePrice}}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Image</label>
                    <div class="controls">
                        <input type="hidden" name="current_image" value="{{ $tourpackagesDetails->Imageaddress}}">
                        <input type="file" name="Imageaddress" id="Imageaddress">
                        @if(!empty($tourpackagesDetails->Imageaddress))
                            <img style= "width: 70px;"  src="{{ asset('/images/backend_images/tours/large/'.$tourpackagesDetails->Imageaddress) }}"> | <a href="{{ url('/admin/delete-tour-image/'.$tourpackagesDetails->PackageId) }}">Delete</a>
                        @endif
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Feature Item</label>
                    <div class="controls">
                        <input type="checkbox" name="featured_tour" id="featured_tour" @if($tourpackagesDetails->featured_tour=="1") checked @endif value="1">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Enable</label>
                    <div class="controls">
                        <input type="checkbox" name="Status" id="Status" @if($tourpackagesDetails->Status=="1") checked @endif value="1">
                    </div>
                </div>


              <div class="form-actions">
                <input type="submit" value="Edit Tour Package" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
