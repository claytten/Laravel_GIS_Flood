
"use strict"

var url = window.location.origin + "/";
var centerView = new L.LatLng(-7.674, 110.624);
var mymap = L.map('mapid', {
  fullscreenControl: true
}).setView(centerView, 11.20);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1Ijoid2VsdmltIiwiYSI6ImNrOHEwbzZ0ZzAwZHUzbnFua3VuNnE5dHAifQ.Qhi2c-M8MUebIBpfUR2dVQ', {
  id: 'mapbox/outdoors-v9',
  accessToken: 'pk.eyJ1Ijoid2VsdmltIiwiYSI6ImNrOHEwbzZ0ZzAwZHUzbnFua3VuNnE5dHAifQ.Qhi2c-M8MUebIBpfUR2dVQ'
}).addTo(mymap);

/**
 * Singleton Variables
 * for better sharable state
 */
var startPolylineFlag = false;
var polyline = undefined;
var pols = [];
var polygon = undefined;
var helpLine = undefined;
var helpPolygon = undefined;
var firstPoint = L.circleMarker();
// Check whether the drawing state by button is active
var drawingState = false;

// Klaten State
L.marker(centerView, {
  title: "Kota Klaten"
}).addTo(mymap);

var reportButton = L.easyButton({
  id: 'report-view-button',
  states: [{
    icon: 'fas fa-file-excel',
    title: 'Laporan Area Rawan Banjir',
    stateName: 'repot-view',
    onClick: () => {
      redirectViewReport();
    }
  }]
}).addTo(mymap);

function redirectViewReport(){
  window.location.href = `${url}admin/maps/excel`;
}

var startDrawingButton = L.easyButton({
  id: 'start-drawing-button',
  states: [{
    icon: 'fa fa-pen',
    title: 'Mulai Menggambar',
    stateName: 'start-polyline',
    onClick: (btn, map) => {
      btn.button.style.backgroundColor = "#f00";
      btn.button.style.color = "#fff";
      document.getElementById("mapid").style.cursor = "crosshair";
      
      btn.state('cancel-polyline');
      drawingState = true;
    }
  }, {
    icon: 'fa fa-times',
    title: 'Batalkan Menggambar',
    stateName: 'cancel-polyline',
    onClick: (btn, map) => {
      btn.button.style.backgroundColor = "#fff";
      btn.button.style.color = "#000";
      document.getElementById("mapid").style.cursor = "grab";
      
      btn.state('start-polyline');
      cancelPolyline();
      drawingState = false;
    }
  }]
});
startDrawingButton.addTo(mymap);

var undoButton = L.easyButton({
  id: 'undo-polyline',
  states: [{
    icon: 'fa fa-undo',
    ttle: 'Batalkan titik terakhir',
    stateName: 'undo-polyline',
    onClick: (btn, map) => {
      undoPoint();
    }
  }]
});
undoButton.addTo(mymap);
undoButton.disable();

var finishButton = L.easyButton({
  id: 'finish-polyline',
  states: [{
    icon: 'fas fa-map',
    title: 'Selesai Menggambar',
    stateName: 'finish-polyline',
    onClick: (btn, map) => {
      drawArea();
    }
  }]
});
finishButton.addTo(mymap);
finishButton.disable();

function onMapClick(e) {
  if(!drawingState) return;

  if(startPolylineFlag != true){
    startPolyline(e.latlng);
    pols.push([e.latlng["lat"], e.latlng["lng"]]);
    polyline = L.polyline(pols, {
      color: '#ee3'
    }).addTo(mymap);
  }
  else {
    pols.push([e.latlng["lat"], e.latlng["lng"]]);
    polyline.addLatLng(e.latlng);
    undoButton.enable();

    if(validateArea()){
      drawHelpArea();
      finishButton.enable();
    }
  }
}

function onMapMouseMove(e) {
  if(!drawingState || pols.length < 1) return;
  
  let latlngs = [pols[pols.length - 1], [e.latlng.lat, e.latlng.lng]];
  
  if(helpLine){
    helpLine.setLatLngs(latlngs);
  }
  else {
    helpLine = L.polyline(latlngs, {
      color: 'grey',
      weight: 2,
      dashArray: '7',
      className: 'help-layer'
    });
    helpLine.addTo(mymap);
  }
}

