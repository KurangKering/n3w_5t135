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
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Data Pegawai</h5>
				<div class="ibox-tools">
					<button onclick="location.href='{{ route('pegawai.create') }}'" class="btn btn-success">Tambah Pegawai</button>
				</div>
			</div>
			<div class="ibox-content">

				<table id="table-pegawai" class="table table-striped table-bordered table-hover" >
					<thead>
						<tr>
							<th>NIDN</th>
							<th>Nama</th>
							<th>Jabatan</th>
							<th>Jenis Kelamin</th>
							<th>No Telp</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>

						@foreach ($pegawais as $pegawai)
						<tr>
							<td>{{ $pegawai->nip }}</td>
							<td>{{ $pegawai->nama_pegawai }}</td>
							<td>{{ $pegawai->jabatan }}</td>
							<td>{{ $pegawai->jenis_kelamin }}</td>
							<td>{{ $pegawai->no_hp }}</td>
							<td class="text-center" width="1%" style="white-space: nowrap">
								<a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-primary">Edit</a>
							</td>
						</tr>
						@endforeach
					</tbody>
				</table>

			</div>
		</div>
	</div>
</div>
@endsection
@section('custom_js')
<script>
	$(function() {
		let table =  $("#table-pegawai").DataTable({
			dom:  '<"html5buttons"B>lfrtip',
			buttons: [

			{extend: 'print',
			customize: function (win){
				$(win.document.body).addClass('white-bg');
				$(win.document.body).css('font-size', '10px');


				$(win.document.body).find('h1').css(
				{
					'font-size':'14px', 
					'text-align': 'center',
					'font-weight' : 'bold',
				}
				);

				$(win.document.body).find('table')
				.addClass('compact')
				.css('font-size', 'inherit');
			},
			pageSize : "A4",
			orientation : 'portrait',
			title : 'Data Pegawai',
			exportOptions : {
				columns: [ 0, 1,2,3,4 ]
			}
		},
		]
	});

	});
	
</script>
@endsection