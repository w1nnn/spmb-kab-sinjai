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
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/00010BBD-0D26-E111-9D41-25475164AF4C" target="_blank">40304694</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 157 Pabaheang</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : PABEHEANG</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.143301700000,120.223868300000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.143301700000,120.223868300000),{title: title});
	marker.bindPopup(title);
	markers.addLayer(marker);
			var title = '<div class="no-margin">'+
	'<h4></h4>'+
	'<div id="bodyContent">'+
	'<ul class="list-group list-group-unbordered">'+
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/E0F307BD-0D26-E111-82A1-7B213F432E93" target="_blank">40304404</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 27 Tondong</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Tondong Desa Kampala</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.153400000000,120.221000000000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.153400000000,120.221000000000),{title: title,icon:blue});
	marker.bindPopup(title);
	markers.addLayer(marker);
		var title = '<div class="no-margin">'+
	'<h4></h4>'+
	'<div id="bodyContent">'+
	'<ul class="list-group list-group-unbordered">'+
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/D09F07BD-0D26-E111-AAE0-D3BDAA4F0750" target="_blank">40304401</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 25 Borong Uttie</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Jln. Persatuan Raya Saukang Kec. Sinjai Timur Kab. Sinjai</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.144618300000,120.236160000000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.144618300000,120.236160000000),{title: title,icon:blue});
	marker.bindPopup(title);
	markers.addLayer(marker);
		var title = '<div class="no-margin">'+
	'<h4></h4>'+
	'<div id="bodyContent">'+
	'<ul class="list-group list-group-unbordered">'+
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/A0F61FBD-0D26-E111-A318-F7FB97E40FE4" target="_blank">40304615</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 104 Kalaka</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Jl. Ranggong. Dg. Romo</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.130636700000,120.233783300000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.130636700000,120.233783300000),{title: title,icon:blue});
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