<!doctype html>
<html>
<head>
	<style>
	@page {
		margin: 0cm;
		size: 717px 283px;
	}
	body {
		margin: 0;
		padding: 0;
		font-family: 'Times New Roman' ;
		letter-spacing: 0.5px;
	}
	.wrapper {
		border: 1px solid;
		width: 717px;
		height: 283px;
	}
	header {
		overflow: hidden;
		height: 82px;
		margin: 0 10px;
	}
	
	.first {
		width: 30%;
		float: left;
		text-align: center;

	}
	.first img {
		width: 80px;
		height: 80px;	
	}
	.second {
		width: 40%;
		float: left;


	}
	.second h1 {
		margin-top: 20px;
		font-size: 18px;
		text-align: center;
		text-transform: uppercase;
	}
	.third {
		width: 30%;
		float: left;
		font-size: 12px;
	}
	.third table {
		margin-top: 20px;
	}
	.third table th, .third table td {
		text-align: left
	}

	section {
		border-bottom: 1px outline;
		margin: 0 10px;
	}
	section table {
	width: 100%;
	}
	section th {
		width: 20%;
		padding: 5px 20px;
	}

	section th, section td {
		text-align: left;
	}
	section td {
		
	}
	section td:nth-child(2) {
		width: 1%;
	}
	section td:nth-child(3) {
		border-bottom: 1px dotted;
		: 0;
	}
	footer {
		margin: 0 10px;
		min-height: 100px;
	}

	footer .numeric {
		width: 39%;
		height: 100px;
		float: left;
		text-align: center;
	}

	footer .rectangle {
		margin: 15px 10px 10px;
		height: 80px;
		border: 1px solid;
		border-radius: 28px;

	}
	.rectangle p {
		margin-top: 40px;
	}	
	footer .ttd {
		margin: 0 2.5%;

		width: 55%;
		float: left;
		text-align: center;

	}

	.ttd table {
		width: 100%;
	}
	.ttd table th {
		height: 64px;
		width: 50%;
	}
	.ttd table th, .ttd table td {
		text-align: center;

		vertical-align: top;

	}

</style>

</head>
<body>
	<div class="wrapper">
		
		<header>
			<div class="first">
				<img src="{{ asset('images/logo.png') }}" alt="">
				
			</div>
			<div class="second">
				<h1>kwitansi pembayaran</h1>
				
			</div>
			<div class="third">
				<table>
					<tr>
						<th>No</th>
						<td>:</td>
						<td>{{ $kwitansi->id_transaksi }}</td>
					</tr>
					<tr>
						<th>Tanggal</th>
						<td>:</td>
						<td>{{ indonesian_date($kwitansi->tanggal_bayar, 'j F Y')}}</td>
					</tr>
				</table>
			</div>
			
			

		</header>
		<section>
			<table>
				<tr>
					<th>Terima Dari</th>
					<td>:</td>
					<td>{{ $kwitansi->nama }}</td>
				</tr>
				<tr>
					<th>Untuk</th>
					<td>:</td>
					<td>{{ \Config::get('enums.jenis_transaksi')[$kwitansi->jenis_transaksi][$kwitansi->detail_transaksi] }}</td>
				</tr>
				<tr>
					<th>Terbilang</th>
					<td>:</td>
					<td>{{ terbilang($kwitansi->jumlah_bayar) }}</td>
				</tr>
			</table>
		</section>
		<footer>
			<div class="numeric">
				<div class="rectangle">
					<p>{{ rupiah($kwitansi->jumlah_bayar) }}</p>
				</div>
			</div>
			<div class="ttd">
				<table>
					<tr>
						<th>Diterima</th>
						<th>Dibayar</th>
					</tr>
					<tr>
						<td>{{ ucwords($kwitansi->nama_penerima) }}</td>
						<td>{{ ucwords($kwitansi->nama_pembayar) }}</td>
					</tr>
				</table>
			</div>

		</footer>

	</div>
	<script>
		window.print();
	</script>
</body>
</html>
