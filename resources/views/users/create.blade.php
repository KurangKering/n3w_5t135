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
            <h5>Tambah Pengguna</h5>
            <div class="ibox-tools">

            </div>
        </div>
        <div class="ibox-content">
            
            {!! Form::open(array('route' => 'users.store','method'=>'POST')) !!}

            <div class="row">

                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">

                        <strong>Username:</strong>

                        {!! Form::text('username', null, array('placeholder' => 'Username','class' => 'form-control')) !!}

                    </div>

                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">

                        <strong>Name:</strong>

                        {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!}

                    </div>

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">

                        <strong>Email:</strong>

                        {!! Form::text('email', null, array('placeholder' => 'Email','class' => 'form-control')) !!}

                    </div>

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">

                        <strong>Password:</strong>

                        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control')) !!}

                    </div>

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">

                        <strong>Confirm Password:</strong>

                        {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control')) !!}

                    </div>

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">

                    <div class="form-group">

                        <strong>Role:</strong>

                        {!! Form::select('roles[]', $roles,[], array('class' => 'form-control','multiple')) !!}

                    </div>

                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 text-center">

                    <button type="submit" class="btn btn-primary">Submit</button>

                </div>

            </div>

            {!! Form::close() !!}
            
        </div>
    </div>
</div>
</div>
@endsection
@section('custom_js')
<script>
</script>
@endsection