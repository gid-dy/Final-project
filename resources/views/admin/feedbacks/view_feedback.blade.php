@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Feedback</a> <a href="#" class="current">View Feedback</a> </div>
    <h1>Feedback</h1>
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
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Feedback</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
                <thead>
                    <tr>
                        <th>User Id</th>
                        <th>Package Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Created on</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($feedbacks as $feedback)
                        <tr class="gradeX">
                            <td class="center">{{ $feedback->id }}</td>
                            <td class="center">{{ $feedback->Package_id }}</td>
                            <td class="center">{{ $feedback->SurName }} {{ $feedback->OtherNames }}</td>
                            <td class="center">{{ $feedback->UserEmail }}</td>
                            <td class="center">{{ $feedback->Message }}</td>
                            <td class="center">
                                @if($feedback->Status==1)
                                    <a href="{{ url('admin/update-feedback/'.$feedback->id.'/0') }}"><span class="btn btn-success btn-mini">Active</span>
                                @else
                                <a href="{{ url('admin/update-feedback/'.$feedback->id.'/1') }}"><span class="btn btn-danger btn-mini">Inactive</span></a>
                                @endif
                            </td>
                            <td class="center">{{ $feedback->created_at }}</td>
                            <td class="center"><a href="{{ url('admin/delete-feedback/'.$feedback->id.'') }}" >Delete</a></td>
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
