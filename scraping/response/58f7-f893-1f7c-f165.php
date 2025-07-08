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
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/20F3FFBC-0D26-E111-995D-3534CFC17CD4" target="_blank">40304713</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 183 Lembanna</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Gunung Perak</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.255300000000,119.994200000000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.255300000000,119.994200000000));
	marker.bindPopup(title);
	markers.addLayer(marker);
			var title = '<div class="no-margin">'+
	'<h4></h4>'+
	'<div id="bodyContent">'+
	'<ul class="list-group list-group-unbordered">'+
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/F06FFEBC-0D26-E111-B39F-19F64576E516" target="_blank">40304586</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 75 Lembanna</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Jl. Persatuan Raya Lembanna</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.250400000000,119.997900000000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.250400000000,119.997900000000),{icon:blue});
	marker.bindPopup(title);
	markers.addLayer(marker);
		var title = '<div class="no-margin">'+
	'<h4></h4>'+
	'<div id="bodyContent">'+
	'<ul class="list-group list-group-unbordered">'+
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/807AFDBC-0D26-E111-9C8F-DFE1441B0D2D" target="_blank">40304546</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 69 Balang - Balang</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Jl. Balakia. A No. 18</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.248500000000,119.988000000000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.248500000000,119.988000000000),{icon:blue});
	marker.bindPopup(title);
	markers.addLayer(marker);
		var title = '<div class="no-margin">'+
	'<h4></h4>'+
	'<div id="bodyContent">'+
	'<ul class="list-group list-group-unbordered">'+
		'<li class="list-group-item text-info"><a href="https://sekolah.data.kemdikbud.go.id/index.php/chome/profil/509CFEBC-0D26-E111-80E8-F9ED9A6076A5" target="_blank">40304587</a></li>'+
		'<li class="list-group-item text-muted">SD Neg. No. 76 Pusanti</li>'+
		'<li class="list-group-item text-muted"><b>Alamat</b> : Jl. Persatuan No. A. 69 Mattirohalia</li>'+
		'<li class="list-group-item text-muted"><a href="https://maps.google.co.id/maps?expflags=enable_star_based_justifications:true&ie=UTF8&f=d&daddr=-5.254900000000,120.006200000000" target="_blank">Direction</a></li>'+
	'</ul>'+
	'</div>';
	var marker = L.marker(L.latLng(-5.254900000000,120.006200000000),{icon:blue});
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