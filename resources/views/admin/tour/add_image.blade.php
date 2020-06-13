@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Tour Packages</a> <a href="#" class="current">Add Image</a> </div>
    <h1>Images</h1>
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
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Add Tour Image</h5>
          </div>

          <div class="widget-content nopadding">
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{ url('/admin/add-image/'.$tourpackagesDetails->id) }}" name="add_image" id="add_image">
                @csrf
                <input type="hidden" name="Package_id" value="{{ $tourpackagesDetails->id }}" />
                <div class="control-group">
                    <label class="control-label">Package Name</label>
                    <label class="control-label"><strong>{{ $tourpackagesDetails->PackageName }}</strong></label>
                </div>
                <div class="control-group">
                    <label class="control-label">Package Code</label>
                    <label class="control-label"><strong>{{ $tourpackagesDetails->PackageCode }}</strong></label>
                </div>
                <div class="control-group">
                    <label class="control-label">Image</label>
                    <div class="controls">
                        <input type="file" name="Image[]" id="Image" multiple="multiple">
                    </div>
                </div>


              <div class="form-actions">
                <input type="submit" value="Add Alt Image" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Tourtype</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                    <th>Image Id</th>
                    <th>TourPackage Id</th>
                    <th>Image</th>
                    <th>Actions</th>
                    </tr>

                </thead>
                <tbody>
                        @foreach ($packageimages as $packageimage)
                        <tr class="gradeX">
                            <td>{{ $packageimage->id }}</td>
                            <td>{{ $packageimage->Package_id }}</td>
                            <td>
                                @if(!empty($packageimage->Image))
                                    <img src="{{ asset ('/images/backend_images/tours/small/'.$packageimage->Image) }}" style= "width:70px;">
                                @endif
                            </td>
                            <td class="center">
                              <a rel="{{ $packageimage->id }}" rel1="delete-alt-image" href="javascript:" class="btn btn-danger btn-mini deleteRecord">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
      </div>
  </div>




</div>
@endsection
