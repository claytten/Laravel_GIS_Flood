@extends('layouts.admin.app',[
  'headers' => 'active',
  'menu' => 'maps',
  'title' => 'Map',
  'first_title' => 'Map',
  'first_link' => route('admin.view.index')
])

@section('content_alert')
<div id="alert-result">
  @if(Session::get('message'))
    <div class="alert alert-{{ Session::get('status') }} alert-dismissible fade show alert-result" style="margin-bottom: 0" role="alert">
      <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
      <span class="alert-text">{{ Session::get('message') }}</span>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
</div>
@endsection

@section('plugins_css')
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/leaflet.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/easy-button.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/flatpickr.min.css')}}">
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}">
@endsection

@section('inline_css')
<style>
#mapid {
    height:750px
}
</style>
@endsection

@section('content_body')
    <div class="row">
      <div class="col-lg-12">
        <!-- Card header -->
        <div class="card-header">
          <h3 class="mb-0">Map Management</h3>
        </div>
        <div class="card">
          <div id="mapid"></div>
        </div>
        <div class="card">
          <div class="table-responsive py-4">
            <table class="table table-flush" id="mapsTable">
              <thead class="thead-light">
                <tr>
                  <th>Area Name</th>
                  <th>Flood Type</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tfoot>
                <tr>
                  <th>Area Name</th>
                  <th>Flood Type</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </tfoot>
              <tbody>
                @foreach($getFields as $item)
                    <tr id="rows_{{ $item->id }}">
                        <td>{{ ucwords($item->area_name) }}</td>
                        <td>{{ $item->flood_type }}</td>
                        <td>{{ $item->status }}</td>
                        <td>
                          <div class="dropdown">
                            <a class="btn btn-md btn-icon-only text-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              <i class="ni ni-settings-gear-65"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                              <button type="button" onclick="editField('{{$item->id}}')" class="dropdown-item text-warning">Edit</button>
                              <button type="button" onclick="deleteField('{{$item->id}}')" class="dropdown-item text-danger">Delete</button>
                            </div>
                          </div>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('plugins_js')
