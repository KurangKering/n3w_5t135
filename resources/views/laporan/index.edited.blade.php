@extends('layouts.template')
@section('custom_css')
<style type="text/css" media="screen">
td, th {
	text-align: center;
}

#statistik td {
	text-align: left;
}
#statistik th {
	text-align: ;
}
#statistik {
	width: auto;
	margin-right: 0px;
	margin-left: auto;
}
</style>
@endsection
@section('content')
<div class="header"> 

	<ol class="breadcrumb">
		<li><a href="#">Home</a></li>
		<li><a href="DataPembayaranMhs.html">Laporan Keuangan</a></li>
		<li class="active">Data</li>
	</ol> 

</div>

<div id="page-inner"> 

	<div class="row">
		<div class="col-md-12">
			<!-- Advanced Tables -->
			<div class="panel panel-default">
				<div class="panel-heading">

				</div>
				<div class="panel-body">
					<div>


						<form class="form-inline" method="GET" @submit.prevent="getLaporan(from,to)" >
							<button id="btn-semua" @click="addFilter=false,from='',to=''" type="button" class="btn-action btn btn-default">Semua</button>
							<button id="btn-filter" type="button" @click="addFilter=true" class="btn-action btn btn-default">Filter</button>
							<button type="submit" class="btn btn-default" style="float: right" >Submit</button>

							<div v-if="addFilter" style="float:right;" id="div-action">
								<div id="inputs-action"> 
									<div class="form-group"> 
										<label for="filterMulai">Mulai Dari </label> 
										<input type="date" v-model="from" class="form-control" name="awal" required id="filterMulai"> 
									</div> 
									<div class="form-group" style="margin-right: 20px;"> 
										<label for="pwd">Sampai </label> 
										<input type="date" v-model="to" class="form-control" name="akhir" required id="filterSampai"> 
									</div> 
								</div>
							</div>
						</form> 

					</div>
				</div>
				<template id="laporan">
					<div>
						<div class="panel-body">

							<div class="table-responsive">
								<table id="table-laporan" width="100%" class="table table-bordered table-striped" >
									<thead>
										<tr>
											<th rowspan="2" style="vertical-align: middle;">Idx</th>
											<th colspan="2">Jenis</th>
											<th rowspan="2" style="vertical-align: middle;">Tanggal</th>
											<th rowspan="2" style="vertical-align: middle;">Total Bayar</th>
										</tr>
										<tr>
											<th>Pemasukan</th>
											<th>pengeluaran</th>

										</tr>
									</thead>
									<tbody>
									{{-- 	@foreach ($transaksis as $index => $transaksi )
										<tr>
											<td>{{ $transaksi->transaksi_id}}</td>
											<td>{{ $transaksi->jenis_transaksi == 'Pemasukan' ? $transaksi->detail_transaksi : '-' }}</td>
											<td>{{ $transaksi->jenis_transaksi == 'Pengeluaran' ? $transaksi->detail_transaksi : '-' }}</td>

											<td>{{ indonesian_date($transaksi->tanggal_bayar) }}</td>
											<td>{{ rupiah($transaksi->total_bayar) }}</td>
										</tr>
										@endforeach --}}
										<tr v-for="lap in laporan">
											<td>@{{ lap.transaksi_id}}</td>
											<td>@{{ lap.jenis_transaksi }}</td>
											<td>@{{ lap.jenis_transaksi  }}</td>

											<td>@{{ lap.tanggal_bayar }}</td>
											<td>@{{ lap.total_bayar }}</td>
										</tr>
									</tbody>
								</table>
							</div>

						</div>
						<div class="panel-body">

							<table id="statistik" class="table" nowrap>
								<colgroup>
									<col style="width:50%"/>
									<col style="width:50%"/>
								</colgroup>
								<tr>
									<th>Pemasukan</th>
									<td>{{ rupiah($total['pemasukan']) }}</td>
								</tr>
								<tr>
									<th>Pengeluaran</th>
									<td>{{ rupiah($total['pengeluaran']) }}</td>
								</tr>
								<tr style="border-top: solid 2px" class="{{ $total['seluruhnya'] < 0 ? 'bg-danger' : 'bg-primary' }}">
									<th>Total</th>
									<td>{{ rupiah($total['seluruhnya']) }}</td>
								</tr>
							</table>
						</div>
					</div>
				</template>


			</div>
			<!--End Advanced Tables -->
		</div>
	</div>

</div>
<div id="form-form"></div>
@section('custom_js')
<script type="text/javascript">
	let vue = new Vue ({
		el : "#page-inner",
		data (){
			return {
				addFilter: false,
				from: '',
				to: '',
				haha: 'anuu',
				laporan: [],
			}
		},
		methods : {
			getLaporan(from, to) {
				var params  = "?awal="+from+"&akhir="+to;
				axios.get("{{ route('api_laporan') }}"+params)
				.then((response) => {
					this.laporan = response.data;
					// $('#table-laporan')
					
				});
			}
		},
		mounted() {
			this.getLaporan(this.from, this.to);
			

		}
	})
	




	// from = "{{ $from }}";
	// end = "{{ $end }}";

	// $('#table-laporan').DataTable({
		// 	"order": [[ 3, "desc" ]],
		// 	"searching": false,
		// 	"lengthChange": false,

		// });
	// $('.btn-action').click(function(e) {
		// 	$('.btn-action').removeClass('btn-success');
		// 	$(this).addClass('btn-success');
		// 	btnType =  $(this).attr('id');
		// 	if (btnType == 'btn-semua')
		// 	{

			// 		$('#div-action').html('');

			// 		$('#div-action').hide();
			// 	} else
			// 	if (btnType == 'btn-filter')
			// 	{
				// 		$('#div-action').html(generateInputActions());
				// 		$('#filterMulai').val(from);
				// 		$('#filterSampai').val(end);
				// 		$('#div-action').show();
				// 	}
				// });

	// if (from != '' || end != '') 
	// {
		// 	$('#btn-filter').trigger('click');
		// }






		function generateInputActions()
		{
			div = " \
			<div id=\"inputs-action\"> \
			<div class=\"form-group\"> \
			<label for=\"filterMulai\">Mulai Dari </label> \
			<input type=\"date\" class=\"form-control\" name=\"awal\" required id=\"filterMulai\"> \
			</div> \
			<div class=\"form-group\" style=\"margin-right: 20px;\"> \
			<label for=\"pwd\">Sampai </label> \
			<input type=\"date\" class=\"form-control\" name=\"akhir\" required id=\"filterSampai\"> \
			</div> \
			</div>";
			return div;
		}
	</script>
	@endsection
	@endsection