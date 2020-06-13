@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content" class="col-md-12">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">CMS Pages</a> <a href="#" class="current">Edit CMS Page</a> </div>
    <h1>CMS Page</h1>
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
            <h5>Edit CMS Page</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('admin/edit-cms/'.$cmspageDetails->id) }}" name="edit_cms_page" id="edit_cms_page">
                @csrf
                <div class="control-group">
                    <label class="control-label">Title</label>
                    <div class="controls">
                        <input type="text" name="Title" id="Title" value="{{ $cmspageDetails->Title }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">CMS URL</label>
                    <div class="controls">
                        <input type="text" name="URL" id="URL" value="{{ $cmspageDetails->URL }}" >
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Description</label>
                    <div class="controls">
                        <textarea name="Description">{{ $cmspageDetails->Description }}</textarea>
                    </div>
                </div>
              <div class="control-group">
                  <label class="control-label">Enable</label>
                  <div class="controls">
                    <input type="checkbox" name="Status" id="Status" @if($cmspageDetails->Status=="1") checked @endif value="1">
                  </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Edit CSM Page" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
@endsection
