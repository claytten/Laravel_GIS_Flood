@extends('layouts.admin.app',[
    'menu'  => 'maps',
    'second_title'  => 'Map'
])
@section('content_header')
<div class="mdl-grid mdl-cell mdl-cell--9-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">
    <div class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone " style="display:flex; justify-content:space-between">
        <h4 class="mdl-cell mdl-cell--10-col-desktop mdl-cell--10-col-tablet mdl-cell--5-col-phone">Maps</h4>
    </div>
</div>
@endsection

@section('plugins_css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert2/sweetalert2.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/fontawesome.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/custom/datatable.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/flatpickr.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/leaflet.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/easy-button.css')}}">
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
@endsection

@section('inline_css')
<style>
#mapid {
    height:630px
}
</style>
@endsection

@section('content_alert')
<div id="alert-section" class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--6-col-phone">
@if(Session::get('message'))
    <div class="alert-result alert {{ Session::get('status') ? 'color--'.Session::get('status') : ' ' }}">
        <button type="button" class="close-alert" onclick="removeAlert()">×</button>
        <i class="material-icons">{{ Session::get('icon') }}</i>
        {{ Session::get('message') }}
    </div>
@endif
</div>
@endsection

@section('content_body')
<div class="mdl-grid mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-cell--top">  

    <!-- Map widget-->
    <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--6-col-tablet mdl-cell--2-col-phone">
        <div class="mdl-card mdl-shadow--2dp map">
            <div id="mapid"></div>
        </div>
    </div>

    <div class="mdl-cell mdl-cell--4-col-desktop mdl-cell--6-col-tablet mdl-cell--2-col-phone">
        <table class="mdl-cell mdl-cell--12-col-desktop mdl-cell--12-col-tablet mdl-cell--4-col-phone mdl-data-table mdl-js-data-table  mdl-shadow--2dp projects-table" id="mapsTable">
            <thead>
                <tr>
                    <th class="mdl-data-table__cell--non-numeric">No</th>
                    <th class="mdl-data-table__cell--non-numeric">Field</th>
                    <th class="mdl-data-table__cell--non-numeric">Deskripsi</th>
                    <th class="mdl-data-table__cell--non-numeric">Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($getFields as $item)
                <tr id="rows_null">
                    <td class="mdl-data-table__cell--non-numeric">{{$item->id}}</td>
                    <td class="mdl-data-table__cell--non-numeric">{{$item->area_name}}</td>
                    <td class="mdl-data-table__cell--non-numeric">{{$item->description}}</td>
                    <td class="mdl-data-table__cell--non-numeric">
                        <button id="more_{{$item->id}}" class="mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect button--colored-light-blue">Action</button>
    
                        <ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect mdl-shadow--2dp accounts-dropdown mdl-list pull-left"
                        for="more_{{$item->id}}">
                            @if(Auth::guard('employee')->user()->can('maps-edit'))
                            <li>
                                <button onclick="detailField('{{$item->id}}')" class="mdl-button mdl-js-button mdl-js-ripple-effect button--colored-teal">
                                    <i class="material-icons">edit</i>
                                    Edit
                                </button>
                            </li>
                            @endif
    
                            @if(Auth::guard('employee')->user()->can('maps-delete'))
                            <li >
                                <button onclick="deleteField('{{$item->id}}')" class="mdl-button mdl-js-button mdl-js-ripple-effect button--colored-red">
                                    <i class="material-icons">delete_forever</i>
                                    Delete
                                </button>
                            </li>
                            @endif
                            
                        </ul>
                    </td>
                </tr>
            @empty
            <tr id="rows_null">
                <td class="mdl-data-table__cell--non-numeric"></td>
                <td class="mdl-data-table__cell--non-numeric"></td>
                <td class="mdl-data-table__cell--non-numeric"></td>
                <td class="mdl-data-table__cell--non-numeric"></td>
            </tr>
            @endforelse
            
            </tbody>
        </table>
    </div>

</div>
@endsection

@section('plugins_js')
<script type="text/javascript" src="{{ asset('plugins/datatable/datatables.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/sweetalert2/sweetalert2.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/leaflet.js') }}"></script>
<script src='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/Leaflet.fullscreen.min.js'></script>
<script type="text/javascript" src="{{ asset('js/flatpickr.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/easy-button.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/main_gis.js') }}"></script>
@endsection

