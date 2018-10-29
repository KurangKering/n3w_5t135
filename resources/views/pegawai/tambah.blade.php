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
		@if (count($errors) > 0)

		<div class="alert alert-danger">

			<strong>Whoops!</strong> Ada Kesalahan Dalam Input Data.<br><br>

			<ul>

				@foreach ($errors->all() as $error)

				<li>{{ $error }}</li>

				@endforeach

			</ul>

		</div>

		@endif
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Tambah Mahasiswa</h5>
				<div class="ibox-tools">
					
				</div>
			</div>
			<div class="ibox-content">
				<form class="form-horizontal" method="POST" action="{{ route('pegawai.store') }}">
					@csrf
					<div class="form-group">
						<label class="control-label col-lg-2">NIP</label>
						<div class="col-lg-10"><input class="form-control" value="{{ old("nip") }}" name="nip" ></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Nama</label>
						<div class="col-lg-10"><input class="form-control" value="{{ old("nama_pegawai") }}" name="nama_pegawai" ></div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2">Jabatan</label>
						<div class="col-lg-10"><input class="form-control" value="{{ old("jabatan") }}" name="jabatan" ></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Tempat Lahir</label>
						<div class="col-lg-10"><input class="form-control" type="text" value="{{ old("tempat_lahir") }}" name="tempat_lahir" id="example-date-input"></div>

					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Tanggal Lahir</label>
						<div class="col-lg-10"><input class="form-control" type="date" value="{{ old("tanggal_lahir") }}" name="tanggal_lahir" id="example-date-input"></div>

					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Jenis Kelamin</label>
						<div class="col-lg-10">
							<select name="jenis_kelamin" class="form-control">
								@foreach (Config::get('enums.jenis_kelamin') as $index => $jk)
								<option value="{{$jk}}"

								@if ($jk == old("jenis_kelamin"))
								selected="selected" 
								@endif
								>{{$jk}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Agama</label>
						<div class="col-lg-10">
							<select name="agama" class="form-control">
								@foreach (Config::get('enums.agama') as $index => $agama)
								<option value="{{$agama}}"
								@if ($agama == old("agama"))
								selected="selected" 
								@endif
								>{{$agama}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">HP/Telepon</label>
						<div class="col-lg-10"><input class="form-control" value="{{ old("no_hp") }}" name="no_hp"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Email</label>
						<div class="col-lg-10"><input class="form-control" value="{{ old("email") }}" name="email"></div>
					</div>
					<div class="text-center">
						<button type="submit" class="btn btn-primary btn-lg">Tambah</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection
@section('custom_js')
<script>
	
</script>
@endsection