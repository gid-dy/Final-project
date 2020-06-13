@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Enquiries</a> <a href="#" class="current">View Enquiries</a> </div>
    <h1>Enquiries</h1>
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
            <h5>View Enquiries</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                    <th style="text-align:left;">Id</th>
                    <th style="text-align:left;">Name</th>
                    <th style="text-align:left;">Email</th>
                    <th style="text-align:left;">Subject</th>
                    <th style="text-align:left;">Message</th>
                    <th style="text-align:left;">Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($contacts as $contact)
                   <tr class="gradeX">
                    <td>{{ $contact->id }}</td>
                  <td>{{ $contact->SurName }} {{ $contact->OtherNames }}</td>
                  <td>{{ $contact->UserEmail }}</td>
                  <td>{{ $contact->Subject }}</td>
                  <td>{{ $contact->message }}</td>

                    <td class="center"><a href="{{ url('admin/delete-contact/'.$contact->id.'') }}" class="btn btn-danger btn-mini" >Delete</a></td>

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
