@extends('frontend.layouts.mobile')
@section('style')
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
{{--<link rel="stylesheet" href="{{ asset('v2/css/leaflet.css')}}"/>--}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
      integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
      crossorigin=""/>
<style type="text/css">
  #map { height: 100vh; width: 100vw; }
  .geo-location-wrapper{
      display: none;
  }
</style>
@endsection
@section('main-content')
<div class="page-content-wrapper">
  <div class="geo-location-wrapper">
    <span class="btn geo-location"><i class="fa fa-map-marker"></i><span class="text">Find My Position</span></span>
  </div>
  <div id="map"></div>
</div>
@endsection
@section('footer-js')
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>
<script>
$.ajaxSetup({
    cache: true
});

// var mymap = L.map('map', { gestureHandling: true,  dragging: true, tap: true }).setView([16.1922065, -61.272382499999], 10);

const api_url = '/map-data';
$.getJSON(api_url,

  function(data) {
    //console.log(data);

/*Custom options*/
var customOptions =
        {
        'maxWidth': '150',
        'className' : 'custom'
        }
    var maa = L.geoJSON(data, {
      pointToLayer: function(feature, latlng) {
        /*Custom popup design*/
        var customPopup_d = "<div class='card' style='width: 100%;'><div id='carouselExampleControls' class='carousel slide' data-ride='carousel'><div class='carousel-inner'><div class='carousel-item active'><a href='partenaire/"+ feature.properties.slug + "'/><img class='d-block w-100' src='"+ feature.image +"' alt='First slide'></a></div></div></div><div class='card-body'><h5 class='card-title text-center'> "+ feature.properties.name +" </h5></div></div>";

        return L.marker(latlng, {
          icon: L.icon({
                iconUrl: '//yummybox.fr/assets/images/Yummy-box-picto.png',
                iconSize: [34, 34],
                iconAnchor: [22, 22],

            })
        }).bindPopup(customPopup_d,customOptions);
      }
    }).addTo(mymap);
});
mymap.locate({setView: true, maxZoom: 16});
function locateUser() {
    $('#map').addClass('fade-map');
    mymap.locate({setView : true})
}

function onLocationFound(){
    $('#map').removeClass('fade-map');
}
$('.geo-location').on("click", function() {
    locateUser();
});
	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
		maxZoom: 18,
		attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
			'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
		id: 'mapbox/streets-v11',
		tileSize: 512,
		zoomOffset: -1
	}).addTo(mymap);


</script>
@endsection
