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
				<h5>Form Ubah Pengeluaran</h5>
				<div class="ibox-tools">
					
				</div>
				<form method="POST" class="form-horizontal" action="{{ route('pengeluaran_lain.update', $pengeluaran_lain->id) }}" enctype="multipart/form-data">
					@csrf
					{{method_field("PATCH")}}
					<div class="ibox-content">
						<div class="form-group">
							<label class="control-label col-lg-2">Dari</label>
							<div class="col-lg-10">
								<input type="text" class="form-control" name="dari" id="dari" value="{{$pengeluaran_lain->dari}}">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label col-lg-2">Jenis Pembayaran</label>
							<div class="col-lg-10">
								<select class="form-control" name="jenis_bayar">
									@foreach (Config::get('enums.jenis_lain') as $index => $jenis_lain)
									@php ($selected = $jenis_lain == $pengeluaran_lain->jenis_bayar ? 'selected' : '')
									@endphp
									<option {{ $selected }} value="{{ $jenis_lain }}">{{ $jenis_lain }}</option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Uraian</label>
							<div class="col-lg-10">
								<textarea class="form-control" id="exampleTextarea" rows="3" name="uraian">{{$pengeluaran_lain->uraian}}</textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Tanggal Pembayaran</label>
							<div class="col-lg-10">
								<input class="form-control" type="date"  id="example-date-input" name="tanggal_bayar" value="{{$pengeluaran_lain->tanggal_bayar}}">
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Total Bayar</label>
							<div class="col-lg-10">
								<input class="form-control" name="total_bayar" value="{{$pengeluaran_lain->total_bayar}}" >
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Keterangan</label>
							<div class="col-lg-10">
								<textarea class="form-control" id="exampleTextarea" rows="3" name="keterangan">{{$pengeluaran_lain->keterangan}}</textarea>
							</div>


						</div>
						<div class="form-group">
							<label class="control-label col-lg-2">Lampiran</label>
							<div class="col-lg-10">
								
								<input type="file" class="form-control-file" id="lampiran" aria-describedby="fileHelp" name="lampiran">
								<br>
								@if ($pengeluaran_lain->lampiran)
								<span><a target="_blank" href="{{ Storage::url($pengeluaran_lain->lampiran) }}" title="">Lihat Lampiran Sebelumnya</a></span>
								@endif

							</div>
						</div>


						<div class="text-center">
							<button type="submit" class="btn btn-primary btn-lg">Selesai</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection
@section('custom_js')
<script type="text/javascript">
	CKEDITOR.replace( 'keterangan', {
		height: '300px',
		extraPlugins: 'forms'
	});

</script>
@endsection