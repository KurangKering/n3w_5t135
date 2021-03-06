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
				<h5>Ubah Mahasiswa</h5>
				<div class="ibox-tools">
					
				</div>
			</div>
			<div class="ibox-content">
				<form class="form-horizontal" 
				method="POST" 
				action="{{ route('mahasiswa.update', $mahasiswa->id) }}">
				@csrf
				{{ method_field('PATCH') }}
				<div class="form-group">
					<label for="" class="control-label col-lg-2">NIM</label>
					<div class="col-lg-10">
						<input  class="form-control" name="nim" value="{{ $mahasiswa->nim }}" >
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Nama</label>
					<div class="col-lg-10">
						<input  class="form-control" name="nama_mhs" value="{{ $mahasiswa->nama_mhs }}" >
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Jenis Kelas</label>
					<div class="col-lg-10">
						<input  class="form-control" name="jenis_kelas" value="{{ $mahasiswa->jenis_kelas }}" >
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Program Studi</label>
					<div class="col-lg-10">
						<select class="form-control" name="program_studi">
							@foreach (Config::get('enums.program_studi') as $index => $program_studi)
							<option  value="{{ $program_studi }}"
							@if ($program_studi == $mahasiswa->program_studi)
							selected="selected"
							@endif
							>{{ $program_studi }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Tahun Masuk</label>
					<div class="col-lg-10">
						<input  class="form-control" name="tahun_masuk" value="{{ $mahasiswa->tahun_masuk }}" >
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Tempat Lahir</label>
					<div class="col-lg-10">
						<input  class="form-control" name="tempat_lahir" value="{{ $mahasiswa->tempat_lahir }}" >
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Tanggal Lahir</label>
					<div class="col-lg-10">
						<input  class="form-control" type="date"  name="tanggal_lahir" value="{{ $mahasiswa->tanggal_lahir }}">
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Jenis Kelamin</label>
					<div class="col-lg-10">
						<select class="form-control" name="jenis_kelamin">
							@foreach (Config::get('enums.jenis_kelamin') as $index => $jenis_kelamin)
							<option value="{{ $jenis_kelamin }}"
							@if ($jenis_kelamin == $mahasiswa->jenis_kelamin)
							selected="selected" 
							@endif
							>{{ $jenis_kelamin }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Agama</label>
					<div class="col-lg-10">
						<select class="form-control" name="agama">
							@foreach (Config::get('enums.agama') as $index => $agama)
							<option value="{{ $agama }}"

							@if ($agama == $mahasiswa->agama)
							selected="selected"
							@endif
							>{{ $agama }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Asal Sekolah</label>
					<div class="col-lg-10">
						<input  class="form-control" name="asal_sekolah" value="{{ $mahasiswa->asal_sekolah }}">
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Alamat</label>
					<div class="col-lg-10">
						<input  class="form-control" name="alamat" value="{{ $mahasiswa->alamat }}">
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">No Hp</label>
					<div class="col-lg-10">
						<input  class="form-control" name="no_hp" value="{{ $mahasiswa->no_hp }}" >
					</div>
				</div>
				<div class="form-group">
					<label for="" class="control-label col-lg-2">Email</label>
					<div class="col-lg-10">
						<input  class="form-control" name="email" value="{{ $mahasiswa->email }}">
					</div>
				</div>
				<div class="text-center">
					<button type="submit" class="btn btn-primary ">Tambah</button>
				</div>
			</form>
		</div>
	</div>
</div>
</div>
@endsection
@section('custom_js')
<script>
	let table =  $("#table-mahasiswa").DataTable();

</script>
@endsection