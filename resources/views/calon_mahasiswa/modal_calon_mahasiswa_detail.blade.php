 @section('custom-css')
 @parent
 <style type="text/css">
 td.total-title {
  text-align: right;
  font-weight: bold;
}
</style>
@endsection

<div id="modal-detail" style="display: none">
  <div class="box">

    <div class="box-body">

      <table class="table">
        <colgroup>
          <col width="30%">
          <col width="1%">
          <col width="89%">
        </colgroup>
        <tr>
          <th>Nama Mahasiswa</th>
          <td>:</td>
          <td><span id="nama"></span></td>
        </tr>
        <tr>
          <th>NISN</th>
          <td>:</td>
          <td><span id="nisn"></span></td>
        </tr>
        
        <tr>
          <th>Program Studi</th>
          <td>:</td>
          <td><span id="prodi"></span></td>
        </tr>
        <tr>
          <th>Angkatan</th>
          <td>:</td>
          <td><span id="angkatan"></span></td>
        </tr>
        <tr>
          <th>Jenis Kelamin</th>
          <td>:</td>
          <td><span id="jk"></span></td>
        </tr>
        <tr>
          <th>No Hp</th>
          <td>:</td>
          <td><span id="no_hp"></span></td>
        </tr>
      </table>
      
    </div>
    <div class="box-footer">
      
    </div>
  </div>
</div>

@section('custom_js')
@parent
<script>


  $("#modal-detail").iziModal({
    title: 'Detail Calon Mahasiswa',
    subtitle: '',
    headerColor: '#676a6c',
    //   background: null,
    //   theme: '',  
    //   icon: null,
    //   iconText: null,
    //   iconColor: '',
    //   rtl: false,
    width: 700,
    top: 30,
    //   bottom: null,
    //   borderBottom: true,
    padding: 10,
    //   radius: 3,
    zindex: 99999999,
    //   iframe: false,
    //   iframeHeight: 400,
    //   iframeURL: null,
    //   focusInput: true,
    //   group: '',
    //   loop: false,
    //   arrowKeys: true,
    //   navigateCaption: true,
    // navigateArrows: true, // Boolean, 'closeToModal', 'closeScreenEdge'
    // history: false,
    // restoreDefaultContent: false,
    // autoOpen: 0, // Boolean, Number
    bodyOverflow: true,
    // fullscreen: true,
       // openFullscreen: true,
    // closeOnEscape: true,
    // closeButton: true,
    // appendTo: 'body', // or false
    // appendToOverlay: 'body', // or false
    // overlay: true,
    // overlayClose: true,
    // overlayColor: 'rgba(0, 0, 0, 0.4)',
    // timeout: false,
    // timeoutProgressbar: false,
    // pauseOnHover: false,
    // timeoutProgressbarColor: 'rgba(255,255,255,0.5)',
    // transitionIn: 'comingIn',
    // transitionOut: 'comingOut',
    // transitionInOverlay: 'fadeIn',
    // transitionOutOverlay: 'fadeOut',
    // onFullscreen: function(){},
    // onResize: function(){},
    onOpening: function(modal){
      modal.startLoading();
    },
    onOpened: function(modal){
      modal.stopLoading();
    },
    // onClosing: function(){},
    // onClosed: function(){},
    // afterRender: function(){}
  });

  var show_modal = function(id)
  {
   axios.get('{{ url('calon_mahasiswa/') . '/' }}'+id, {
   })
   .then(res => {
    response = res.data;
    set_modal_data(response);
    $('#modal-detail').iziModal('open');
  })
   .catch();

 }

 
 var set_modal_data = function(data)
 {
  $("#nama").text(data.nama);
  $("#nisn").text(data.nisn);
  $("#prodi").text(data.program_studi);
  $("#angkatan").text(data.tahun_masuk);
  $("#jk").text(data.jenis_kelamin);
  $("#no_hp").text(data.no_hp);
}


</script>
@endsection
