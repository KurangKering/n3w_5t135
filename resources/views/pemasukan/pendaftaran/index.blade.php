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
        <h5>Data Pendaftaran</h5>
        <div class="ibox-tools">
          <button onclick="location.href='{{ route('pendaftaran.create') }}'" class="btn btn-success">Tambah Pendaftaran</button>
        </div>
      </div>
      <div class="ibox-content">

        <table id="table-pendaftaran" class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
             <th>Kode Transaksi</th>
             <th>Nama</th>
             <th>NIRM</th>
             <th>Kelas</th>
             <th>Prodi</th>
             <th>Angkatan</th>
             <th>Tanggal</th>
             <th>Jumlah Bayar</th>
             <th class="text-center">Aksi</th>
           </tr>
         </thead>
         <tbody>

          @foreach ($pendaftarans as $index => $detail)

          <tr>
            <td>{{ $detail->transaksi->id }}</td>
            <td>{{ $detail->pendaftaran->mahasiswa->nama_mhs }}</td>
            <td>{{ $detail->pendaftaran->mahasiswa->nim }}</td>
            <td>{{ $detail->pendaftaran->mahasiswa->jenis_kelas }}</td>
            <td>{{ $detail->pendaftaran->mahasiswa->program_studi }}</td>
            <td>{{ $detail->pendaftaran->mahasiswa->tahun_masuk }}</td>
            <td>{{ indonesian_date($detail->tanggal_bayar) }}</td>
            <td>{{ rupiah($detail->bayar_pustaka + $detail->bayar_alma + $detail->bayar_pendaftaran) }}</td>
            <td width="1%" style="white-space: nowrap">
              <a target="_blank" href="{{ route('kwitansi.pendaftaran', $detail->id) }}" class="btn btn-info" title="">Print</a> 

              <a href="{{ route('pendaftaran.edit', $detail->id) }}" class="btn btn-primary">Edit</a>
              <a id="{{ $detail->id }}" class="btn-delete btn btn-warning btn-md">Delete</a></td>
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
<script>

  $(function() {
    let table =  $("#table-pendaftaran").DataTable({

      dom:  '<"html5buttons"B>lfrtip',
      buttons: [

      {extend: 'print',
      customize: function (win){
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
        .addClass('compact')
        .css('font-size', 'inherit');
        $trHead = $(win.document.body).find('table').find('thead').find("tr:first").find("th:first");
        $("<td/>", {
          text: 'No',
        })
        .css({
          'font-weight': 'bold',
          'width' : '1%',
          'white-space' : 'nowrap',
        }).insertBefore($trHead);

        $trBody = $(win.document.body).find('table').find('tbody').find("tr");
        $.each($trBody, function(index, val) {
          $("<td/>", {
            text: (index + 1),
          })
          .css({
            'width' : '1%',
            'white-space' : 'nowrap',
          })
          .insertBefore($(val).find("td:first"));
        });
      },
      pageSize : "A4",
      orientation : 'portrait',
      title : 'Data Pendaftaran',
      exportOptions : {
        columns: [ 0, 1,2,3,4,5,6,7 ]
      }
    },
    ]
  });
  });

  


  $('.btn-delete').click(function() {
    var id = $(this).attr('id');
    swal({
      title: "Hapus Data ?",
      text: "Yakin Ingin Menghapus Data Ini ?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {

        axios.post('{{ route('pendaftaran.index') .'/' }}' + id, {
          _method : 'DELETE',
          _token : '{{ csrf_token() }}',

        })
        .then(response => {
          swal({
            icon: "success",
            text : "Berhasil Menghapus Data",
            buttons : false,
            closeOnClickOutside : false,
            timer: 1000,

          })
          .then(x => {
            location.reload();
          })
          ;
        })
        .catch(err => {

        })

      } 
    });

  });
</script>
@endsection