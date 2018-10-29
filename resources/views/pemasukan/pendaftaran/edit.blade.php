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
									<input readonly class="form-control" id="nim" value="{{ $detail->pendaftaran->mahasiswa->nim }}">
								</div>
								
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Program Studi</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="program_studi" value="{{ $detail->pendaftaran->mahasiswa->program_studi }}">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Angkatan</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="angkatan" value="{{ $detail->pendaftaran->mahasiswa->tahun_masuk }}">
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Nama Mahasiswa</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="nama_mhs" value="{{ $detail->pendaftaran->mahasiswa->nama_mhs }}" >
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Kelas</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="jenis_kelas" value="{{ $detail->pendaftaran->mahasiswa->jenis_kelas }}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Form Ubah Pembayaran Pendaftaran</h5>
				<div class="ibox-tools">
					
				</div>
				<form method="POST" action="{{ route('pendaftaran.update', $detail->id) }}" class="form-horizontal">
					@csrf
					{{ method_field('PATCH') }}
					<div class="ibox-content">
						@csrf
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
							<label class="control-label col-lg-2">Uang Pendaftaran</label>
							<div class="col-lg-10">
								<input class="form-control" name="bayar_pendaftaran" value="{{ $detail->bayar_pendaftaran }}">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">Tanggal Pembayaran</label>
							<div class="col-lg-6">
								<input class="form-control" type="date"  value="{{ $detail->tanggal_bayar }}" name="tanggal_bayar" id="example-date-input">
							</div>
							<label class="control-label col-lg-2">Status</label>
							<div class="col-lg-2">
								<select class="form-control" name="ket_bayar">
									@foreach (Config::get('enums.status_bayar') as $index => $status)
									<option value="{{ $status }}"

									@if ($status == $detail->pendaftaran->ket_bayar)
									selected="selected" 
									@endif
									>{{ $status }}</option>
									@endforeach
								</select>
							</div>

						</div>

						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-lg">Selesai</button>
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
							<th colspan="3" class="text-center">Pembayaran</th>
							<th rowspan="2" class="text-center" style="vertical-align: middle">Jumlah</th>
							
						</tr>
						<tr>
							<th>Pustaka</th>
							<th>Almamater</th>
							<th>Pendaftaran</th>
						</tr>
					</thead>
					<tbody id="content-pendaftaran">
						@php $total= 0; @endphp
						@foreach ($detail->pendaftaran->pendaftaran_det as $k => $v)
						@php
						$jumlah = $v['bayar_pustaka'] + $v['bayar_alma'] + $v['bayar_pendaftaran'];
						$v['jumlah'] = ($jumlah);
						$total += $jumlah;
						@endphp
						<tr>
							<td>{{ $v['transaksi_id'] }}</td>
							<td>{{ indonesian_date($v['tanggal_bayar']) }}</td>
							<td>{{ rupiah($v['bayar_pustaka']) }}</td>
							<td>{{ rupiah($v['bayar_alma']) }}</td>
							<td>{{ rupiah($v['bayar_pendaftaran']) }}</td>
							<td>{{ rupiah($v['jumlah']) }}</td>
						</tr>
						@endforeach
						<tr>
							<td colspan="5" style="font-weight: bold; text-align: right">Total</td>
							<td>{{ rupiah($total) }}</td>
						</tr>
						<tr>
							<td colspan="5" style="font-weight: bold; text-align: right">Status</td>
							<td>{{ ($detail->pendaftaran->ket_bayar) }}</td>
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
	$(document).ready(function() {
		$("#lookup").dataTable();



	});
	$(document).on('click', '.pilih', function (e) {

		var id = $(this).attr('data-mahasiswa');
		var nim = $(this).attr('data-nim');
		var nama_mhs = $(this).attr('data-nama_mhs');
		var program_studi = $(this).attr('data-program_studi');
		var jenis_kelas = $(this).attr('data-jenis_kelas');
		var tahun_angkatan = $(this).attr('data-tahun_angkatan');

		$('input[name="mahasiswa_id"]').val(id);
		$('#nim').val(nim);
		$('#nama_mhs').val(nama_mhs);
		$('#program_studi').val(program_studi);
		$('#jenis_kelas').val(jenis_kelas);
		$('#angkatan').val(tahun_angkatan);
		$('#myModal').modal('hide');
	});

</script>
@endsection