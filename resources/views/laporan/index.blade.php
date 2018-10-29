@extends('layouts.new_template')
@section('custom_css')
<style type="text/css" media="screen">
td, th {
	text-align: center;
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
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5>Data Pengeluaran Lain</h5>
				<div class="ibox-tools">
					
				</div>
			</div>
			<div class="ibox-content">

				<form class="form-inline" method="GET" >
					<button id="btn-semua" type="button" class="btn-action btn btn-default">Semua</button>
					<button id="btn-filter" type="button" class="btn-action btn btn-default">Filter</button>
					<button type="submit" class="btn btn-default" style="float: right" >Submit</button>

					<div style="float:right; display: none" id="div-action">
					</div>


				</form>

			</div>
			<div class="ibox-content">
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
						@foreach ($transaksis as $index => $transaksi )
						@php
						$jenis_lain = '';
						if (isset($transaksi->jenis_lain))
							$jenis_lain = " ($transaksi->jenis_lain)";
						@endphp
						<tr>
							<td>{{ $transaksi->transaksi_id}}</td>
							<td>{{ in_array($transaksi->jenis_transaksi, \Config::get('enums.pemasukan')) ? $transaksi->jenis_transaksi . $jenis_lain : '-' }}</td>
							<td>{{ in_array($transaksi->jenis_transaksi, \Config::get('enums.pengeluaran')) ? $transaksi->jenis_transaksi . $jenis_lain : '-' }}</td>

							<td>{{ indonesian_date($transaksi->tanggal_bayar) }}</td>
							<td>{{ rupiah($transaksi->total_bayar) }}</td>
						</tr>
						@endforeach

					</tbody>
				</table>
			</div>
			<div class="ibox-content">
				<div class="panel-body">
					<style type="text/css" media="screen">

					#statistik td {
						text-align: left;
					}
					#statistik th {
						text-align: left;
					}
					#statistik {
						width: auto;
						margin-right: 0px;
						margin-left: auto;
					}
				</style>

				<table id="statistik" class="table" nowrap>
					<colgroup>
						<col style="width:50%"/>
						<col style="width:50%"/>
					</colgroup>
					<tr>
						<th>Pemasukan</th>
						<td id="val-pemasukan">{{ rupiah($total['pemasukan']) }}</td>
					</tr>
					<tr>
						<th>Pengeluaran</th>
						<td id="val-pengeluaran">{{ rupiah($total['pengeluaran']) }}</td>
					</tr>
					<tr style="border-top: solid 2px" class="{{ $total['seluruhnya'] < 0 ? 'bg-danger' : 'bg-primary' }}">
						<th>Total</th>
						<td id="val-seluruhnya">{{ rupiah($total['seluruhnya']) }}</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
</div>
<div id="form-form"></div>
@endsection
@section('custom_js')
<script type="text/javascript">
	from = "{{ $from }}";
	end = "{{ $end }}";

	$('#table-laporan').DataTable({
		"order": [[ 0, "desc" ]],
		"searching": false,
		"lengthChange": false,
		dom:  '<"html5buttons"B>lfrtip',
		buttons: [

		{extend: 'print',
		customize: function (win){
			let $pemasukan = $('#val-pemasukan');
			let $pengeluaran = $('#val-pengeluaran');
			let $seluruhnya = $('#val-seluruhnya');

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
			.find('tbody')
			.append($("<tr/>")
				.append($("<td/>", {
					text : 'Pemasukan',

				})
				.css({
					'text-align' : 'right',
					'font-weight' : 'bold',
				})
				.attr({
					'colspan' : 4
				}))
				.append($("<td/>", {
					text : $pemasukan.text(),
				})))
			.append($("<tr/>")
				.append($("<td/>", {
					text : 'Pengeluaran',

				})
				.css({
					'text-align' : 'right',
					'font-weight' : 'bold',
				})
				.attr({
					'colspan' : 4
				}))
				.append($("<td/>", {
					text : $pengeluaran.text(),
				})))
			.append($("<tr/>")
				.append($("<td/>", {
					text : 'Total',

				})
				.css({
					'text-align' : 'right',
					'font-weight' : 'bold',
				})
				.attr({
					'colspan' : 4
				}))
				.append($("<td/>", {
					text : $seluruhnya.text(),
				})));

			$(win.document.body).find('table')
			.addClass('compact')
			.css('font-size', 'inherit');
		},
		pageSize : "A4",
		orientation : 'portrait',
		title : 'Laporan Keuangan',
		exportOptions : {
			columns: [ 0, 1,2,3,4 ]
		}
	},
	]
});
	$('.btn-action').click(function(e) {
		$('.btn-action').removeClass('btn-success');
		$(this).addClass('btn-success');
		btnType =  $(this).attr('id');
		if (btnType == 'btn-semua')
		{

			$('#div-action').html('');

			$('#div-action').hide();
		} else
		if (btnType == 'btn-filter')
		{
			$('#div-action').html(generateInputActions());
			$('#filterMulai').val(from);
			$('#filterSampai').val(end);
			$('#div-action').show();
		}
	});

	if (from != '' || end != '') 
	{
		$('#btn-filter').trigger('click');
	}

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