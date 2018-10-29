@extends('layouts.new_template')
@section('custom_css')
<style type="text/css" media="screen">
#pas_photo {
	width: 250px;
	height: 250px;
}
</style>
@endsection
@section('page-heading')
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Dashboard</h2>
		<ol class="breadcrumb">
			<li>
				<a href="index.html">Home</a>
			</li>
			<li>
				<a>a</a>
			</li>
			<li class="active">
				<strong>Static a</strong>
			</li>
		</ol>
	</div>
	<div class="col-lg-2">
	</div>
</div>
@endsection
@section('content')
{!! Form::model($user, ['method' => 'POST','route' => ['profil.update'], 'enctype' => 'multipart/form-data']) !!}

<div class="row">
	@if (count($errors) > 0)

	<div class="alert alert-danger">

		<strong>Whoops!</strong> There were some problems with your input.<br><br>

		<ul>

			@foreach ($errors->all() as $error)

			<li>{{ $error }}</li>

			@endforeach

		</ul>

	</div>

	@endif
	<div class="col-md-6 ">

		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h3>Data Pengguna</h3>
			</div>
			<div class="ibox-content">


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





				</div>

			</div>



		</div>
	</div>
	<div class="col-md-6">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h3>Photo Pengguna</h3>
			</div>
			<div class="ibox-content">

				<div id="container-photo">
					<div class="m-b-sm text-center">
						<img  class="" id="pas_photo" src="{{ $user->file_photo ? asset('storage/'.$user->file_photo) : Storage::url('photo-profil/default-profile.jpg')}}">
					</div>
				</div>
				<br>
				<div class="fileinput fileinput-new input-group" data-provides="fileinput">
					<div class="form-control" data-trigger="fileinput">
						<i class="glyphicon glyphicon-file fileinput-exists"></i>
						<span class="fileinput-filename"></span>
					</div>
					<span class="input-group-addon btn btn-default btn-file">
						<span class="fileinput-new">Select file</span>
						<span class="fileinput-exists">Change</span>
						<input type="file" id="file_photo" name="file_photo"/>
					</span>
					<a href="#" class="input-group-addon btn btn-default fileinput-exists" id="remove" data-dismiss="fileinput">Remove</a>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="panel panel-body">
			<div class="col-xs-12 col-sm-12 col-md-12 text-center">

				<button type="submit" class="btn btn-primary btn-block">Submit</button>

			</div>
		</div>
	</div>
</div>
{!! Form::close() !!}

@endsection
@section('custom_js')
<script type="text/javascript">
	
// Function to preview image after validation
$(function() {
	var image_original = "{{ $user->file_photo ? Storage::url($user->file_photo) : Storage::url('photo-profil/default-profile.jpg')}}";
	$("#file_photo").change(function() {
		// var file = this.files[0];
		// var imagefile = file.type;
		// var fileSize = file.size / 1000 ;
		// var match= ["image/jpeg","image/png","image/jpg"];
		// if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])) ||  fileSize > 1500)
		// {
		// 	$('#pas_photo').attr('src','');
		// 	$("#file_photo").val("");
		// 	return false;
		// }
		// else
		// {
			var reader = new FileReader();
			reader.onload = imageIsLoaded;
			reader.readAsDataURL(this.files[0]);
		// }
	});
	$('#remove').click(function() {
		$('#pas_photo').attr('src', image_original);
		$('#pas_photo').attr('width', '250px');
		$('#pas_photo').attr('height', '230px');
	})
});
function imageIsLoaded(e) {
	$('#pas_photo').attr('src', e.target.result);
	$('#pas_photo').attr('width', '250px');
	$('#pas_photo').attr('height', '230px');
};

</script>
@endsection