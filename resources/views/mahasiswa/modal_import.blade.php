 @section('custom-css')
 @parent
 <style type="text/css">
 td.total-title {
  text-align: right;
  font-weight: bold;
}
</style>
@endsection

<div id="modal-import" style="display: none" style="z-index: 999999999">
  <div class="box">
    <form id="form-import" action="{{ route('mahasiswa.import') }}" method="POST" class="" enctype="multipart/form-data">
      <div class="box-body">

        @csrf
        <div class="form-group">
          <input type="file" id="file-excel" required name="file-excel" class="form-control">
        </div>

        <div id="error-import">

        </div>
      </div>
      <div class="box-footer">
        <button id="btn-do-import" type="submit" class="btn btn-primary btn-block">Import Now !</button>

      </div>
    </form>

  </div>

  <div class="ibox-content">
    <hr>
    <div id="result-area">

    </div>


  </div>
  
</div>

@section('custom_js')
@parent
<script>
  let tableResult = $('#table-result').DataTable({
  });

  $("#modal-import").iziModal({
    title: 'Import Data Mahasiswa',
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
    bodyOverflow: false,
    // fullscreen: true,
       // openFullscreen: true,
       closeOnEscape: false,
    // closeButton: true,
    // appendTo: 'body', // or false
    // appendToOverlay: 'body', // or false
    // overlay: true,
    overlayClose: false,
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
      // modal.startLoading();
    },
    onOpened: function(modal){
      // modal.stopLoading();
    },
    // onClosing: function(){},
    // onClosed: function(){},
    // afterRender: function(){}
  });

  var show_modal_import = function(id)
  {
    $("#file-excel").val('');
    $('#error-import').text('');
    $('#modal-import').iziModal('open');

    return;
   

  }



  $("#file-excel").change(function(event) {
    $('#error-import').html('');
    var file = this.files[0];
    var fileType = file.type;
    var fileSize = file.size / 1000 ;
    var type = 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
    var errors = [];
    if (type !== fileType) 
    {

      errors.push('File yang di import harus berformat xls');
    }

    if (errors.length > 0) {
      errorToHtml = '';
      $.each(errors, function(index, val) {
       errorToHtml += '<p>'+val+'</p>';
     });
      $(this).val('');
      $('#error-import').html(
        `<div class="alert alert-danger">
        `
        +
        errorToHtml
        +
        `
        </div>`
        );
    };

  });

  $("#form-import").submit(function(e) {
    e.preventDefault();
    $("#result-area").html('');
    $("#btn-do-import").attr('disabled', true);


    let formData = new FormData($(this)[0]);
    axios.post('{{ route('mahasiswa.import') }}', formData)
    .then(response => {
      resp = response.data;
     
      let $tableResponse = $('<table/>', {
        class : 'table table-bordered',
      });

      let $tHeading = $('<thead/>');

      let heading = 
      `<tr>
      <th>NISN</th>
      <th>NAMA</th>
      <th>STATUS</th>
      </tr>
      `;

      $tHeading.append(heading);
      $tableResponse.append($tHeading);

      let  $tBody = $('<tbody/>');

      $.each(resp, function(index, val) {

        let row = 
        `
        <tr>
        <td>`+val.nisn+`</td>
        <td>`+val.nama+`</td>
        <td>`+val.success+`</td>
        </tr>
        `;

        $tBody.append(row);
      });

      $tableResponse.append($tBody);
      $("#result-area").html($tableResponse);
      let btnReload = 
      $(`<button type="button" class="btn btn-block btn-info">Reload Page</button>`)
      .click(function(event) {
        location.href= "{{ url()->current() }}";
      });


      $("#result-area").html($tableResponse);
      $("#result-area").append(btnReload);
    })
    .finally(() => {
      $("#btn-do-import").attr('disabled', false);

    })
  })


</script>
@endsection
