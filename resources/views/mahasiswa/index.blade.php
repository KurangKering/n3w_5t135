	@extends('layouts.new_template')
@section('custom_css')
@parent
@endsection
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
				<h5>Data Mahasiswa</h5>
				<div class="ibox-tools">
					
					<button onclick="location.href='{{ route("mahasiswa.create") }}'" class="btn btn-success">Tambah Mahasiswa</button>

				</div>
			</div>
			<div class="ibox-content">
				<table id="table-mahasiswa" class="table table-striped table-bordered table-hover" >
					<thead>
						<tr>
							<th>Nama</th>
							<th>NIM</th>
							<th>Kelas</th>
							<th>Prodi</th>
							<th>Tahun Masuk</th>
							<th>JK</th>
							<th>No Telp</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@php
						$no = 1;
						@endphp
						@foreach ($mahasiswas as $mahasiswa)
						<tr>
							<td>{{ $mahasiswa->nama_mhs }}</td>
							<td>{{ $mahasiswa->nim }}</td>
							<td>{{ $mahasiswa->jenis_kelas }}</td>
							<td>{{ $mahasiswa->program_studi }}</td>
							<td>{{ $mahasiswa->tahun_masuk }}</td>
							<td>{{ $mahasiswa->jenis_kelamin }}</td>
							<td>{{ $mahasiswa->no_hp }}</td>
							<td class="text-center" width="1%" style="white-space: nowrap">
								
								<a onclick="show_modal('{{ $mahasiswa->id }}')" class="btn btn-info">Detail</a>
								<a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-primary">Edit</a>
							</td>

						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
@include('mahasiswa.modal_mahasiswa_detail')
@endsection
@section('custom_js')
<script>
	let table_mahasiswa = $("#table-mahasiswa").DataTable({
		dom:  '<"html5buttons"B>lfrtip',

		buttons: [
		
		{extend: 'print',
		customize: function (win){
			wwin = win;

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

			$trHead = $(win.document.body).find('table').find('thead').find("tr:first").find("th:first");
			$("<td/>", {
				text: 'No',
			})
			.css({
				'font-weight': 'bold',
				'width' : '1%',
				'white-space' : 'nowrap',
			}).insertBefore($trHead);

			$trBody = $(win.document.body).find('table').find('tbody').find("tr");
			$.each($trBody, function(index, val) {
				$("<td/>", {
					text: (index + 1),
				})
				.css({
					'width' : '1%',
					'white-space' : 'nowrap',
				})
				.insertBefore($(val).find("td:first"));
			});
			
		},
		pageSize : "A4",
		orientation : 'portrait',
		title : function() {
			return `Data Mahasiswa`;
		},
		exportOptions : {
			columns: [ 0, 1,2,3,4,5,6 ]
		}
	},
	]
});
</script>
@endsection