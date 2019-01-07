@extends('layouts.new_template')
@section('custom_css')
<style>
#table-semester tr td {
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
									<button id="btn-search"  data-toggle="modal" data-target="#myModal"  class="btn btn-outline-secondary" type="button"><span class="glyphicon glyphicon-search"></span></button>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-3">Program Studi</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="program_studi" >
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
								<label for="" class="control-label col-lg-3">Angkatan</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="angkatan">
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
		
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Data Pembayaran Semester</h5>
				
				
			</div>
			<div class="ibox-content">
				<table class="table table-bordered table-hover" id="table-semester">
					<thead>
						<tr>
							<th>Semester</th>
							<th>Transaksi ID</th>
							<th>Jumlah Bayar</th>
							<th>Tanggal Bayar</th>
							<th>Total Bayar</th>
							<th>Sisa Bayar</th>
							<th>Status</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="content-semester">

					</tbody>
				</table>
			</div>
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Form Pembayaran Semester</h5>
			</div>
			<div class="ibox-content">
				<form id="form-semester" = class="form-horizontal">
					@csrf
					<input type="hidden" name="mahasiswa_id">
					<div class="form-group">
						<label for="" class="control-label col-lg-2">Semester</label>
						<div class="col-lg-10">
							<input type="number" name="semester" class="form-control">
						</div>
					</div>
					
					<div class="form-group">
						<label for="" class="control-label col-lg-2">Jumlah Bayar</label>
						<div class="col-lg-10">
							<input type="number" name="jumlah_bayar" class="form-control">
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-2">Tanggal Pembayaran</label>
						<div class="col-lg-10">
							<input class="form-control" type="date"  value="{{ date('Y-m-d') }}" name="tanggal_bayar">
						</div>
						

					</div>
					
					
					<div class="text-center">
						<button id="btn-simpan" type="submit" class="btn btn-primary">Simpan</button>
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
	let biayaSemester = {{ Config::get('enums.biaya_semester') }};

	let $btnSimpan = $("#btn-simpan");
	let $lookup = $("#lookup");
	let $formSemester = $("#form-semester");
	let $errorArea = $("#error-area");
	let $content = $("#content-semester");

	//inputan 
	let inputID = $("input[name='mahasiswa_id']");
	let inputSemester = $("input[name='semester']");
	let inputJumlahBayar = $("input[name='jumlah_bayar']");
	let inputTglBayar = $("input[name='tanggal_bayar']");
	let inputStatus = $("input[name='status']");


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
		{"data": "calon_mahasiswa.nama"},
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

	$formSemester.submit(function(e) {
		e.preventDefault();
		$($btnSimpan).attr('disabled', true);
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
			$($btnSimpan).attr('disabled', false);

			return;

		}
		let formData = $formSemester.serialize();
		axios.post('{{ route('pembayaran_semester.store') }}', formData )
		.then(response => {
			res = response.data;
			if (res.success) {
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
						location.href= '{{ route('pembayaran_semester.index') }}';

					}

				})
			} else {
				swal({
					icon : 'warning',
					title : "Gagal",
					text : res.msg,
					timer : 1000,
					buttons : false,
					closeOnClickOutside: false,
				})
			}
			$($btnSimpan).attr('disabled', false);

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
			$($btnSimpan).attr('disabled', false);

		})
	})
	$lookup.find("tbody").on("click", "tr", function() {
		let dataMahasiswa = dataTable.row(this).data();
		set_data(dataMahasiswa);
		render(dataMahasiswa.id);

		$('#myModal').modal('hide');
	})

	var set_data = function(data)
	{
		var id = data.id;
		var nim = data.nim;
		var nama_mhs = data.calon_mahasiswa.nama;
		var program_studi = data.calon_mahasiswa.program_studi;
		var jenis_kelas = data.calon_mahasiswa.jenis_kelas;
		var tahun_angkatan = data.calon_mahasiswa.tahun_masuk;

		$('input[name="mahasiswa_id"]').val(id);
		$('#nim').val(nim);
		$('#nama_mhs').val(nama_mhs);
		$('#program_studi').val(program_studi);
		$('#jenis_kelas').val(jenis_kelas);
		$('#angkatan').val(tahun_angkatan);

	}

	function render(id)
	{
		swal({
			text : 'Tunggu',
			buttons : false,
			closeOnClickOutside: false,
		});
		axios.get("{{ url('mahasiswa/show_pembayaran_semester') . '/' }}" + id)
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
		if (datas.pembayaran_semester.length > 0) {
			$.each(datas.pembayaran_semester, function(index, semester) {
				$.each(semester.pembayaran_semester_det, function(index2, detail) {
					let tr = $("<tr/>", {

					});
					if (index2 == 0) {

						tr.append($("<td/>", {
							text : semester.semester,
						})
						.css({
							'text-align': 'center'
						})
						.attr({
							rowspan: semester.pembayaran_semester_det.length,
						}))	
					}
					tr.append($("<td/>", {
						text : detail.transaksi_id,
					}))	
					tr.append($("<td/>", {
						text : detail.jumlah_bayar_manusia,
					}))	
					.append($("<td/>", {
						text : detail.tgl_bayar_manusia,
					}));

					if (index2 == 0) {
						tr.append($("<td/>", {
							text : semester.total_manusia,
						})
						.css({
							'text-align': 'center'
						})
						.attr({
							rowspan: semester.pembayaran_semester_det.length,
						}));
						tr.append($("<td/>", {
							text : semester.sisa_manusia,
						})
						.css({
							'text-align': 'center'
						})
						.attr({
							rowspan: semester.pembayaran_semester_det.length,
						}));
						tr.append($("<td/>", {
							text : semester.ket_bayar,
						})
						.css({
							'text-align': 'center'
						})
						.attr({
							rowspan: semester.pembayaran_semester_det.length,
						}));	
					}	
					
					tr.append($("<td/>", {

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
						window.open('{{ url('pemasukan/pembayaran_semester/') }}' + '\/' +detail.id+'/kwitansi'); 

					})
					)
					.append($("<button/>", {

						text : 'Update',
						class : 'btn btn-primary',

					})
					.click(function(e) {
						location.href='{{ url('pemasukan/pembayaran_semester') }}' + '\/' +detail.id+"/edit"; 

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

								var url = '{{ route('pembayaran_semester.index') }}' + '/'+ detail.id;
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

			});

		} else {
			$content.append($("<tr/>")
				.append($("<td/>", {
					text : 'Tidak ada Data',
					class : 'text-center'
				})
				.attr({
					colspan	: '8'
				})));
		}
	}

</script>
@endsection