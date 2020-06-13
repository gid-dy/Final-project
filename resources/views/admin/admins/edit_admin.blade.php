@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content" class="col-md-12">
    <div id="content-header">
        <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Admin/Sub-Admin</a> <a href="#" class="current">Edit Admin/Sub-Admin</a> </div>
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
                        <form class="form-horizontal" method="post" action="{{ url('admin/edit-admin/'.$adminDetails->id) }}" name="edit_Admin/Sub-Admin" id="edit_Admin/Sub-Admin" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Type</label>
                                <div class="controls">
                                    <input type="text" name="Type" id="Type" readonly="" value="{{ $adminDetails->Type }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Email</label>
                                <div class="controls">
                                    <input type="email" name="UserEmail" id="UserEmail" readonly="" value="{{ $adminDetails->UserEmail }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Password</label>
                                <div class="controls">
                                    <input type="password" name="Password" id="Password">
                                </div>
                            </div>
                            @if ($adminDetails->Type=="Sub-Admin")
                                <div class="control-group">
                                    <label class="control-label">Access</label>
                                    <div class="controls">
                                        <input type="checkbox" name="Categories_access" id="Categories_access" value="1" style="margin-top:-3px;" @if ($adminDetails->Categories_access == "1") checked @endif>&nbsp;Categories &nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="Tourpackages_access" id="Tourpackages_access" value="1" style="margin-top:-3px" @if ($adminDetails->Tourpackages_access == "1") checked @endif>&nbsp;Tourpackages &nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="Bookings_access" id="Bookings_access" value="1" style="margin-top:-3px" @if ($adminDetails->Bookings_access == "1") checked @endif>&nbsp;Bookings &nbsp;&nbsp;&nbsp;
                                        <input type="checkbox" name="Users_access" id="Users_access" value="1" style="margin-top:-3px" @if ($adminDetails->Users_access == "1") checked @endif>&nbsp;Users
                                    </div>
                                </div>
                            @endif
                            <div class="control-group">
                                <label class="control-label">Enable</label>
                                <div class="controls">
                                    <input type="checkbox" name="Status" id="Status" value="1" @if ($adminDetails->Status == "1") checked @endif>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Edit Admin" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
