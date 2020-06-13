@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content" class="col-md-12">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Admin/Sub-Admin</a> <a href="#" class="current">Add Admin/Sub-Admin</a> </div>
        <h1>Admin/Sub-Admin</h1>
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
                        <h5>Admin/Sub-Admin</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{ route('admin.add-admin') }}" name="add_Admin/Sub-Admin" id="add_Admin/Sub-Admin" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Type</label>
                                <div class="controls">
                                    <select name="Type" id="Type" style="width:220px">
                                        <option value="Admin">Admin</option>
                                        <option value="Sub-Admin">Sub-Admin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Email</label>
                                <div class="controls">
                                    <input type="email" name="UserEmail" id="UserEmail">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Password</label>
                                <div class="controls">
                                    <input type="password" name="Password" id="Password">
                                </div>
                            </div>
                            <div class="control-group" id="access">
                                <label class="control-label">Access</label>
                                <div class="controls">
                                    <input type="checkbox" name="Categories_access" id="Categories_access" value="1" style="margin-top:-3px">&nbsp;Categories &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="Tourpackages_access" id="Tourpackages_access" value="1" style="margin-top:-3px">&nbsp;Tourpackages &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="Bookings_access" id="Bookings_access" value="1" style="margin-top:-3px">&nbsp;Bookings &nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="Users_access" id="Users_access" value="1" style="margin-top:-3px">&nbsp;Users
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Enable</label>
                                <div class="controls">
                                    <input type="checkbox" name="Status" id="Status" value="1">
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Add Admin" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
