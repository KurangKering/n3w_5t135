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
				<h5>Ubah Pemasukan Lain</h5>
				<div class="ibox-tools">
					
				</div>
			</div>
			<div class="ibox-content">
				<form class="form-horizontal" method="POST" action="{{ route('pemasukan_lain.update', $pemasukan_lain->id) }}">
					@csrf
					{{ method_field('PATCH') }}

					<div class="form-group">
						<label class="control-label col-lg-2">Kode Transaksi</label>
						<div class="col-lg-10">
							<input class="form-control" readonly="" name="kode_transaksi" value="{{ $pemasukan_lain->transaksi_id }}">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Jenis Pembayaran</label>
						<div class="col-lg-10">
							<select class="form-control" name="jenis_bayar">
								@foreach (Config::get('enums.jenis_lain') as $index => $jenis_lain)

								<option  value="{{ $jenis_lain }}"
								@if ($jenis_lain == $pemasukan_lain->jenis_bayar)
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
							<textarea class="form-control" id="exampleTextarea" rows="3" name="uraian">{{ $pemasukan_lain->uraian }}</textarea>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-2">Tanggal Pembayaran</label>
						<div class="col-lg-10">
							<input class="form-control" type="date" value="{{ $pemasukan_lain->tanggal_bayar }}" id="example-date-input" name="tanggal_bayar">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Total Bayar</label>
						<div class="col-lg-10">
							<input class="form-control" name="total_bayar" value="{{ $pemasukan_lain->total_bayar }}" >
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Keterangan</label>
						<div class="col-lg-10">
							<textarea class="form-control" id="exampleTextarea" rows="3" name="keterangan">{{ $pemasukan_lain->keterangan }}</textarea>
						</div>

					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Lampiran</label>
						<div class="col-lg-10">
							
							<input type="file" class="form-control-file" id="lampiran" aria-describedby="fileHelp" name="lampiran">
							<br>
							@if ($pemasukan_lain->lampiran)
							<span><a target="_blank" href="{{ Storage::url($pemasukan_lain->lampiran) }}" title="">Lihat Lampiran Sebelumnya</a></span>
							@endif

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