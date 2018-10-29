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
				<h5>Data Pegawai</h5>
				<div class="ibox-tools">
					
				</div>
			</div>
			<form action="" class="form-horizontal">
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="" class="control-label col-lg-3">NIP</label>
								<div class="col-lg-8"><input class="form-control" id="nip" value="{{ $pembayaran_gaji->pegawai->nip }}" readonly="" >
								</div>
								
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Nama</label>
								<div class="col-lg-8"><input class="form-control" id="nama_pegawai" value="{{ $pembayaran_gaji->pegawai->nama_pegawai }}" readonly=""></div>
							</div>
							
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Data Pembayaran Gaji</h5>
				<div class="ibox-tools">
					
				</div>
				<form method="POST" class="form-horizontal" action="{{ route('pembayaran_gaji.update', $pembayaran_gaji->id) }}" enctype="multipart/form-data">
					@csrf
					{{method_field('PATCH')}}
					<div class="ibox-content">
						@csrf
						<input type="hidden" name="pegawai_id" value="">


						<div class="form-group">
							<label class="control-label col-lg-2">Tanggal Pembayaran</label>
							<div class="col-lg-10">
								<input class="form-control" type="date"  value="{{ $pembayaran_gaji->tanggal_bayar }}" name="tanggal_bayar" id="example-date-input">
							</div>
							<th></th>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Jumlah Gaji</label>
							<div class="col-lg-10">
								<input class="form-control" name="jumlah_gaji" value="{{ $pembayaran_gaji->jumlah_gaji }}">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Uraian</label>
							<div class="col-lg-10">
								<textarea class="form-control" id="exampleTextarea" name="uraian"  rows="3">{{ $pembayaran_gaji->uraian }}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Lampiran</label>
							<div class="col-lg-10">

								<input type="file" class="form-control-file" name="lampiran" id="lampiran" aria-describedby="fileHelp">
								<br>
								@if ($pembayaran_gaji->lampiran)
								<span><a target="_blank" href="{{ Storage::url($pembayaran_gaji->lampiran) }}" title="">Lihat Lampiran Sebelumnya</a></span>
								@endif

							</div>
						</div>


						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-lg">Selesai</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
@section('custom_js')
<script type="text/javascript">

	CKEDITOR.replace( 'uraian', {
		height: '300px',
		extraPlugins: 'forms'
	});

	$(document).ready(function() {
		$("#lookup").dataTable();

	});
	$(document).on('click', '.pilih', function (e) {
		var id = $(this).attr('data-pegawai');
		var nip = $(this).attr('data-nip');
		var nama = $(this).attr('data-nama');
		$('input[name="pegawai_id"]').val(id);
		$('#nip').val(nip);
		$('#nama_pegawai').val(nama);
		
		$('#myModal').modal('hide');
	});

</script>
@endsection