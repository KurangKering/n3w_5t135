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
        <h5>Data Pembayaran Semester</h5>
        <div class="ibox-tools">
          <button onclick="location.href='{{ route('pembayaran_semester.create') }}'" class="btn btn-success">Tambah Transaksi</button>
        </div>
      </div>
      <div class="ibox-content">

        <div class="table-responsive">
          <table id="table-pembayaran-semester" class="table table-striped table-bordered" >
            <thead>
              <tr>
               <th>Kode Transaksi</th>
               <th>Nama</th>
               <th>NIRM</th>
               <th>Prodi</th>
               <th>Angkatan</th>
               <th>Semester</th>
               <th>Tanggal</th>
               <th>Jumlah Bayar</th>
               <th>Status</th>
               <th class="text-center">Aksi</th>
             </tr>
           </thead>
           <tbody>
             @foreach ($pembayaran_det as $index => $detail)
             <tr>
               <td width="1%" class="text-center">{{ $detail->transaksi_id }}</td>
               <td>{{ $detail->pembayaran_semester->mahasiswa->calon_mahasiswa->nama }}</td>
               <td>{{ $detail->pembayaran_semester->mahasiswa->nim }}</td>
               <td>{{ $detail->pembayaran_semester->mahasiswa->calon_mahasiswa->program_studi }}</td>
               <td>{{ $detail->pembayaran_semester->mahasiswa->calon_mahasiswa->tahun_masuk }}</td>
               <td>{{ $detail->pembayaran_semester->semester }}</td>

               <td width="15%" class="text-center">{{ indonesian_date($detail->tanggal_bayar, 'j F Y') }}</td>

               <td>{{ rupiah($detail->jumlah_bayar) }}</td>
               <td>{{ $detail->status }}</td>
               <td width="1%" style="white-space: nowrap"> 
                 <a target="_blank" href="{{ route('kwitansi.pembayaran_semester', $detail->id) }}" 
                  class="btn btn-info">
                  Print
                </a>

                <a href="{{ route('pembayaran_semester.edit', $detail->id) }}" 
                  class="btn btn-primary">
                  Edit
                </a>
                <a id="{{ $detail->id }}" 
                  class="btn-delete btn btn-warning">
                  Delete
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
             <th></th>
           </tr>
         </tfoot>
       </table>
     </div>

   </div>
 </div>
</div>
</div>
<div id="form-form"></div>
@endsection
@section('custom_js')

<script>
  $(document).ready(function() {

    let $table = $("#table-pembayaran-semester");
    let $th = $table.find("tfoot").find("th");
    $th.each(function(i, v) {

      if ((i + 1) == $th.length) {
        return false;
      }
      let title = $(this).text();
      console.log($(this));
      $(this).append($("<input>", {
        type : "text",
        class : 'form-control',
        placeholder : '...'
      })
      .css({
        width : "100%",
        "font-weight" : 'normal',
      })
      );
    })

    let dataTable = $table.DataTable({
      order : [],

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
      title : 'Data Pembayaran Semester',
      exportOptions : {
        columns: [ 0, 1,2,3,4,5,6,7,8 ]
      }
    },
    ]
  });

    dataTable.columns().every(function() {
      var that = this;
      $('input', this.footer()).on('keyup change', function(){
        if (that.search() !== this.value) {
          that
          .search(this.value)
          .draw();
        }
      })
    })
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
          'action' : '{{ route('pembayaran_semester.index') .'/' }}' + id,
          'method' : 'post'
        }).
         append('@csrf').
         append('{{ method_field('DELETE') }}')
         newForm.appendTo($('#form-form'));
         newForm.submit();

         swal("Data Berhasil Di Hapus", {
          icon: "success",
          buttons : false,
          timer: 1000,
          
        });
       } 
     });
    });


  });
</script>
@endsection