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
        <h5>Data Pemasukan Lain</h5>
        <div class="ibox-tools">
          <button onclick="location.href='{{ route('pemasukan_lain.create') }}'" class="btn btn-success">Tambah Transaksi</button>
        </div>
      </div>
      <div class="ibox-content">

        <table id="table-pemasukan-lain" class="table table-striped table-bordered table-hover" >
          <thead>
            <tr>
             <th>Kode Transaksi</th>
             <th>Jenis</th>
             <th>Uraian</th>
             <th>Tanggal</th>
             <th>Jumlah Bayar</th>
             <th>Keterangan</th>
             <th>Lampiran</th>
             <th class="text-center">Aksi</th>
           </tr>
         </thead>
         <tbody>
           @foreach ($pemasukan_lains as $index => $pemasukan_lain)
           <tr class="odd gradeX">
            <td>{{ $pemasukan_lain->transaksi_id }}</td>
            <td>{{ $pemasukan_lain->jenis_bayar }}</td>
            <td>{{ $pemasukan_lain->uraian }}</td>
            <td>{{ $pemasukan_lain->tanggal_bayar }}</td>
            <td>{{ $pemasukan_lain->total_bayar }}</td>
            <td>{!! $pemasukan_lain->keterangan !!}</td>
            <td>
              @if ($pemasukan_lain->lampiran)
              <a target="_blank" href="{{ route('lampiran.pemasukan_lain', $pemasukan_lain->id) }}">Lihat</a>
              @endif
            </td>

            <td width="1%" style="white-space: nowrap">
              <a target="_blank" href="{{ route('kwitansi.pemasukan_lain', $pemasukan_lain->id) }}" class="btn btn-info">
                Print
              </a>
              <a href="{{ route('pemasukan_lain.edit', $pemasukan_lain->id) }}" class="btn btn-primary">
                Edit
              </a>
              <a id="{{ $pemasukan_lain->id }}" class="btn-delete btn btn-warning">
                Delete
              </a>
            </td>
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
  $(document).ready(function() {
    $('#table-pemasukan-lain').DataTable({

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
      },
      pageSize : "A4",
      orientation : 'portrait',
      title : 'Data Pemasukan Lain',
      exportOptions : {
        columns: [ 0, 1,2,3,4,5 ]
      }
    },
    ]
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

         var   newForm = jQuery('<form>', {
          'action' : '{{ route('pemasukan_lain.index') .'/' }}' + id,
          'method' : 'post'
        }).
         append('@csrf').
         append('{{ method_field('DELETE') }}')
         newForm.appendTo($('#form-form'));
         newForm.submit();

         swal("Data Berhasil Di Hapus", {
          icon: "success",
          timer: 1000,
          
        });
       } 
     });
    });
  });
</script>
@endsection