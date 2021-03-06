
"use strict"

let url = window.location.origin + "/";
let centerView = new L.LatLng(-7.674, 110.624);
let mymap = L.map('mapid', {
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
let startPolylineFlag = false;
let polyline = undefined;
let pols = [];
let polygon = undefined;
let helpLine = undefined;
let helpPolygon = undefined;
let firstPoint = L.circleMarker();
// Check whether the drawing state by button is active
let drawingState = false;

// Klaten State
L.marker(centerView, {
  title: "Kota Klaten"
}).addTo(mymap);

const reportButton = L.easyButton({
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

const startDrawingButton = L.easyButton({
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

    }
  }]
});
startDrawingButton.addTo(mymap);

const undoButton = L.easyButton({
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

const finishButton = L.easyButton({
  id: 'finish-polyline',
  states: [{
    icon: 'fas fa-map',
    title: 'Selesai Menggambar',
    stateName: 'finish-polyline',
    onClick: (btn, map) => {
      drawingState = true;
      drawArea();
      finishButton.disable();
      undoButton.disable();
      startDrawingButton.disable();
    }
  }]
});
finishButton.addTo(mymap);
finishButton.disable();

const onMapClick = (e) => {
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

const onMapMouseMove = (e) => {
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

const onKeyDownEscape = () => {
  cancelPolyline();
}

const onKeyDownEnter = () => {
  drawArea();
}

const centerizeView = () => {
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

const startPolyline = (latlng) => {
  placeFirstPoint(latlng);
  startPolylineFlag = true;
}

const finishPolyline = () => {
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

const cancelPolyline = () => {
  if(polyline === undefined) return;

  removeMapLayers();
  finishPolyline();
}

const undoPoint = () => {
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

const validateArea = () => {
  if(pols.length > 2){
    return true;
  }
  return false;
}

const drawArea = () => {
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

const drawHelpArea = () => {
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

const cancelArea = () => {
  drawingState = true;
  mymap.removeLayer(polygon);
  finishButton.enable();
  undoButton.enable();
  startDrawingButton.enable();
}

const confirmArea = (color) => {
  popupForm(color);
}

const removeMapLayers = () => {
  mymap.removeLayer(polyline);
  mymap.removeLayer(helpLine);
  mymap.removeLayer(helpPolygon);
  mymap.removeLayer(firstPoint);
}

const placeFirstPoint = (latlng) => {
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

const getPopupContent = (field) => {
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

const popupForm = async (color) => {
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
            <td><input type="number" id="water_level" class="swal2-input" style="max-width: 100%" placeholder="Ketinggian Air" min="0"></td>
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
            <td><textarea id="damage" class="swal2-textarea" placeholder="Deskripi Kerusakan"></textarea></td>
          </tr>
          <tr>
            <th>Jumlah Korban</th>
            <td><input type="number" id="civilians" class="swal2-input" style="max-width: 100%" placeholder="Jumlah Korban" step="1" min="0"></td>
          </tr>
          <tr>
            <th>Deskripsi Perkiraan Penyebab</th>
            <td><textarea id="description" class="swal2-textarea" placeholder="Deskripsi Penyebab"></textarea></td>
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
    status: formValues.status,
    image: formValues.image
  }
  sendPolygonJSON(sendData);

  drawingState = true;
  finishPolyline();
}

const sendPolygonJSON = (data) => {
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
      status: data.status,
      image: data.image
    }
  }
  let formData = new FormData();
  formData.append('color',data.color);
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
  formData.append('coordinates',JSON.stringify(polygonGeoJSON.geometry.coordinates));
  $.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    url: `${url}admin/maps/api`,
    type: 'POST',
    cache: false,
    contentType: false,
    processData: false,
    data: formData,
    error: function (xhr, status, error) {
        console.log(xhr.responseText);
        console.log('Error sending data', error);
        console.log(data.color,data.aName,data.desc,data.image,JSON.stringify(polygonGeoJSON.geometry.coordinates))
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

const getGeoJSONData = () => {
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

const onEachFeatureCallback = (feature, layer) => {
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
