<!DOCTYPE html>
<html>
<head>
<title>MEN DRAG MARKER DAN MERUBAH LAT LNG MENJADI ALAMAT DI GMAPS</title>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js"></script>
<script type="text/javascript">
function init(){
 var info_window = new google.maps.InfoWindow();
 // menentukan level zoom
 var zoom = 5;

 // menentukan latitude dan longitude
 var pos = new google.maps.LatLng(-3.050444,116.323242);

 // menentukan opsi peta yang akan di buat
 var options = {
  'center': pos,
  'zoom': zoom,
  'mapTypeId': google.maps.MapTypeId.ROADMAP
 };

 // membuat peta
 var map = new google.maps.Map(document.getElementById('maps'), options);
 info_window = new google.maps.InfoWindow({
  'content': 'loading...'
 });
}
function cari_alamat(){
 // mengambil isi dari textarea dengan id alamat
 var alamat = document.getElementById('alamat').value;

 // membuat geocoder
 var geocoder = new google.maps.Geocoder();
 geocoder.geocode(
  {'address': alamat}, 
  function(results, status) { 
   if (status == google.maps.GeocoderStatus.OK) {
    var info_window = new google.maps.InfoWindow();

    // mendapatkan lokasi koordinat
    var geo = results[0].geometry.location;

    // set koordinat
    var pos = new google.maps.LatLng(geo.lat(),geo.lng());

    // update lokasi saat ini
    posisi_marker(pos);

    // rubah lokasi saat ini menjadi alamat
    convert_latlng(pos);

    // opsi peta yang akan di tampilkan
    var option = {
     center: pos,
     zoom: 16,
     mapTypeId:google.maps.MapTypeId.ROADMAP
    };

    // membuat peta
    var map = new google.maps.Map(document.getElementById('maps'),option);
    info_window = new google.maps.InfoWindow({
     content: 'loading...'
    });

    // menambahkan marker pada peta
    // agar marker bisa di drag maka anda perlu menambahkan object draggable
    var marker = new google.maps.Marker({
     position: pos,
     title: 'You are here',
     animation:google.maps.Animation.BOUNCE,
     draggable: true
    });
    marker.setMap(map);

    // menambahkan event drag ketika marker di geser
    google.maps.event.addListener(marker, 'dragstart', function(e){
     // info lat lng
     document.getElementById('lat').innerHTML = e.latLng.lat();
     document.getElementById('lng').innerHTML = e.latLng.lng();

     // info alamat
     convert_latlng(marker.getPosition());
    });

    // menambahkan event click ketika marker di klik
    google.maps.event.addListener(marker, 'click', function () {
     info_window.setContent('<b>'+ this.title +'</b>');
     info_window.open(map, this);
    });
   } else {
    alert('Lokasi Tidak Ditemukan'); 
   } 
  }
 );
}

// menentukan posisi marker
function posisi_marker(pos) {
 // menampilkan latitude dan longitude pada id lat dan lng
 document.getElementById('lat').innerHTML = pos.lat();
 document.getElementById('lng').innerHTML = pos.lng();
}

// merubah geotag menjadi alamat
function convert_latlng(pos) {

 // membuat geocoder
 var geocoder = new google.maps.Geocoder();
 geocoder.geocode({'latLng': pos}, function(r) {

  if (r && r.length > 0) {
   document.getElementById('info-alamat').innerHTML = r[0].formatted_address;
  } else {
   document.getElementById('info-alamat').innerHTML = 'Alamat tidak di temukan di lokasi !!';
  }

 });
}
google.maps.event.addDomListener(window, 'load', init);
</script>
</head>
<body>
<div id="maps" style="width: 800px; height: 400px;"></div>
<textarea id="alamat" style="width: 795px; resize:none;" placeholder="Cari alamat"></textarea>
< br />
<button onclick="cari_alamat()">CARI ALAMAT</button>
< br />
<strong>Info Alamat :</strong><span id="info-alamat"></span>
< br />
<strong>Latitude :</strong><span id="lat"></span>
< br />
<strong>Longitude :</strong><span id="lng"></span>
</body>
</html>
