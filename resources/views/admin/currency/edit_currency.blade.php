@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="{{ url('admin/dashboard') }}" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Currencies</a> <a href="#" class="current">Edit Currency</a> </div>
    <h1>Currencies</h1>
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
            <h5>Edit Currency</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" enctype="multipart/form-data" method="post" action="{{ url('/admin/edit-currency/'.$currencyDetails->id) }}" name="edit_currency" id="edit_currency" novalidate="novalidate">
                @csrf
                <div class="control-group">
                    <label class="control-label">Currency Code</label>
                    <div class="controls">
                    <input type="text" name="CurrencyCode" id="CurrencyCode" value="{{ $currencyDetails->CurrencyCode }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Exchange Rate</label>
                    <div class="controls">
                        <input type="text" name="ExchangeRate" id="ExchangeRate" value="{{ $currencyDetails->ExchangeRate }}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Enable</label>
                    <div class="controls">
                        <input type="checkbox" name="Status" id="Status" @if($currencyDetails->Status=="1") checked @endif value="1">
                    </div>
                </div>
              <div class="form-actions">
                <input type="submit" value="Edit Currency" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
