@extends('layouts.new_template')
@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
  <div class="col-lg-10">
    <h2>Pengguna</h2>
</div>
<div class="col-lg-2">
</div>
</div>
@endsection
@section('content')
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-content">
        
        <div class="row">

            <div class="col-lg-12 margin-tb">

                <div class="pull-left">

                    <h2> Show User</h2>

                </div>

                <div class="pull-right">

                    <a class="btn btn-primary" href="{{ route('users.index') }}"> Back</a>

                </div>

            </div>

        </div>


        <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>Name:</strong>

                    {{ $user->name }}

                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>Email:</strong>

                    {{ $user->email }}

                </div>

            </div>

            <div class="col-xs-12 col-sm-12 col-md-12">

                <div class="form-group">

                    <strong>Roles:</strong>

                    @if(!empty($user->getRoleNames()))

                    @foreach($user->getRoleNames() as $v)

                    <label class="badge badge-success">{{ $v }}</label>

                    @endforeach

                    @endif

                </div>

            </div>

        </div>
    </div>
</div>
</div>
</div>
@endsection
@section('custom_js')
<script>
  let $table    = $("#tbl-user").DataTable();
</script>
@endsection