@extends('layouts.front.app',[
    'navbar'        => 'maps',
    'second_title'  => 'Map'
])

@section('plugins_css')
<link rel="stylesheet" type="text/css" href="{{ asset('css/custom/datatable.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/flatpickr.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/leaflet.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/easy-button.css')}}">
<link href='https://api.mapbox.com/mapbox.js/plugins/leaflet-fullscreen/v1.0.1/leaflet.fullscreen.css' rel='stylesheet' />
@endsection

@section('inline_css')
<style>
#mapid {
    min-height: calc(100vh)
}
</style>
@endsection

@section('content_body')
<div class="site-blocks-cover overlay" style="margin-top:0" data-aos="fade">
    <div id="mapid"></div>
</div>  
@endsection

@section('plugins_js')
<script type="text/javascript" src="{{ asset('js/leaflet.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/leaflet_fullscreen.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/flatpickr.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/easy-button.js') }}"></script>
@endsection

@section('inline_js')
<script>
var url = '{{ route("home") }}' + "/";
var centerView = new L.LatLng(-7.674, 110.624);
var mymap = L.map('mapid', {
  fullscreenControl: true
}).setView(centerView, 11.20);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoid2VsdmltIiwiYSI6ImNrOHEwbzZ0ZzAwZHUzbnFua3VuNnE5dHAifQ.Qhi2c-M8MUebIBpfUR2dVQ', {
  id: 'mapbox/outdoors-v9',
  accessToken: 'pk.eyJ1Ijoid2VsdmltIiwiYSI6ImNrOHEwbzZ0ZzAwZHUzbnFua3VuNnE5dHAifQ.Qhi2c-M8MUebIBpfUR2dVQ'
}).addTo(mymap);

var refreshButton = L.easyButton({
  id: 'refresh-view-button',
  states: [{
    icon: 'fas fa-sync-alt',
    title: 'Refresh',
    stateName: 'refresh-view',
    onClick: () => {
      redirectRefresh();
    }
  }]
}).addTo(mymap);

function redirectRefresh(){
  window.location.href = `${url}maps`;
}


// Klaten State
L.marker(centerView, {
    title: "Kota Klaten"
}).addTo(mymap);



function getPopupContent(field){
    return `
      <table>
        <tr>
          <th>Nama Area</th>
          <td>${field.aName}</td>
        </tr>
        <tr>
          <th>Mulai Kejadian</th>
          <td>${field.eStart}</td>
        </tr>
        <tr>
          <th>Akhir Kejadian</th>
          <td>${field.eEnd}</td>
        </tr>
        <tr>
          <th>Ketinggian Air </th>
          <td>${field.wLevel} m</td>
        </tr>
        <tr>
          <th>Tipe Banjir</th>
          <td>${field.fType}</td>
        </tr>
        <tr>
          <th>Kerusakan</th>
          <td>${field.damage}</td>
        </tr>
        <tr>
          <th>Jumlah Korban</th>
          <td>${field.civil}</td>
        </tr>
        <tr>
          <th>Deskripsi Penyebab</th>
          <td>${field.desc}</td>
        </tr>
        <tr>
          <th>Status Daerah</th>
          <td>${field.status}</td>
        </tr>

        <tr>
          <th>Kondisi</th>
          <td>${
            field.image != null 
              ? '<img src="'+url + 'storage/' + field.image+'" height="100" width="100">' 
                : 'tidak ada gambar'
          }</td>
        </tr>
      </table>
    `
}

function getGeoJSONData(id){
    let wew;
    console.log(id);
  
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: `${url}/maps/api?id=`+id,
      type: 'GET',
      async: false,
      cache: false,
      error: function (xhr, status, error) {
        console.log(status);
      },
      success: function(response){ 
        wew = response.data;
        console.log(wew);
      }
    });
    
    return wew;
    //underbuilding
}

function onEachFeatureCallback(feature, layer){
    if (feature.properties && feature.properties.popupContent) {
        let { aName,eStart,eEnd,wLevel,fType,damage,civil,desc,status,image } = feature.properties.popupContent;
        let content = {
          aName: aName,
          eStart: eStart,
          eEnd: eEnd,
          wLevel: wLevel,
          fType: fType,
          damage: damage,
          civil: civil,
          desc: desc,
          status: status,
          image: image
        }
        
        layer.bindPopup(getPopupContent(content)).openPopup();
    } else {
      console.log('untouch');
    }
}

let getField = {!! json_encode($fields) !!};
L.geoJSON(getGeoJSONData(getField), {
    style: function(feature){
    return {color: feature.properties.color}
    },
    onEachFeature: onEachFeatureCallback
}).addTo(mymap);

</script>
@endsection