function onKeyDownEscape(){
  cancelPolyline();
}

function onKeyDownEnter(){
  drawArea();
}

function centerizeView(){
  let zoomLevel = 17;
  zoomLevel = mymap.getZoom() < zoomLevel ? zoomLevel : mymap.getZoom();

  mymap.setView(
    centerView,
    zoomLevel,
    {
      animate: true,
      duration: 1.0
    }
  );
}

function startPolyline(latlng){
  placeFirstPoint(latlng);
  startPolylineFlag = true;
}

function finishPolyline(){
  removeMapLayers();

  startPolylineFlag = false;
  pols = [];
  polygon = undefined;
  polyline = undefined;
  helpLine = undefined;
  helpPolygon = undefined;
  
  finishButton.disable();
  undoButton.disable();
}

function cancelPolyline(){
  if(polyline === undefined) return;
  
  removeMapLayers();
  finishPolyline();
}

function undoPoint(){
  if(!drawingState) return;
  if(pols.length == 0) return;

  pols.pop();
  
  polyline.setLatLngs(pols);
  helpPolygon.setLatLngs(pols);

  if(!validateArea()){
    finishButton.disable();
  }

  if(pols.length == 0){
    finishPolyline();
    undoButton.disable();
  }
}

function validateArea(){
  if(pols.length > 2){
    return true;
  }
  return false;
}

function drawArea(){
  if(polyline === undefined) return;
  if(!validateArea()) return;

  drawingState = false;

  let randCol = '#' + (function co(lor){   return (lor +=
    [0,1,2,3,4,5,6,7,8,9,'a','b','c','d','e','f'][Math.floor(Math.random()*16)])
    && (lor.length == 6) ?  lor : co(lor); })('');
  
  polygon = L.polygon([pols], {
    color: randCol,
    fillOpacity: 0.4
  }).addTo(mymap);
  let popup = L.popup({
    closeButton: false,
    autoClose: false,
    closeOnEscapeKey: false,
    closeOnClick: false,
  })
  .setContent(`<button onclick="cancelArea()"><i class="fa fa-times-circle"></i></button> | <button onclick="confirmArea('${randCol}')"><i class="fa fa-check-circle"></i></button>`);

  polygon.bindPopup(popup).openPopup();
}

function drawHelpArea(){
  if(polyline === undefined) return;
  if(!validateArea()) return;
  
  if(helpPolygon){
    helpPolygon.setLatLngs(pols)
  }
  else {
    helpPolygon = L.polygon([pols], {
      color: '#ee0',
      stroke: false,
      className: 'help-layer'
    });
    helpPolygon.addTo(mymap);
  }
}

function cancelArea(){
  drawingState = true;
  mymap.removeLayer(polygon);
}

function confirmArea(color){
  popupForm(color);
}

function removeMapLayers(){
  mymap.removeLayer(polyline);
  mymap.removeLayer(helpLine);
  mymap.removeLayer(helpPolygon);
  mymap.removeLayer(firstPoint);
}

