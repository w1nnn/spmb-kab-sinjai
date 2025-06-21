<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.css" />
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/MarkerCluster.css" />
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.fullscreen.css" />
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.markercluster-src.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/lib/Leaflet.zoomslider/src/L.Control.Zoomslider.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/L.TileLayer.Multi.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.fullscreen.min.js"></script>
    <style>
        
	.info {
		padding: 6px 8px;
		font: 14px/16px Arial, Helvetica, sans-serif;
		background: white;
		background: rgba(255,255,255,0.8);
		box-shadow: 0 0 15px rgba(0,0,0,0.2);
		border-radius: 5px;
	}
	.legend {
		text-align: left;
		line-height: 18px;
		color: #555;
	}
	.legend i {
		width: 18px;
		height: 18px;
		float: left;
		margin-right: 8px;
		opacity: 0.7;
	}

    </style>
</head>
<body>
    <div id="map" style="height:350px"></div>
    <script language="javascript">
        
	var map = L.map('map',{ zoomControl:false }).setView([0,0],(12));
	L.TileLayer.multi({
		15: {
			url: 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png'
		},
		16: {
			url: 'http://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}'
		}
	}, {
		minZoom: 0,
		maxZoom: 16,
		attribution: 'Arcgis,Openstreetmap'
	}).addTo(map);
	new L.Control.Zoom({ position: 'bottomright' }).addTo(map);
	L.control.fullscreen({ position: 'bottomleft' }).addTo(map);
	var markers = L.markerClusterGroup({ chunkedLoading: true });
	var red = L.icon({iconUrl : 'https://sekolah.data.kemdikbud.go.id/assets/image/markerred.png'});
	var blue = L.icon({iconUrl : 'https://sekolah.data.kemdikbud.go.id/assets/image/markerblue.png'});
		var title = '<div class="no-margin">'+
	'<h4></h4>'+
	'<div id="bodyContent">'+
	'<ul class="list-group list-group-unbordered">'+
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/60AA0BBD-0D26-E111-A63A-2585648701C4" target="_blank">40304700</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 162 Dumme</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Jl. Persatuan Raya Sanjai</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.215325000000,120.301198300000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.215325000000,120.301198300000));
	marker.bindPopup(title);
	markers.addLayer(marker);
			var title = '<div class="no-margin">'+
	'<h4></h4>'+
	'<div id="bodyContent">'+
	'<ul class="list-group list-group-unbordered">'+
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/B05F0CBD-0D26-E111-A508-750999FBDF9A" target="_blank">40304728</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 127 Takkalala</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Takkalala</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.223900000000,120.310600000000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.223900000000,120.310600000000),{icon:blue});
	marker.bindPopup(title);
	markers.addLayer(marker);
		var title = '<div class="no-margin">'+
	'<h4></h4>'+
	'<div id="bodyContent">'+
	'<ul class="list-group list-group-unbordered">'+
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/20311ABD-0D26-E111-997C-694D6763AFD4" target="_blank">40304437</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 37 Bua</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Jl. Poros Sinjai Kajang, Desa Bua</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.227700000000,120.308600000000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.227700000000,120.308600000000),{icon:blue});
	marker.bindPopup(title);
	markers.addLayer(marker);
		var title = '<div class="no-margin">'+
	'<h4></h4>'+
	'<div id="bodyContent">'+
	'<ul class="list-group list-group-unbordered">'+
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/202609BD-0D26-E111-88B6-5DAEF73A0BF7" target="_blank">40304435</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 35 Dumme</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Jl. Poros Sinjai Kajang</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.205800000000,120.290000000000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.205800000000,120.290000000000),{icon:blue});
	marker.bindPopup(title);
	markers.addLayer(marker);
		var bounds = markers.getBounds();
    map.fitBounds(bounds);
    map.addLayer(markers);
	function getColor(d) {
		return d > 100  ? '#FC4E2A' :
			   d > 10   ? '#FFCC33' :
						  '#339900';
	}
	function style(feature) {
		return {
			weight: 2,
			opacity: 1,
			color: 'white',
			dashArray: '3',
			fillOpacity: 0.7,
			fillColor: getColor(feature.properties.density)
		};
	}
	var legend = L.control({position: 'topright'});
	legend.onAdd = function (map) {
		var div = L.DomUtil.create('div', 'info legend'),
			grades = [0, 10, 100],
			labels = [],
			from, to;
		for (var i = 0; i < grades.length; i++) {
			from = grades[i];
			to = grades[i + 1];
			labels.push(
				'<i style="background:' + getColor(from + 1) + '"></i> ' +
				from + (to ? '&ndash;' + to : '+'));
		}
		div.innerHTML = labels.join('<br>');
		return div;
	};
	legend.addTo(map);

    </script>
</body>
</html>