<script type="text/javascript" src="{{ asset('vendor/sweetalert2/dist/sweetalert2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/leaflet.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/leaflet_fullscreen.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/easy-button.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/flatpickr.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main_gis.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendor/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
<script>
  const DatatableButtons = (function() {

    // Variables

    let $dtButtons = $('#mapsTable');


    // Methods

    function init($this) {

      // For more options check out the Datatables Docs:
      // https://datatables.net/extensions/buttons/

      const buttons = ["copy", "print"];

      // Basic options. For more options check out the Datatables Docs:
      // https://datatables.net/manual/options

      const options = {
        order: [2, 'asc'],
        lengthChange: !1,
        dom: 'Bfrtip',
        buttons: buttons,
        // select: {
        // 	style: "multi"
        // },
        language: {
          paginate: {
            previous: "<i class='fas fa-angle-left'>",
            next: "<i class='fas fa-angle-right'>"
          }
        },
        columnDefs: [
        {
            targets: 3,
            orderable: false,
            searchable: false,
        }
    ],
      };

      // Init the datatable
      let table = $this.on( 'init.dt', function () {
        $('.dt-buttons .btn').removeClass('btn-secondary').addClass('btn-sm btn-default');
        }).DataTable(options);
    }


    // Events

    if ($dtButtons.length) {
      init($dtButtons);
    }

  })();

  const deleteField = (id) => {
    $(".alert-result").slideUp(function(){
        $(this).remove();
    });
    Swal.fire({
        title: 'Are you sure?',
        text: "This field will be set to Destroy!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if(result.value){
          $.post("{{ route('admin.api.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'delete'}, function(result){
              // Append Alert Result
              $(`
              <div class="alert alert-`+ result.status +` alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
                <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                <span class="alert-text">`+ result.message +`</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              `).appendTo($("#alert-result")).slideDown("slow", "swing");
              setTimeout(location.reload.bind(location), 1000);
          }).fail(function(jqXHR, textStatus, errorThrown){

              $.each(jqXHR.responseJSON.errors, function(key, result) {
                $(`
                <div class="alert alert-danger alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
                  <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                  <span class="alert-text">`+ jqXHR.responseText +`</span>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                `).appendTo($("#alert-result")).slideDown("slow", "swing");
                setTimeout(location.reload.bind(location), 1000);
              });
          });
        }
    });
  }

  const getDetail = (id) => {
    return $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: "{{ route('admin.api.index') }}/"+id,
        type: 'GET',
        error: function(err){
            Swal.fire({
            title: 'Terjadi kesalahan',
            icon: 'error',
            toast: true
            });
            console.log('Error sending data', err);
        },
        success: function(response){
            if(response.code === 200){
                detail = response.data;
                console.log(detail);
            }
            else {
              $(`
              <div class="alert alert-danger alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
                <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
                <span class="alert-text">Terjadi Kesalahan</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              `).appendTo($("#alert-result")).slideDown("slow", "swing");
              console.log('Error', response);
            }
        }
    })
  }
  
  const editField = async (id) => {
    getDetail(id).then( async () => {
      const { value: formValues, dismiss } = await Swal.fire({
        title: 'Isi Informasi Area',
        html: `
          <div id="field-form">
            <table>
              <tr>
                <th>Area</th>
                <td><input type="text" id="area_name" class="swal2-input" placeholder="Nama Area" value="${detail.area_name}"></td>
              </tr>
              <tr>
                <th>Tanggal Awal Kejadian</th>
                <td><input type="text" id="event_start" class="swal2-input datepickr" placeholder="Tanggal Awal Kejadian" value="${detail.event_start}"></td>
              </tr>
              <tr>
                <th>Tanggal Akhir Kejadian <br>*jika belum berakhir sesuai tgl awal</th>
                <td><input type="text" id="event_end" class="swal2-input datepickr" placeholder="Tanggal Akhir kejadian" value="${detail.event_end}"></td>
              </tr>
              <tr>
                <th>Ketinggian Air */m</th>
                <td><input type="number" id="water_level" class="swal2-input" style="max-width: 100%" placeholder="Ketinggian Air" min="0" value="${detail.water_level}"></td>
              </tr>
              <tr>
                <th>Jenis Banjir</th>
                <td>
                  <select class="swal2-input" id="flood_type">
                    <option value="">--pilihan--</option>
                    <option value="air">Air</option>
                    <option value="cileuncang">Cileuncang</option>
                    <option value="rob">Rob</option>
                    <option value="bandang">Bandang</option>
                    <option value="lahar">Lahar</option>
                    <option value="lumpur">Lumpur</option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Kerusakan</th>
                <td><textarea id="damage" class="swal2-textarea" placeholder="Deskripi Kerusakan" value="${detail.damage}"></textarea></td>
              </tr>
              <tr>
                <th>Jumlah Korban</th>
                <td><input type="number" id="civilians" class="swal2-input" style="max-width: 100%" placeholder="Jumlah Korban" step="1" min="0" value="${detail.civilians}"></td>
              </tr>
              <tr>
                <th>Deskripsi Perkiraan Penyebab</th>
                <td><textarea id="description" class="swal2-textarea" placeholder="Deskripsi Penyebab" value="${detail.description}"></textarea></td>
              </tr>
              <tr>
                <th>status</th>
                <td>
                  <select class="swal2-input" id="status">
                    <option value="">--pilihan--</option>
                    <option value="aman">Aman</option>
                    <option value="sedang">sedang</option>
                    <option value="rawan">Rawan</option>
                  </select>
                </td>
              </tr>
              <tr>
                <th>Kondisi</th>
                <td>
                  <input type="file" accept=".jpg, .jpeg, .png" id="image" class="form-control imgs" name="image" >
                </td>
              </tr>
            </table>
          </div>
        `,
        focusConfirm: false,
        confirmButtonText: 'Simpan',
        confirmButtonColor: '#0c0',
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false,
        showCancelButton: true,
        cancelButtonText: 'Batalkan',
        onOpen: () => {
          flatpickr(".datepickr", {});
        },
        preConfirm: () => {
          let v = {
            aName: document.getElementById('area_name').value,
            eStart: document.getElementById('event_start').value,
            eEnd: document.getElementById('event_end').value,
            wLevel: document.getElementById('water_level').value,
            fType: document.getElementById('flood_type').value,
            damage: document.getElementById('damage').value,
            civil: document.getElementById('civilians').value,
            desc: document.getElementById('description').value,
            status: document.getElementById('status').value,
            image: $("#image").prop("files")[0]
          }

          // check empty value
          for (let [, val] of Object.entries(v)) {
            if(val === ''){
              Swal.showValidationMessage(`Harap isi semua input yang ada`);
            }
          }

          if(!v.eStart.match(/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/i)
            || !v.eEnd.match(/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/i)
          ){
            Swal.showValidationMessage(`Format tanggal salah`);
          }

          v.id = id;
          return v;
        }
      });

      return formValues;
    }).then((data) => {
      if(data !== undefined){
        sendUpdate(data);
      }
    });
  }

  const sendUpdate = (data) => {
    let formData = new FormData();
    formData.append('id',data.id);
    formData.append('aName',data.aName);
    formData.append('eStart',data.eStart);
    formData.append('eEnd',data.eEnd);
    formData.append('wLevel',data.wLevel);
    formData.append('fType',data.fType);
    formData.append('damage',data.damage);
    formData.append('civil',data.civil);
    formData.append('desc',data.desc);
    formData.append('status',data.status);
    formData.append('image',data.image);
    $.ajax({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: "{{ route('admin.api.store') }}",
      type: 'POST',
      cache: false,
      contentType: false,
      processData: false,
      data: formData,
      error: function (xhr, status, error) {
        Swal.fire({
          title: 'Terjadi kesalahan',
          icon: 'error',
          toast: true
        });
        console.log(data.id);
        console.log('Error sending data', error);
        console.log(xhr.responseText);
      },
      success: function(response){
        if(response.code === 200){
          console.log(formData.get('id'));
          console.log(response);
          // Append Alert Result
          $(`
          <div class="alert alert-`+ response.status +` alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
            <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
            <span class="alert-text">`+ response.message +`</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          `).appendTo($("#alert-result")).slideDown("slow", "swing");
          setTimeout(location.reload.bind(location), 1000);
        }
        else {
          $(`
            <div class="alert alert-danger alert-dismissible fade show alert-result" role="alert" style="margin-bottom: 0">
              <span class="alert-icon"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i></span>
              <span class="alert-text">Terjadi Kesalahan</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            `).appendTo($("#alert-result")).slideDown("slow", "swing");
          console.log('Error', response);
          console.log('Error in response', response);
        }
      }
    });
  }
</script>
@endsection
