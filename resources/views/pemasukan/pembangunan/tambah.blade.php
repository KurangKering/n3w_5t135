@extends('layouts.new_template')
@section('custom_css')
<style>
#table-data  tr td {
	vertical-align: middle;
}
</style>
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
		<div id="error-area">
			
		</div>
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
									<input readonly class="form-control" id="nim" >
								</div>
								<div class="col-lg-1">
									<button id="btn-search" class="btn btn-outline-secondary" type="button"><span class="glyphicon glyphicon-search"></span></button>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Program Studi</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="program_studi" >
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Angkatan</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="angkatan">
								</div>
							</div>
						</div>
						<div class="col-lg-6">
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Nama Mahasiswa</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="nama_mhs" >
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Kelas</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="jenis_kelas">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Data Pembayaran Pembangunan</h5>
			</div>
			<div class="ibox-content">
				<table class="table table-bordered table-hover" id="table-data">
					<thead>
						<tr>
							<th  width="1%" nowrap style="vertical-align: middle; text-align: center">Transaksi ID</th>
							<th  style="vertical-align: middle; text-align: center">Tanggal Bayar</th>
							<th  class="text-center" style="vertical-align: middle">Jumlah Bayar</th>
							<th  class="text-center" style="vertical-align: middle">Action</th>
						</tr>
					
					</thead>
					<tbody id="content-pembangunan">
					</tbody> 
				</table>
			</div>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Form Pembayaran Pembangunan</h5>
				<div class="ibox-tools">

				</div>
				<form method="POST" id="form-pembangunan" class="form-horizontal">
					<div class="ibox-content">
						@csrf
						<input type="hidden" name="mahasiswa_id" value="">
						<div class="form-group">
							<label class="control-label col-lg-2">Jumlah Bayar</label>
							<div class="col-lg-10">
								<input class="form-control" type="number" name="jumlah_bayar">
							</div>
						</div>
						

						<div class="form-group">
							<label class="control-label col-lg-2">Tanggal Pembayaran</label>
							<div class="col-lg-6">
								<input class="form-control" type="date"  value="{{ date('Y-m-d') }}" name="tanggal_bayar" id="example-date-input">
							</div>
							<label class="control-label col-lg-2">Status</label>
							<div class="col-lg-2">
								<select class="form-control" name="ket_bayar">
									@foreach (\Config::get('enums.status_bayar') as $k => $v)
									<option value="{{ $v }}">{{ $v }}</option>
									@endforeach
								</select>
							</div>

						</div>

						<div class="text-center">
							<button id="btn-simpan" type="button" class="btn btn-primary btn-lg">Selesai</button>
						</div>
					</div>
				</form>
			</div>
		</div>

	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:800px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Data Mahasiswa</h4>
			</div>
			<div class="modal-body">
				<table id="lookup" class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>NIM</th>
							<th>Nama Mahasiswa</th>
						</tr>
					</thead>
					<tbody>

					</tbody>
				</table>  
			</div>
		</div>
	</div>
