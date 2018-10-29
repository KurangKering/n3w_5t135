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
				<h5>Data Pembayaran Gaji</h5>
				<div class="ibox-tools">
					<button onclick="location.href='{{ route('pembayaran_gaji.create') }}'" class="btn btn-success">Tambah Transaksi</button>
				</div>
			</div>
			<div class="ibox-content">

				<table id="table-pembayaran-gaji" class="table table-striped table-bordered table-hover" >
					<thead>
						<tr>
							<th>Kode Transaksi</th>
							<th>NIDN</th>
							<th>Nama</th>
							<th>Tanggal</th>
							<th>Jumlah Gaji</th>
							<th>Lampiran</th>
							<th class="text-center">Aksi</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($pembayaran_gajis as $index => $pembayaran_gaji)
						<tr>
							<td>{{ $pembayaran_gaji->transaksi_id }}</td>
							<td>{{ $pembayaran_gaji->pegawai->nip }}</td>
							<td>{{ $pembayaran_gaji->pegawai->nama_pegawai }}</td>
							<td>{{ indonesian_date($pembayaran_gaji->tanggal_bayar) }}</td>
							<td>{{ rupiah($pembayaran_gaji->jumlah_gaji) }}</td>
							<td>
								@if ($pembayaran_gaji->lampiran)
								<a target="_blank" href="{{ route('lampiran.pembayaran_gaji', $pembayaran_gaji->id) }}" title="">Lihat</a>
								@endif
							</td>

							<td width="1%" style="white-space: nowrap">
								<a target="_blank" href="{{ route('kwitansi.pembayaran_gaji', $pembayaran_gaji->id) }}" class="btn btn-info">
									Print
								</a>

							</a>
							<a href="{{ route('pembayaran_gaji.edit', $pembayaran_gaji->id) }}" class="btn btn-primary">
								Edit
							</a>
							<a id="{{ $pembayaran_gaji->id }}" class="btn-delete btn btn-warning">
								Delete
							</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>

		</div>
	</div>
</div>
</div>
<div id="form-form"></div>
@endsection
@section('custom_js')
<script>

	$(document).ready(function() {
		$('#table-pembayaran-gaji').DataTable({
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
			title : 'Data Pembayaran Gaji',
			exportOptions : {
				columns: [ 0, 1,2,3,4 ]
			}
		},
		]
	});

		$('.btn-delete').click(function() {
			var id = $(this).attr('id');
			swal({
				title: "Hapus Data ?",
				text: "Yakin Ingin Menghapus Data Ini ?",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {

					var   newForm = jQuery('<form>', {
						'action' : '{{ route('pembayaran_gaji.index') .'/' }}' + id,
						'method' : 'post'
					}).
					append('@csrf').
					append('{{ method_field('DELETE') }}')
					newForm.appendTo($('#form-form'));
					newForm.submit();

					swal("Data Berhasil Di Hapus", {
						icon: "success",
						timer: 1000,

					});
				} 
			});
		});
	});

</script>
@endsection