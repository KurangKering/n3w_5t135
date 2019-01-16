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
				<h5>Diagram</h5>
				<div class="ibox-tools">
					
				</div>
			</div>
			<div class="ibox-content">

				<form class="form-inline" id="form-diagram" >
					<button type="submit" class="btn btn-default" id="btn-submit" style="float: right" >Submit</button>

					<div style=" " id="div-action">

						<div id="inputs-action"> 
							<div class="form-group"> 
								<label for="filterMulai">Mulai Dari </label> 
								<input type="date" class="form-control" name="awal" required  id="filterMulai"> 
							</div> 
							<div class="form-group" style="margin-right: 20px;"> 
								<label for="pwd">Sampai </label> 
								<input type="date" class="form-control" name="akhir"  required id="filterSampai"> 
							</div> 
						</div>";
					</div>


				</form>

			</div>
			<div class="ibox-content">
				<div id="canvas-holder" class="hidden">
					<canvas id="chart-area"></canvas>
				</div>
			</div>
			
		</div>
	</div>
</div>
<div id="form-form"></div>
@endsection
@section('custom_js')
<script type="text/javascript" src="{{ asset('plugins/Chart.js/Chart.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/Chart.js/samples/utils.js') }}"></script>


<script>
	
	var randomScalingFactor = function() {
		var x = Math.round(Math.random() * 100);
		console.log(x);
		return x;
	};

	var config = {
		type: 'pie',
		data: {
			datasets: [{
				data: [
				100,
				100,
				],
				backgroundColor: [
				window.chartColors.blue,
				window.chartColors.red,
				],
				label: 'Dataset 1'
			}],
			labels: [
			'Pemasukan',
			'Pengeluaran',
			]
		},
		options: {
			responsive: true,
			title: {
				display: true,
				text: 'Chart.js Doughnut Chart'
			},
		}
	};

	window.onload = function() {
		var ctx = document.getElementById('chart-area').getContext('2d');
		window.myPie = new Chart(ctx, config);
	};

	$("#form-diagram").submit(function(event) {
		event.preventDefault();
		let start = $("#filterMulai").val();
		let end = $("#filterSampai").val();
		axios.post('{{ route('diagram.get_data') }}', {
			start : start,
			end : end,
			_token : '{{ csrf_token() }}',
		})
		.then(response => {
			resp = response.data;
			console.log(resp);
			let values = resp.data;
			let mulai = resp.mulai;
			let sampai = resp.sampai;
			let title = resp.title;
			let filled = resp.filled;
			if (!filled) {
				$('#canvas-holder').addClass('hidden');
				return;
			}
			config.data.datasets[0].data = values;
			config.options.title.text = title ;


			
			$('#canvas-holder').removeClass('hidden');
			window.myPie.update();
		})
		.catch( error => {

		})

	});


	// document.getElementById('form-diagram').addEventListener('submit', function() {

	// 	config.data.datasets.forEach(function(dataset) {
	// 		dataset.data = dataset.data.map(function() {
	// 			return randomScalingFactor();
	// 		});
	// 	});
	// 	$('#canvas-holder').removeClass('hidden');
	// 	window.myPie.update();
	// });

	
</script>
@endsection