@section('inline_js')
<script>
var usersTable = $("#mapsTable").DataTable({
    order: [2, 'asc'],
    pageLength: 5,
    aLengthMenu:[5,10,15,25,50],
    language: {
        searchPlaceholder: "Type Here.."
    },
    columnDefs: [
        {
            targets: 3,
            orderable: false,
            searchable: false,
        }
    ]
});

function deleteField(id){
    $(".alert-result").slideUp(function(){
        $(this).remove();
    });
    $('#loading').append(`
        <div id="p7" class="mdl-progress mdl-js-progress mdl-progress__indeterminate progress--colored-light-blue loading"></div>
    `);
    Swal.fire({
        title: 'Are you sure?',
        text: "This user status will be set to Destroy, and this field delete anymore!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        console.log(result.icon);
        console.log(result.redirect_url);
        if(result.value){
            $.post("{{ route('admin.api.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'delete'}, function(result){
                $('#rows_'+id).remove();
                // Append Alert Result
                $(`
                <div class="alert-result mdl-shadow--2dp alert color--`+result.status+`">
                    <button type="button" class="close-alert" onclick="removeAlert()">×</button>
                    <i class="material-icons">`+result.icon+`</i>
                    `+result.message+`
                </div>
                `).appendTo($("#alert-section")).slideDown("slow", "swing");
                $('#loading').empty();
                window.location.href = result.redirect_url;
            });
        }
    });
}

function get_detail(id) {
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
              <div class="alert-result mdl-shadow--2dp alert color--orange">
                  <button type="button" class="close-alert" onclick="removeAlert()">×</button>
                  <i class="material-icons">highlight_off</i>
                  Terjadi Kesalahan
              </div>
              `).appendTo($("#alert-section")).slideDown("slow", "swing");
              $('#loading').empty();
                console.log('Error', response);
            }
        }
    })
}

async function detailField(id){
    get_detail(id).then( async () => {
      const { value: formValues, dismiss } = await Swal.fire({
        title: 'Isi Informasi Area',
        html: `
          <div id="field-form">
            <table>
              <tr>
                <th>Area</th>
                <td><input type="text" id="area_name" class="swal2-input" placeholder="Pemilik" value="${detail.area_name}"></td>
              </tr>
              <tr>
                <th>Deskripsi Area</th>
                <td><input type="text" id="desc" class="swal2-input" placeholder="Tanaman" value="${detail.description}"></td>
              </tr>
              <tr>
                <th>Tanggal keadaan</th>
                <td><input type="text" id="event_date" class="swal2-input datepickr" placeholder="Tanggal Tanam" value="${detail.event_date}"></td>
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
            areaName: document.getElementById('area_name').value,
            desc: document.getElementById('desc').value,
            eventDate: document.getElementById('event_date').value,
          }

          // check empty value
          for (let [, val] of Object.entries(v)) {
            if(val === ''){
              Swal.showValidationMessage(`Harap isi semua input yang ada`);
            }
          }

          if(!v.eventDate.match(/([12]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01]))/i)){
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

function sendUpdate(data){
    $.ajax({
      url: "{{ route('admin.api.index') }}/"+data.id,
      type: 'PUT',
      cache: false,
      data: {
        id: data.id,
        areaName: data.areaName,
        desc: data.desc,
        eventDate: data.eventDate,
      },
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
          $(`
          <div class="alert-result mdl-shadow--2dp alert color--`+response.status+`">
              <button type="button" class="close-alert" onclick="removeAlert()">×</button>
              <i class="material-icons">`+response.icon+`</i>
              `+response.message+`
          </div>
          `).appendTo($("#alert-section")).slideDown("slow", "swing");
          $('#loading').empty();
          window.location.href = response.redirect_url;
        }
        else {
          $(`
          <div class="alert-result mdl-shadow--2dp alert color--orange">
              <button type="button" class="close-alert" onclick="removeAlert()">×</button>
              <i class="material-icons">highlight_off</i>
              Terjadi Kesalahan
          </div>
          `).appendTo($("#alert-section")).slideDown("slow", "swing");
          $('#loading').empty();
          console.log('Error in response', response);
        }
      }
    });
}
</script>
<script src="{{asset('js/customs/datatable.js')}}"></script>
@endsection