</div>
@endsection
@section('custom_js')
<script type="text/javascript">
	//variable 
	//
	let container = {};

	let $content = $("#content-pembangunan");
	let $lookup = $("#lookup");
	let $btnSimpan = $("#btn-simpan");
	let $btnSearch = $("#btn-search");
	let $formPembangunan = $("#form-pembangunan");
	let $errorArea = $("#error-area");
	//inputan 
	let inputID = $("input[name='mahasiswa_id']");
	let inputJumlahBayar = $("input[name='jumlah_bayar']");
	let inputTglBayar = $("input[name='tanggal_bayar']");
	let inputKetBayar = $("input[name='ket_bayar']");
	let dataTable = $lookup.DataTable({ 
		"bAutoWidth": false ,
		"processing": true, 
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": '{{ url('jsonDataTables/semua_mahasiswa') }}',
			"type": "get",
			
		},
		"columns": [
		{"data": "nim", "orderable" : false},
		{"data": "nama_mhs"},
		],
		'columnDefs': [
		{
			"targets": 0,
			"className": "text-center",
			"width" : "5%",
			"orderable" : false,
		},
		{
			"targets": 1,
			"width" : "40%"
		},
		]
	});

	function render(id)
	{
		swal({
			text : 'Tunggu',
			buttons : false,
			closeOnClickOutside: false,
		});
		axios.get("{{ route('mahasiswa.index') . '/' }}" + id)
		.then(response => {
			res = response.data;
			populateTable(res);
			swal.close();
		})
		.catch(err => {
			swal.close();
			
		})
	}

	function populateTable(datas)
	{
		$content.html("");
		if (datas.pembangunan) {
			$.each(datas.pembangunan.pembangunan_det, function(index, pemb) {
				let tr = $("<tr/>", {

				});
				tr.append($("<td/>", {
					text : pemb.transaksi_id,
				}))
				.append($("<td/>", {
					text : pemb.tgl_bayar_manusia,
				}))
				.append($("<td/>", {
					text : pemb.jumlah_bayar_manusia
				}))
				.append($("<td/>", {

				})
				.css({
					width : '1%',
					'white-space' : 'nowrap',
				})
				.append($("<button/>", {

					text : 'Print',
					class : 'btn btn-info',

				})
				.click(function(e) {
					window.open('{{ url('pemasukan/pembangunan/') }}' + '\/' +pemb.id+'/kwitansi'); 

				})
				)
				.append($("<button/>", {

					text : 'Update',
					class : 'btn btn-primary',

				})
				.click(function(e) {
					location.href='{{ url('pemasukan/pembangunan') }}' + '\/' +pemb.id+"/edit"; 

				})
				)
				.append($("<button/>", {
					text : 'Delete',
					class : 'btn btn-warning'
				})
				.click(function(e) {

					swal({
						icon : 'warning',
						title : 'Yakin ?',
						text : 'Yakin ingin menghapus data ini ?',
						buttons : true,
						closeOnClickOutside : false,

					})
					.then(clicked => {
						if (clicked) {
							
							var url = '{{ route('pembangunan.index') }}' + '/'+ pemb.id;
							axios.post(url, {
								_method : "DELETE",
								_token : '{{ csrf_token() }}',
							})
							.then(response => {
								render(datas.id);
							})
							.catch(err => {
								swal.close();

							});
						}
					})
				})
				)
				);
				$content.append(tr);
			});
			$content.append($("<tr/>")
				.append($("<td/>", {
					text : 'Total'
				})
				.css({
					'font-weight': 'bold',
					'text-align': 'right'
				})
				.attr({
					colspan: '2',
				})

				)
				.append($("<td/>", {
					text : datas.pembangunan.total
				}))
				);	

			$content.append($("<tr/>")
				.append($("<td/>", {
					text : 'Status'
				})
				.css({
					'font-weight': 'bold',
					'text-align': 'right'
				})
				.attr({
					colspan: '2',
				})

				)
				.append($("<td/>", {
					text : datas.pembangunan.ket_bayar
				}))
				);	
		} else {
			$content.append($("<tr/>")
				.append($("<td/>", {
					text : 'Tidak ada Data',
					class : 'text-center'
				})
				.attr({
					colspan	: '7'
				})));
		}
	}


	var set_data = function(data)
	{
		var id = data.id;
		var nim = data.nim;
		var nama_mhs = data.nama_mhs;
		var program_studi = data.program_studi;
		var jenis_kelas = data.jenis_kelas;
		var tahun_angkatan = data.tahun_masuk;

		$('input[name="mahasiswa_id"]').val(id);
		$('#nim').val(nim);
		$('#nama_mhs').val(nama_mhs);
		$('#program_studi').val(program_studi);
		$('#jenis_kelas').val(jenis_kelas);
		$('#angkatan').val(tahun_angkatan);

	}

	$lookup.find("tbody").on("click", "tr", function() {
		

		let thisRow = this;
		let dataMahasiswa = dataTable.row(this).data();
		set_data(dataMahasiswa);
		render(dataMahasiswa.id);

		$('#myModal').modal('hide');
		
		
		
	})

	$btnSearch.click(function(event) {
		let modal = $("#myModal");
		modal.modal("show");
	});
	
	$btnSimpan.click(function(e) {
		$(this).attr('disabled', true);
		$errorArea.html("");
		let id = inputID.val();
		if (!id) {
			swal({
				icon : 'warning',
				title : 'Gagal',
				text : 'Silahkan Pilih Mahaiswa',
				timer : 1000,
				buttons : false,
				closeOnClickOutside: false

			})
			$(this).attr('disabled', false);

			return;

		}
		
		let formData = $formPembangunan.serialize();
		axios.post('{{ route('pembangunan.store') }}', formData )
		.then(response => {
			swal({
				icon : 'success',
				title : "Sukses",
				text : "Transaksi berhasil",
				buttons : {
					lagi : {
						text : 'Tetap Disini',
						className : 'btn btn-primary'
					},
					kembali : {
						className : 'btn btn-info'
					}
				},
				closeOnClickOutside: false,
			})
			.then(clicked => {
				if (clicked == 'lagi') {
					var nim = $("#nim").val();
					render(id);
				} else if (clicked == 'kembali')
				{
					location.href= '{{ route('pembangunan.index') }}';

				}

			})
			$(this).attr('disabled', false);

		})
		.catch(err => {
			errors = err.response.data.errors;
			list = '';
			$.each(errors, function(index, val) {
				list += "<li>" + val + "</li>";
			});
			contentErr = `
			<div class="alert alert-danger">

			<strong>Whoops!</strong> Ada Kesalahan Dalam Input Data.<br><br>

			<ul>
			`+list+`
			</ul>

			</div>`;

			$errorArea.html(contentErr);
			$("html, body").animate({scrollTop : $errorArea.offset().top}, 'fast');
			$(this).attr('disabled', false);

		})
	})

	

</script>
@endsection