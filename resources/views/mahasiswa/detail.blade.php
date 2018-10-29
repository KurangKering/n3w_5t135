@extends('layouts.template')
@section('content')
<div class="header"> 

	<ol class="breadcrumb">
		<li><a href="#">Home</a></li>
		<li><a href="table.html">Data Mahasiswa</a></li>
		<li class="active">Detail Mahasiswa</li>
	</ol> 

</div>

<div id="page-inner">
	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">
					Kelas dan Jurusan
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-borderless table-condensed table-hover" >
							<tr>
								<th>Jenis Kelas</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->jenis_kelas }}"></th>
								<th></th>
								<th>Status Mahasiswa</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->status_mahasiswa }}"></th>
							</tr>

							<tr>
								<th>Program Studi</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->program_studi }}" ></th>
								<th></th>
								<th>Tahun Angkatan</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->tahun_angkatan }}"></th>
							</tr>
						</table>
					</div>
				</div>
				<div class="panel-heading">
					Identitas Pribadi
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-borderless table-condensed table-hover" >
							<tr>
								<th>NIM</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->nim }}" ></th>
							</tr>
							<tr>
								<th>Nama Mahasiswa</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->nama_mhs }}" ></th>
							</tr>

							<tr>
								<th>Tempat Lahir</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->tempat_lahir }}" ></th>
							</tr>
							<tr>
								<th>Tanggal Lahir</th>
								<th><input readonly class="form-control" type="text"  value="{{ $mahasiswa->tanggal_lahir }}"></th>
								<th></th>
								
								
							</tr>
							<tr>
								<th>Jenis Kelamin</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->jenis_kelamin }}"></th>
							</tr>
							<tr>
								<th>Agama</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->agama }}" ></th>
							</tr>
							<tr>
								<th>Asal Sekolah</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->asal_sekolah }}"></th>
							</tr>
							<tr>
								<th>Alamat</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->alamat }}"></th>
							</tr>
							<tr>
								<th>HP/Telepon</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->no_hp }}" ></th>
							</tr>
							<tr>
								<th>Email</th>
								<th><input readonly class="form-control" value="{{ $mahasiswa->email }}"></th>
							</tr>
							
						</table>
					</div>
				</div>
				<div class="panel-heading">
					Informasi SPP

				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-borderless table-condensed table-hover" >
							<thead>
								<tr>
									<th>Semester</th>
									<th>Tanggal Bayar</th>
									<th>Jumlah Bayar</th>
									<th>Keterangan</th>
								</tr>
								
							</thead>

							<tbody>
								@foreach($mahasiswa->pembayaran_semesters as $bayar)
								<tr>
									<td>{{ $bayar->semester }}</td>
									<td>{{ indonesian_date($bayar->tanggal_bayar) }}</td>
									<td>{{ rupiah($bayar->jumlah_bayar) }}</td>
									<td>{{ $bayar->ket_bayar }}</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection