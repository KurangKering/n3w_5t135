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
          <th>NIDN</th>  
          <td>:</td>
          <td><span id="nip"></span></td>
        </tr>
        <tr>
          <th>Nama Pegawai</th>
          <td>:</td>
          <td><span id="nama_pegawai"></span></td>
        </tr>
        <tr>
          <th>Jabatan</th>
          <td>:</td>
          <td><span id="jabatan"></span></td>
        </tr>
        <tr>
          <th>Jenis Kelamin</th>
          <td>:</td>
          <td><span id="jenis_kelamin"></span></td>
        </tr>
        <tr>
          <th>No Hp</th>
          <td>:</td>
          <td><span id="no_hp"></span></td>
        </tr>
        <tr>
          <th>Agama</th>
          <td>:</td>
          <td><span id="agama"></span></td>
        </tr>
        <tr>
          <th>Email</th>
          <td>:</td>
          <td><span id="email"></span></td>
        </tr>
        <tr>
          <th>Tempat Lahir</th>
          <td>:</td>
          <td><span id="tempat_lahir"></span></td>
        </tr>
        <tr>
          <th>Tanggal Lahir</th>
          <td>:</td>
          <td><span id="tanggal_lahir"></span></td>
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
    title: 'Detail Pegawai',
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
   axios.get('{{ url('pegawai/') . '/' }}'+id, {
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
  console.log(data);
  $("#nip").text(data.nip);
  $("#nama_pegawai").text(data.nama_pegawai);
  $("#jabatan").text(data.jabatan);
  $("#jenis_kelamin").text(data.jenis_kelamin);
  $("#no_hp").text(data.no_hp);
  $("#agama").text(data.agama);
  $("#email").text(data.email);
  $("#tempat_Lahir").text(data.tempat_Lahir);
  $("#tanggal_lahir").text(data.tanggal_lahir_manusia);

}


</script>
@endsection
