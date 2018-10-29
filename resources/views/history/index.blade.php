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
				<h5>History</h5>
				<div class="ibox-tools">
					
				</div>
			</div>
			<div class="ibox-content">

				<table id="table-history" class="table table-striped table-bordered table-hover" >
					<thead>
						<tr>
							<th>Tanggal</th>
							<th>Pengguna</th>
							<th>Keterangan</th>

						</tr>
					</thead>
					<tbody>
						@foreach ($histories as $index => $history)
						<tr>
							<td>{{ indonesian_date($history->created_at, 'l, j F Y, H : i') }}</td>
							<td>{{ $history->nama }}</td>
							<td>{{ $history->subject }}</td>
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
<script type="text/javascript">
	$('#table-history').DataTable({
		"order": [[ 0, "desc" ]],
		
	});
</script>
@endsection