function placeFirstPoint(latlng){
  let icon = L.divIcon({
    className: 'first-point',
    iconSize: [10, 10],
    iconAnchor: [5, 5]
  });

  firstPoint = L.marker(latlng, {icon: icon});
  firstPoint.addTo(mymap);
  firstPoint.on('click', function(){
    if(validateArea()){
      drawArea();
    }
  });
}

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
    </table>
  `
}

async function popupForm(color){
  const { value: formValues, dismiss } = await Swal.fire({
    title: 'Isi Informasi Area',
    html: `
      <div id="field-form">
        <table>
          <tr>
            <th>Area</th>
            <td><input type="text" id="area_name" class="swal2-input" placeholder="Nama Area"></td>
          </tr>
          <tr>
            <th>Tanggal Awal Kejadian</th>
            <td><input type="text" id="event_start" class="swal2-input datepickr" placeholder="Tanggal Awal Kejadian"></td>
          </tr>
          <tr>
            <th>Tanggal Akhir Kejadian <br>*jika belum berakhir sesuai tgl awal</th>
            <td><input type="text" id="event_end" class="swal2-input datepickr" placeholder="Tanggal Akhir kejadian"></td>
          </tr>
          <tr>
            <th>Ketinggian Air */m</th>
            <td><input type="number" id="water_level" class="swal2-input" placeholder="Ketinggian Air" min="0"></td>
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
            <td><input type="text" id="damage" class="swal2-input" placeholder="Deskripi Kerusakan"></td>
          </tr>
          <tr>
            <th>Jumlah Korban</th>
            <td><input type="number" id="civilians" class="swal2-input" placeholder="Jumlah Korban" step="1" min="0"></td>
          </tr>
          <tr>
            <th>Deskripsi Perkiraan Penyebab</th>
            <td><input type="text" id="description" class="swal2-input" placeholder="Deskripsi Penyebab"></td>
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

      return v;
    }
  });

  polygon.closePopup();
  polygon.unbindPopup();

  if(dismiss === Swal.DismissReason.cancel){
    cancelArea();
    return;
  }

  polygon.bindPopup(getPopupContent(formValues)).openPopup();

  let sendData = {
    color: color,
    aName: formValues.aName,
    eStart: formValues.eStart,
    eEnd: formValues.eEnd,
    wLevel: formValues.wLevel,
    fType: formValues.fType,
    damage: formValues.damage,
    civil: formValues.civil,
    desc: formValues.desc,
    status: formValues.status
  }
  sendPolygonJSON(sendData);
  
  drawingState = true;
  finishPolyline();
}

function sendPolygonJSON(data){
  let polygonGeoJSON = polygon.toGeoJSON(15);
  polygonGeoJSON.properties = {
    color: data.color,
    popupContent: {
      aName: data.aName,
      eStart: data.eStart,
      eEnd: data.eEnd,
      wLevel: data.wLevel,
      fType: data.fType,
      damage: data.damage,
      civil: data.civil,
      desc: data.desc,
      status: data.status
    }
  }

  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: `${url}admin/maps/api`,
    type: 'POST',
    cache: false,
    data: {
      color: data.color,
      aName: data.aName,
      eStart: data.eStart,
      eEnd: data.eEnd,
      wLevel: data.wLevel,
      fType: data.fType,
      damage: data.damage,
      civil: data.civil,
      desc: data.desc,
      status: data.status,
      coordinates: JSON.stringify(polygonGeoJSON.geometry.coordinates)
    },
    error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log('Error sending data', error);
        console.log(data.color,data.aName,data.desc,data.eventDate,JSON.stringify(polygonGeoJSON.geometry.coordinates))
    },
    success: function(response){ 
      console.log("lolsd");
      console.log(response);
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
  });
}

function getGeoJSONData(){
  let wew;

  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: `${url}admin/maps/api`,
    type: 'GET',
    async: false,
    cache: false,
    error: function (xhr, status, error) {
      console.log(xhr.responseText);
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
    let { aName,eStart,eEnd,wLevel,fType,damage,civil,desc,status } = feature.properties.popupContent;
    let content = {
      aName: aName,
      eStart: eStart,
      eEnd: eEnd,
      wLevel: wLevel,
      fType: fType,
      damage: damage,
      civil: civil,
      desc: desc,
      status: status
    }
    
    layer.bindPopup(getPopupContent(content));
  }
}

// event listeners
mymap.on('click', onMapClick);
mymap.addEventListener('mousemove', onMapMouseMove);
document.onkeydown = (e) => {
  if(!drawingState) return;
  
  switch(e.keyCode){
    case 13: onKeyDownEnter(); break;
    case 27: onKeyDownEscape(); break;
  }
};

L.geoJSON(getGeoJSONData(), {
  style: function(feature){
    return {color: feature.properties.color}
  },
  onEachFeature: onEachFeatureCallback
}).addTo(mymap);
