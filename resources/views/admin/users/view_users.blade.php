@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content" class="col-lg-12">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Users</a> <a href="#" class="current">View Users</a> </div>
    <h1>Users</h1>
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
    <div style="margin-left:20px;">
        <a href="{{ url('/admin/export-users') }}" class="btn btn-primary btn-mini">Export</a>
    </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>users</h5>
          </div>

          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>User Id</th>
                        <th>SurName</th>
                        <th>OtherNames</th>
                        <th>Email</th>
                        <th>Country</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Status</th>
                        <th>Mobile</th>
                        <th>OtherContact</th>
                        <th>Registered on</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="gradeX">
                            <td class="center">{{ $user->id }}</td>
                            <td class="center">{{ $user->SurName }}</td>
                            <td class="center">{{ $user->OtherNames }}</td>
                            <td class="center">{{ $user->UserEmail }}</td>
                            <td class="center">{{ $user->Country }}</td>
                            <td class="center">{{ $user->Address }}</td>
                            <td class="center">{{ $user->City }}</td>
                            <td class="center">{{ $user->State }}</td>
                            <td class="center">
                                @if($user->Status==1)
                                    <span class="btn btn-success btn-mini">Active</span>
                                @else
                                    <span class="btn btn-danger btn-mini">Inactive</span>
                                @endif
                            </td>
                            <td class="center">{{ $user->Mobile }}</td>
                            <td class="center">{{ $user->OtherContact }}</td>
                            <td class="center">{{ $user->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
