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
									<input readonly class="form-control" id="nim" value="{{ $detail->pembayaran_semester->mahasiswa->nim }}" >
								</div>
								
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Program Studi</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="program_studi" value="{{ $detail->pembayaran_semester->mahasiswa->program_studi }}" >
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Angkatan</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="angkatan" value="{{ $detail->pembayaran_semester->mahasiswa->tahun_masuk }}">
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Nama Mahasiswa</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="nama_mhs"  value="{{ $detail->pembayaran_semester->mahasiswa->nama_mhs }}">
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Kelas</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="jenis_kelas" value="{{ $detail->pembayaran_semester->mahasiswa->jenis_kelas }}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Form Ubah Pembayaran Semester</h5>
				<div class="ibox-tools">
					
				</div>
				<form method="POST" action="{{ route('pembayaran_semester.update', $detail->id) }}" class="form-horizontal">
					<div class="ibox-content">
						@csrf
						<input type="hidden" name="mahasiswa_id" value="{{ $detail->pembayaran_semester->mahasiswa->id }}">
						{{ method_field('PATCH') }}
						<div class="form-group">
							<label class="control-label col-lg-2">Kode Transaksi</label>
							<div class="col-lg-10">
								<input class="form-control" name="kode_transaksi" readonly="" value="{{ $detail->transaksi_id }}">
							</div>
						</div><div class="form-group">
							<label class="control-label col-lg-2">Semester</label>
							<div class="col-lg-10">
								<input type="number" readonly value="{{ $detail->pembayaran_semester->semester }}" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Jumlah Bayar</label>
							<div class="col-lg-10">
								<input class="form-control" type="number" value="{{ $detail->jumlah_bayar }}" name="jumlah_bayar">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Tanggal Bayar</label>
							<div class="col-lg-8">
								<input class="form-control" type="date" value="{{  $detail->tanggal_bayar }}" name="tanggal_bayar" id="example-date-input">
							</div>
							<div class="col-lg-2">
								<select class="form-control" name="status">
									@foreach (\Config::get("enums.status_bayar") as $stat)
									<option value="{{ $stat }}"
									@if ($stat == $detail->pembayaran_semester->ket_bayar)
									selected="selected" 
									@endif
									>
									{{ $stat }}
								</option>
								@endforeach
							</select>
						</div>
					</div>



					<div class="text-center">
						<button type="submit" class="btn btn-primary btn-lg">Selesai</button>
					</div>
				</div>
			</form>
		</div>
	</div>
	<div class="ibox float-e-margins">
		<div class="ibox-title">
			<h5>Data Pembayaran Semester</h5>


		</div>
		<div class="ibox-content">
			<table class="table table-bordered" id="table-semester">
				<thead>
					<tr>
						<th class="text-center">Semester</th>
						<th>Transaksi ID</th>
						<th>Jumlah Bayar</th>
						<th>Tanggal Bayar</th>
						<th class="text-center">Status</th>
					</tr>
				</thead>
				<tbody id="content-semester">
					@foreach($mahasiswa->pembayaran_semester as $pembayaran)
					@foreach($pembayaran->pembayaran_semester_det as $ii => $det)
					<tr>
						@if ($ii == 0)
						<td style="vertical-align: middle; text-align: center" rowspan="{{ sizeof($pembayaran->pembayaran_semester_det) }}">
							{{ $pembayaran->semester }}
						</td>
						@endif

						<td>{{ $det->transaksi_id }}</td>
						<td>{{ rupiah($det->jumlah_bayar) }}</td>
						<td>{{ indonesian_date($det->tanggal_bayar) }}</td>
						@if ($ii == 0)
						<td style="vertical-align: middle; text-align: center" rowspan="{{ sizeof($pembayaran->pembayaran_semester_det) }}">
							{{ $pembayaran->ket_bayar }}
						</td>
						@endif
					</tr>
					@endforeach
					@endforeach
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
	

</script>
@endsection