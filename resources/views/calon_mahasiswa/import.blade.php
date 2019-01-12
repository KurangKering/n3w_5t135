@extends('layouts.new_template')
@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Data</h2>
  </div>
  <div class="col-lg-2">
  </div>
</div>
@endsection
@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Data Pendaftaran</h5>
        <div class="ibox-tools">
          <button onclick="location.href='{{ route('pendaftaran.create') }}'" class="btn btn-success">Tambah Pendaftaran</button>
        </div>
      </div>
      <div class="ibox-content">
      	
      </div>
    </div>
  </div>
</div>
<div id="form-form"></div>
@endsection
@section('custom_js')
<script></script>
@endsection