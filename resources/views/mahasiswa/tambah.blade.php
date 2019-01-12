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
		<div id="error-area">
			
		</div>
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Tambah Mahasiswa</h5>
				<div class="ibox-tools">
					
				</div>
			</div>
			<form class="form-horizontal" id="form-mahasiswa" method="POST" action="{{ route('mahasiswa.store') }}">

				<div class="row">
					<div class="col-lg-8">
						<div class="ibox-content">

							
							@csrf
							<div class="form-group">
								<label for="" class="control-label col-lg-2">NISN</label>
								<div class="col-lg-8">
									<input readonly class="form-control" id="nisn" name="nisn" value="{{ old('nisn') }}" >
								</div>
								<div class="col-lg-2">
									<button id="btn-search" class="btn btn-outline-secondary" type="button"><span class="glyphicon glyphicon-search"></span></button>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">Nama</label>
								<div class="col-lg-10">
									<p class="form-control-static"><span id="nama">-</span></p>
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">Program Studi</label>
								<div class="col-lg-10">
									<p class="form-control-static"><span id="program_studi">-</span></p>
									
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">Tahun Masuk</label>
								<div class="col-lg-10">
									<p class="form-control-static"><span id="tahun_masuk">-</span></p>
									
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">Tempat Lahir</label>
								<div class="col-lg-10">
									<p class="form-control-static"><span id="tempat_lahir">-</span></p>
									
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">Tanggal Lahir</label>
								<div class="col-lg-10">
									<p class="form-control-static"><span id="tanggal_lahir">-</span></p>
									
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">Jenis Kelamin</label>
								<div class="col-lg-10">
									
									<p class="form-control-static"><span id="jenis_kelamin">-</span></p>

								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">Agama</label>
								<div class="col-lg-10">
									<p class="form-control-static"><span id="agama">-</span></p>
									
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">Asal Sekolah</label>
								<div class="col-lg-10">
									<p class="form-control-static"><span id="asal_sekolah">-</span></p>
									
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">Alamat</label>
								<div class="col-lg-10">
									<p class="form-control-static"><span id="alamat">-</span></p>
									
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">No Hp</label>
								<div class="col-lg-10">
									<p class="form-control-static"><span id="no_hp">-</span></p>
									
								</div>
							</div>
							<div class="form-group">
								<label for="" class="control-label col-lg-2">Email</label>
								<div class="col-lg-10">
									<p class="form-control-static"><span id="email">-</span></p>
									
								</div>
							</div>
							


						</div>
					</div>
					<div class="col-lg-4">
						<div class="ibox-content">
							<div class="form-group">
								<label for="" class="control-label col-lg-2">NIM</label>
								<div class="col-lg-10">
									<input  class="form-control" name="nim" id="nim" value="{{ old("email") }}">
								</div>
							</div>
							<div class="text-center">
								<button type="submit"  id="btn-submit" class="btn btn-primary btn-block">Tambah</button>
							</div>
						</div>
					</div>
				</div>
			</form>

			<div class="ibox-content">
				
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width:800px">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Data Calon Mahasiswa</h4>
			</div>
			<div class="modal-body">
				<table id="lookup" class="table table-bordered table-hover table-striped">
					<thead>
						<tr>
							<th>NISN</th>
							<th>Nama Calon Mahasiswa</th>
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
<script>
	let $btnSearch = $("#btn-search");
	let $btnSubmit = $("#btn-submit");
	let $lookup = $("#lookup");
	let $formMahasiswa = $("#form-mahasiswa");
	let $errorArea = $("#error-area");

	let dataTable = $lookup.DataTable({ 
		"bAutoWidth": false ,
		"processing": true, 
		"serverSide": true, 
		"order": [], 
		"ajax": {
			"url": '{{ url('jsonDataTables/semua_calon_mahasiswa_belum') }}',
			"type": "get",
			
		},
		"columns": [
		{"data": "nisn", "orderable" : false},
		{"data": "nama"},
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
	$btnSearch.click(function(event) {
		let modal = $("#myModal");
		dataTable.ajax.reload();
		modal.modal("show");
	});
	$lookup.find("tbody").on("click", "tr", function() {
		

		let thisRow = this;
		let dataCalon = dataTable.row(this).data();
		console.log(dataCalon);
		set_data(dataCalon);
		// render(dataMahasiswa.id);

		$('#myModal').modal('hide');
		
		
		
	})

	function set_data(data)
	{
		$("#nisn").val(data.nisn);
		$("#nama").text(data.nama);
		$("#program_studi").text(data.program_studi);
		$("#tahun_masuk").text(data.tahun_masuk);
		$("#tempat_lahir").text(data.tempat_lahir);
		$("#tanggal_lahir").text(data.tanggal_lahir);
		$("#jenis_kelamin").text(data.jenis_kelamin);
		$("#agama").text(data.agama);
		$("#asal_sekolah").text(data.asal_sekolah);
		$("#alamat").text(data.alamat);
		$("#no_hp").text(data.no_hp);
		$("#email").text(data.email);

	}

	$formMahasiswa.submit( function(e) {
		e.preventDefault();
		$btnSubmit.attr('disabled', true);

		let formData = $(this).serialize();
		let url = $(this).attr('action');
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
			}
			else {
				swal({
					icon : 'success',
					title : "Sukses",
					text : "Berhasil Menambah Data Mahasiswa",
					timer : 1500,
					buttons : false,
					closeOnClickOutside: false,
				})
				.then(() => {
					location.href ="{{ route('mahasiswa.index') }}";
				})
			}
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

		})
		.finally(() => {
			$btnSubmit.attr('disabled', false);

		})
	})
</script>
@endsection