@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content" class="col-md-12">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Categories</a> <a href="#" class="current">Add Category</a> </div>
        <h1>Categories</h1>
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
                        <h5>Add Category</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ route('admin.add-category') }}" name="add_category" id="add_category" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Category Name</label>
                                <div class="controls">
                                    <input type="text" name="CategoryName" id="CategoryName">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                    <textarea name="CategoryDescription" id="editor"></textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Meta Title</label>
                                <div class="controls">
                                    <input type="text" name="meta_title" id="meta_title">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Meta Description</label>
                                <div class="controls">
                                    <input type="text" name="meta_description" id="meta_description">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Meta Keywords</label>
                                <div class="controls">
                                    <input type="text" name="meta_keywords" id="meta_keywords">
                                </div>
                            </div>

                        <div class="control-group">
                            <label class="control-label">Image</label>
                            <div class="controls">
                                <input type="file" name="Imageaddress" id="Imageaddress">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label">Enable</label>
                            <div class="controls">
                                <input type="checkbox" name="CategoryStatus" id="CategoryStatus" value="1">
                            </div>
                        </div>
                        <div class="form-actions">
                            <input type="submit" value="Add Category" class="btn btn-success">
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
