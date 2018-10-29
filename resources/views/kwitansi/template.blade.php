<html>
<head><meta http-equiv=Content-Type content="text/html; charset=UTF-8">
	<style type="text/css">
	<!--
	span.cls_002{font-family:Times,serif;font-size:14.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
	div.cls_002{font-family:Times,serif;font-size:14.1px;color:rgb(0,0,0);font-weight:bold;font-style:normal;text-decoration: none}
	span.cls_003{font-family:Times,serif;font-size:12.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
	div.cls_003{font-family:Times,serif;font-size:12.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none}
	table tr td {
		font-family:Times,serif;font-size:12.1px;color:rgb(0,0,0);font-weight:normal;font-style:normal;text-decoration: none;
	}
	@page {
		margin: 0cm;
		size: 717px 283px;
	}
	-->

</style>
</head>
<body>
	<div style="position:absolute;left:50%;margin-left:-358px;top:0px;width:717px;height:283px;border-style:outset;overflow:hidden">
		<div style="position:absolute;left:0px;top:0px">
			<img src="{{ asset('images/background_kwitansi.jpg') }}" width=717 height=283></div>
			<div style="position:absolute;left:62px;top:22px" class="cls_002"><img src="{{ asset('images/logo.png') }}" style="width: 80px;height: 80px;" alt=""></div>
			<div style="position:absolute;left:269.69px;top:28.86px" class="cls_002"><span class="cls_002">KWITANSI PEMBAYARAN</span></div>
			<div style="position:absolute;left:487.87px;top:61.02px" class="cls_003"><span class="cls_003">No</span></div>
			<div style="position:absolute;left:546.31px;top:61.02px" class="cls_003"><span class="cls_003">:</span></div>
			<div style="position:absolute;left:555.31px;top:61.02px" class="cls_003">{{ $kwitansi->id_transaksi }}</div>
			<div style="position:absolute;left:487.87px;top:77.01px" class="cls_003"><span class="cls_003">Tanggal</span></div>
			<div style="position:absolute;left:546.31px;top:77.01px" class="cls_003"><span class="cls_003">:</span></div>
			<div style="position:absolute;left:555.31px;top:77.01px" class="cls_003">{{ indonesian_date($kwitansi->tanggal_bayar, 'j F Y')}}</div>
			<div style="position:absolute;left:53.64px;top:106.53px" class="cls_003"><span class="cls_003">Terima Dari</span></div>
			<div style="position:absolute;left:172.82px;top:106.53px" class="cls_003"><span class="cls_003">:</span></div>
			<div style="position:absolute;left:190.94px;top:106.53px" class="cls_003"><span class="cls_003">{{ $kwitansi->nama }}</span></div>
			<div style="position:absolute;left:53.64px;top:134.15px" class="cls_003"><span class="cls_003">Untuk Pembayaran</span></div>
			<div style="position:absolute;left:172.82px;top:134.15px" class="cls_003"><span class="cls_003">:</span></div>
			<div style="position:absolute;left:190.94px;top:134.15px" class="cls_003"><span class="cls_003">{{ $kwitansi->jenis_transaksi }}</span></div>
			<div style="position:absolute;left:53.64px;top:161.75px" class="cls_003"><span class="cls_003">Terbilang</span></div>
			<div style="position:absolute;left:172.82px;top:161.75px" class="cls_003"><span class="cls_003">:</span></div>
			<div style="position:absolute;left:190.94px;top:161.75px" class="cls_003"><span class="cls_003">{{ terbilang($kwitansi->jumlah_bayar) }}</span></div>
			<div style="position:absolute;left:75.86px;top:217.78px" class="cls_003"><span class="cls_003">{{ rupiah($kwitansi->jumlah_bayar) }}</span></div>

			<table style="position:absolute;left:375.87px;top:185.74px; width: 300px">
				
				<tr>
					<td style="text-align: center; width: 80px">Diterima</td>
					<td style="width: 40px"></td>
					<td style="text-align: center; width: 80px">Dibayar</td>
				</tr>
				<tr>
					<td style="height: 48px; text-align: center; vertical-align: bottom; text-decoration: underline;">{{ ucwords($kwitansi->nama_penerima) }}</td>
					<td style="height: 48px;"></td>
					<td style="height: 48px; text-align: center; vertical-align: bottom; text-decoration: underline;">{{ ucwords($kwitansi->nama_pembayar) }}</td>
				</tr>
			</table>

		</div>

	</body>
	</html>
