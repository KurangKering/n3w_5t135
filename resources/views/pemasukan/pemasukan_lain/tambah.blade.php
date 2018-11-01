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
				<h5>Tambah Pemasukan Lain</h5>
				<div class="ibox-tools">
					
				</div>
			</div>
			<div class="ibox-content">
				<form class="form-horizontal" method="POST" action="{{ route('pemasukan_lain.store') }}" enctype="multipart/form-data">
					@csrf
					<div class="form-group">
						<label class="control-label col-lg-2">Jenis Pembayaran</label>
						<div class="col-lg-10">
							<select class="form-control" name="jenis_bayar">
								@foreach (Config::get('enums.jenis_lain') as $index => $jenis_lain)

								<option  value="{{ $jenis_lain }}"
								@if ($jenis_lain == old("jenis_bayar"))
								selected="selected" 
								@endif
								>{{ $jenis_lain }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Uraian</label>
						<div class="col-lg-10">
							<textarea class="form-control" id="exampleTextarea" rows="3" name="uraian">{{ old("uraian") }}</textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2">Tanggal Pembayaran</label>
						<div class="col-lg-10">
							<input class="form-control" type="date" value="{{ old("tanggal_bayar") ?? date('Y-m-d') }}" id="example-date-input" name="tanggal_bayar">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Total Bayar</label>
						<div class="col-lg-10">
							<input class="form-control" type="number" name="total_bayar" value="{{ old('total_bayar') }}">
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Keterangan</label>
						<div class="col-lg-10">
							<textarea class="form-control" id="keterangan"  name="keterangan">{{ old("keterangan") }}</textarea>
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Lampiran</label>
						<div class="col-lg-10">
							<input type="file" class="form-control-file" id="lampiran" aria-describedby="fileHelp" name="lampiran">
						</div>
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
<script type="text/javascript">
	CKEDITOR.replace( 'keterangan', {
		height: '300px',
		extraPlugins: 'forms'
	});
</script>
@endsection