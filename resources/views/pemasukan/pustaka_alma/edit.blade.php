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
				<h5>Data Mahasiswa</h5>
				<div class="ibox-tools">
					
				</div>
			</div>
			<form action="" class="form-horizontal">
				<div class="ibox-content">
					<div class="row">
						<div class="col-lg-6">
							<div class="form-group">
								<label for="" class="control-label col-lg-3">NIM</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="nim" value="{{ $detail->pustaka_alma->mahasiswa->nim }}">
								</div>
								
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Program Studi</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="program_studi" value="{{ $detail->pustaka_alma->mahasiswa->calon_mahasiswa->program_studi }}">
								</div>
							</div>
							
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Nama Mahasiswa</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="nama" value="{{ $detail->pustaka_alma->mahasiswa->calon_mahasiswa->nama }}" >
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Angkatan</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="angkatan" value="{{ $detail->pustaka_alma->mahasiswa->calon_mahasiswa->tahun_masuk }}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Form Ubah Pembayaran Pustaka & Almamater</h5>
				<div class="ibox-tools">
					
				</div>
				<form method="POST" id="form-pustaka-alma" action="{{ route('pustaka_alma.update', $detail->id) }}" class="form-horizontal">
					@csrf
					{{ method_field('PATCH') }}
					<div class="ibox-content">
						<input type="hidden" name="mahasiswa_id" value="">
						<div class="form-group">
							<label class="control-label col-lg-2">Transaksi ID</label>
							<div class="col-lg-10">
								<input class="form-control" readonly value="{{ $detail->transaksi_id }}">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Uang Pustaka</label>
							<div class="col-lg-10">
								<input class="form-control" name="bayar_pustaka" value="{{ $detail->bayar_pustaka }}">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Uang Almamater</label>
							<div class="col-lg-10">
								<input class="form-control" name="bayar_alma" value="{{ $detail->bayar_alma }}">
							</div>
						</div>
						

						<div class="form-group">
							<label class="control-label col-lg-2">Tanggal Pembayaran</label>
							<div class="col-lg-10">
								<input class="form-control" type="date"  value="{{ $detail->tanggal_bayar }}" name="tanggal_bayar" id="example-date-input">
							</div>
							

						</div>

						<div class="text-center">
							<button type="submit" id="btn-submit" class="btn btn-primary btn-lg">Selesai</button>
							<button type="button" onclick="location.href='{{ url()->previous() }}'" class="btn btn-flat btn-lg">Kembali</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Data Pembayaran Pendaftaran</h5>
				
				
			</div>
			<div class="ibox-content">
				<table class="table table-bordered" id="table-data">
					<thead>
						<tr>
							<th rowspan="2" width="1%" nowrap style="vertical-align: middle; text-align: center">Transaksi ID</th>
							<th rowspan="2" style="vertical-align: middle; text-align: center">Tanggal Bayar</th>
							<th colspan="2" class="text-center">Pembayaran</th>
						</tr>
						<tr>
							<th>Pustaka</th>
							<th>Almamater</th>
						</tr>
					</thead>
					<tbody id="content-pendaftaran">
						@php $jumlahPustaka= 0; $jumlahAlma = 0; @endphp
						@foreach ($detail->pustaka_alma->pustaka_alma_det as $k => $v)
						@php
						$jumlahPustaka += $v['bayar_pustaka'];
						$jumlahAlma += $v['bayar_alma'];
						@endphp
						<tr>
							<td>{{ $v['transaksi_id'] }}</td>
							<td>{{ indonesian_date($v['tanggal_bayar']) }}</td>
							<td>{{ rupiah($v['bayar_pustaka']) }}</td>
							<td>{{ rupiah($v['bayar_alma']) }}</td>
						</tr>
						@endforeach
						<tr>
							<td colspan="2" style="font-weight: bold; text-align: right">Total</td>
							<td>{{ rupiah($jumlahPustaka) }}</td>
							<td>{{ rupiah($jumlahAlma) }}</td>
						</tr>
						<tr>
							<td colspan="2" style="font-weight: bold; text-align: right">Status</td>
							<td colspan="2">{{ ($detail->pustaka_alma->ket_bayar) }}</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

@endsection
@section('custom_js')
<script type="text/javascript">

	let $btnSubmit = $("#btn-submit");
	let $form = $("#form-pustaka-alma");
	$form.submit(function(e) {
		e.preventDefault();

		let formData = $(this).serialize();
		let url = '{{ route('pustaka_alma.update', $detail->id) }}';

		$btnSubmit.attr('disabled', true);

		axios.post(url, formData)
		.then(response => {
			resp = response.data;
			if (!resp.success) 
			{
				swal({
					icon : 'warning',
					title : "Gagal",
					text : resp.msg,
					timer : 1500,
					buttons : false,
					closeOnClickOutside: false,
				})
			} else {
				location.href = '{{ route("pustaka_alma.index") }}';
			}
		}).catch(err => {

		})
		.finally(() => {
			$btnSubmit.attr('disabled', false);
		})

	})


</script>
@endsection