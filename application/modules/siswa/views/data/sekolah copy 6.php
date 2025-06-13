<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="lanjut" value="orangtua">
	<input type="hidden" name="page" value="sekolah">

	<div class="row mb-0">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<?php
					// Query to check if NIK exists in tbl_status_dtks
					$nik = $get->no_ktp;
					$this->db->where('nik', $nik);
					$query = $this->db->get('tbl_status_dtks');

					if ($query->num_rows() > 0) {
						// NIK found in DTKS table
						echo '<div class="alert alert-primary" role="alert">
                            <i class="ri-checkbox-circle-line mr-2"></i> Terdata di DTKS
                          </div>';
					} else {
						// NIK not found in DTKS table
						echo '<div class="alert alert-warning text-dark" role="alert">
        <i class="ri-error-warning-line mr-2"></i> Proses Verifikasi DTKS
    </div>';
					}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row mb-4">
		<div class="col-12">
			<div class="progress-tracker">
				<ul class="d-flex justify-content-between list-unstyled position-relative">
					<li class="progress-step">
						<div class="progress-marker">
							<i class="ri-guide-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">1</span>
							<span class="step-title">Jalur</span>
						</div>
					</li>
					<li class="progress-step ">
						<div class="progress-marker">
							<i class="ri-user-2-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">2</span>
							<span class="step-title">Data Diri</span>
						</div>
					</li>
					<li class="progress-step active">
						<div class="progress-marker">
							<i class="ri-building-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">3</span>
							<span class="step-title">Sekolah</span>
						</div>
					</li>
					<li class="progress-step">
						<div class="progress-marker">
							<i class="ri-parent-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">4</span>
							<span class="step-title">Orang Tua</span>
						</div>
					</li>
					<li class="progress-step">
						<div class="progress-marker">
							<i class="ri-booklet-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">5</span>
							<span class="step-title">Dokumen</span>
						</div>
					</li>
					<li class="progress-step">
						<div class="progress-marker">
							<i class="ri-folder-chart-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">6</span>
							<span class="step-title">Selesai</span>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<table class="table">
				<tr>
					<td width="20%"> Tingkat Sekolah </td>
					<td width="2%"> : </td>
					<td> <?= tingkat($get->tingkat_sekolah)->level_sekolah ?> </td>
				</tr>
				<tr>
					<td> Jalur </td>
					<td> : </td>
					<td> <?= jalur($get->jalur)->nama ?> </td>
				</tr>
				<tr>
					<td> Kecamatan </td>
					<td> : </td>
					<td> <?= kecamatan($get->kec)->nama_kec ?> </td>
				</tr>
				<tr>
					<td> Lingkungan </td>
					<td> : </td>
					<td> <?= dusun($get->dusun)->daerah_zonasi ?> </td>
				</tr>

			</table>
			<?php if ($get->jalur == "114") { ?>
				<div class="form-group">
					<label for=""> Jalur Zonasi <span class="text-danger">*</span> </label>
					<select name="area" class="form-control" id="jalur">
						<option value=""> Pilih</option>
						<option value="zonasi"> Area Jarak Terdekat</option>
						<option value="all"> Area Domisili</option>
					</select>
				</div>
			<?php } ?>

			<div class="form-group">
				<label for=""> Sekolah Pilihan <span class="text-danger">*</span> </label>
				<select name="sekolah_pilihan_1" class="form-control select2 sekolah" id="sekolah_1" style="width: 100%;" required>
					<option value=""></option>
				</select>
			</div>
            <?php
$pilihan_sekolah_1 = $get->pilihan_sekolah_1; 

// Default koordinat
$default_longitude = 120.150347;
$default_latitude = -5.201962;

// Tambilkan data sekolah dari database
$this->db->where('npsn', $pilihan_sekolah_1);
$sekolah = $this->db->get('tbl_sekolah')->row();

// Inisialisasi variabel
$kordinat_default = '';
$longitude = $default_longitude;
$latitude = $default_latitude;
$nama_sekolah = '';

// Jika data sekolah ditemukan
if ($sekolah) {
    $nama_sekolah = $sekolah->nama;
    $kordinat_default = $sekolah->kordinat;
    
    // Parse koordinat jika tersedia
    if (!empty($kordinat_default)) {
        // Parse koordinat (format diasumsikan "longitude,latitude")
        $coords = explode(',', $kordinat_default);
        $longitude = (isset($coords[0]) && trim($coords[0]) !== '') ? trim($coords[0]) : $default_longitude;
        $latitude = (isset($coords[1]) && trim($coords[1]) !== '') ? trim($coords[1]) : $default_latitude;
    }
}
// var_dump($nama_sekolah);
?>
            
            <?php if ($get->jalur == "114") { ?>
			<div class="card mt-4">
				<div class="card-body">
					<div id="map" style="width: 100%; height: 400px;"></div>
				</div>
			</div>
            <?php } ?>

		</div>
	</div>
	<hr>
	<button class="btn btn-primary pull-right " type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>

	<?php if (level_user() == "siswa") { ?>
		<a href="<?= base_url() ?>siswa/profil/datadiri" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } else { ?>
		<a href="<?= base_url() ?>siswa/edit/datadiri?id=<?= $get->id_siswa ?>" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } ?>

</form>

<!-- OpenLayers CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css" type="text/css">

<!-- OpenLayers JS -->
<script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
<script>
    // var listSekolah = document.getElementById('sekolah_1').options;
	// console.log(listSekolah);
    const areaSelect = document.getElementById('jalur');
    const mapElement = document.getElementById('map');

    function toggleMap() {
        if (areaSelect.value === 'all') {
            mapElement.style.display = 'none';
        } else {
            mapElement.style.display = 'block';
        }
    }

    // Jalankan saat halaman load
    toggleMap();

    // Jalankan saat opsi diubah
    areaSelect.addEventListener('change', toggleMap);
</script>
<script>
	$(document).ready(function() {
    // Koordinat dari database
    const schoolLongitude = <?php echo $longitude; ?>;
    const schoolLatitude = <?php echo $latitude; ?>;
    const schoolName = "<?= $nama_sekolah ?>"; 
    console.log(schoolLongitude);

    // Create base map layers directly in the group
    const baseLayerGroup = new ol.layer.Group({
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM(),
                visible: true,
                title: "OSM_Standard"
            }),
            new ol.layer.Tile({
                source: new ol.source.OSM({
                    url: "https://{a-c}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png"
                }),
                visible: false,
                title: "OSM_Humanitarian"
            }),
            new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: "https://tile.stamen.com/terrain/{z}/{x}/{y}.jpg",
                    attributions: 'Map tiles by <a href="http://stamen.com">Stamen Design</a>, under <a href="http://creativecommons.org/licenses/by/3.0">CC BY 3.0</a>. Data by <a href="http://openstreetmap.org">OpenStreetMap</a>, under <a href="http://www.openstreetmap.org/copyright">ODbL</a>.'
                }),
                visible: false,
                title: "Stamen_Terrain"
            }),
            new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: "https://mt0.google.com/vt/lyrs=m&hl=en&x={x}&y={y}&z={z}&s=Ga"
                }),
                visible: false,
                title: "Google_Maps"
            }),
            new ol.layer.Tile({
                source: new ol.source.XYZ({
                    url: "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}"
                }),
                visible: false,
                title: "Satelite"
            })
        ]
    });

    // Initialize the map
    const map = new ol.Map({
        target: 'map',
        layers: [baseLayerGroup], // Add the layer group instead of individual layers
        view: new ol.View({
            // Center on the school location
            center: ol.proj.fromLonLat([schoolLatitude, schoolLongitude]),
            zoom: 15
        })
    });

    // Create custom marker styles with better visibility
    const customMarkerStyle = new ol.style.Style({
        image: new ol.style.Icon({
            anchor: [0.5, 1], // Anchor at the bottom center of the image
            anchorXUnits: 'fraction',
            anchorYUnits: 'fraction',
            src: '<?= base_url() ?>assets/maps.png',
            scale: 0.4 // Increased scale for better visibility
        }),
        // Add a drop shadow effect using a second style
        zIndex: 2
    });

    // Create a blue circle style for school markers with improved styling
    const schoolMarkerStyle = new ol.style.Style({
        image: new ol.style.Circle({
            radius: 10,
            fill: new ol.style.Fill({
                color: 'rgba(0, 102, 255, 0.8)'
            }),
            stroke: new ol.style.Stroke({
                color: '#fff',
                width: 3
            })
        }),
        zIndex: 1
    });

    // Create a red circle style for domisili markers with improved styling
    const domisiliMarkerStyle = new ol.style.Style({
        image: new ol.style.Circle({
            radius: 10,
            fill: new ol.style.Fill({
                color: 'rgba(255, 0, 0, 0.8)'
            }),
            stroke: new ol.style.Stroke({
                color: '#fff',
                width: 3
            })
        }),
        zIndex: 1
    });

    // Create a vector source for the school marker
    const schoolSource = new ol.source.Vector();

    // Create a feature for the school location with the custom image marker
    const schoolFeature = new ol.Feature({
        geometry: new ol.geom.Point(ol.proj.fromLonLat([schoolLatitude, schoolLongitude])),
        name: schoolName,
        type: 'school'
    });
    schoolFeature.setStyle(customMarkerStyle); // Use the custom image marker for the school
    schoolSource.addFeature(schoolFeature);

    // Create vector layer for school marker
    const schoolLayer = new ol.layer.Vector({
        source: schoolSource
    });

    // Create vector source and layer for other points (using blue circles)
    const vectorSource = new ol.source.Vector();
    const vectorLayer = new ol.layer.Vector({
        source: vectorSource,
        style: schoolMarkerStyle
    });

    // Create vector source and layer for domisili points (using red circles)
    const domisiliSource = new ol.source.Vector();
    const domisiliLayer = new ol.layer.Vector({
        source: domisiliSource,
        style: domisiliMarkerStyle
    });

    // Source and layer for routing lines
    const routeSource = new ol.source.Vector();
    const routeLayer = new ol.layer.Vector({
        source: routeSource,
        style: new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'rgba(0, 128, 255, 0.7)',
                width: 5,
                lineDash: [5, 5],
                lineDashOffset: 0
            }),
            zIndex: 10
        })
    });

    // Add all layers to the map
    map.addLayer(schoolLayer);   // Custom image marker for school
    map.addLayer(vectorLayer);   // Blue circles for other points
    map.addLayer(domisiliLayer); // Red circles for domisili points
    map.addLayer(routeLayer);    // Route lines

    // Function to add school markers to the map
    function addSchoolMarkers(schools) {
        // Clear existing markers
        vectorSource.clear();
        
        // Add markers for each school
        schools.forEach(function(school) {
            if (school.lat && school.lon) {
                const marker = new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat([parseFloat(school.lon), parseFloat(school.lat)])),
                    name: school.name,
                    id: school.id,
                    type: 'other_school',
                    coordinates: [parseFloat(school.lon), parseFloat(school.lat)]
                });
                
                vectorSource.addFeature(marker);
            }
        });
        
        // Zoom to fit all markers if there are any
        if (vectorSource.getFeatures().length > 0) {
            map.getView().fit(vectorSource.getExtent(), {
                padding: [100, 100, 100, 100], // Increased padding for better view
                maxZoom: 15
            });
        }
    }

    // Function to add domisili marker with coordinates stored
    function addDomisiliMarker(longitude, latitude, name) {
        const feature = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([longitude, latitude])),
            name: name,
            type: 'domisili',
            coordinates: [longitude, latitude]
        });
        domisiliSource.addFeature(feature);
    }

    // Create and style a custom popup container
    const container = document.createElement('div');
    container.className = 'ol-popup';
    container.style.position = 'absolute';
    container.style.backgroundColor = 'white';
    container.style.boxShadow = '0 2px 12px rgba(0,0,0,0.15)';
    container.style.padding = '15px';
    container.style.borderRadius = '8px';
    container.style.border = '1px solid #e0e0e0';
    container.style.minWidth = '200px';
    container.style.maxWidth = '300px';
    container.style.zIndex = '1000';
    container.style.transform = 'translate(-50%, -100%)';
    container.style.marginBottom = '-15px'; // Adjust the spacing between marker and popup

    // Add a small arrow at the bottom of the popup
    const arrow = document.createElement('div');
    arrow.style.position = 'absolute';
    arrow.style.bottom = '-10px';
    arrow.style.left = '50%';
    arrow.style.transform = 'translateX(-50%)';
    arrow.style.width = '0';
    arrow.style.height = '0';
    arrow.style.borderLeft = '10px solid transparent';
    arrow.style.borderRight = '10px solid transparent';
    arrow.style.borderTop = '10px solid white';
    arrow.style.zIndex = '1001';
    container.appendChild(arrow);

    // Add a close button to the popup
    const closer = document.createElement('a');
    closer.className = 'ol-popup-closer';
    closer.style.position = 'absolute';
    closer.style.top = '5px';
    closer.style.right = '5px';
    closer.style.textDecoration = 'none';
    closer.style.fontSize = '16px';
    closer.style.fontWeight = 'bold';
    closer.style.color = '#999';
    closer.style.cursor = 'pointer';
    closer.innerHTML = '×';
    closer.onclick = function() {
        popup.setPosition(undefined);
        selectedFeature = null;
        closer.blur();
        return false;
    };
    container.appendChild(closer);

    // Content container for the popup
    const content = document.createElement('div');
    content.className = 'ol-popup-content';
    container.appendChild(content);

    // Add popup overlay to the map
    const popup = new ol.Overlay({
        element: container,
        positioning: 'top-center',
        stopEvent: true, // Changed to true to prevent map interactions behind popup
        offset: [0, -15]
    });
    map.addOverlay(popup);

    // Variable to store the currently selected feature
    let selectedFeature = null;
    let endFeature = null;

    // Function to decode polyline for routing
    function decodePolyline(encoded) {
        const len = encoded.length;
        let index = 0;
        let lat = 0;
        let lng = 0;
        const points = [];

        while (index < len) {
            let b;
            let shift = 0;
            let result = 0;

            do {
                b = encoded.charCodeAt(index++) - 63;
                result |= (b & 0x1f) << shift;
                shift += 5;
            } while (b >= 0x20);

            const dlat = (result & 1) != 0 ? ~(result >> 1) : result >> 1;
            lat += dlat;

            shift = 0;
            result = 0;

            do {
                b = encoded.charCodeAt(index++) - 63;
                result |= (b & 0x1f) << shift;
                shift += 5;
            } while (b >= 0x20);

            const dlng = (result & 1) != 0 ? ~(result >> 1) : result >> 1;
            lng += dlng;

            points.push([lng * 1e-5, lat * 1e-5]);
        }

        return points;
    }

    // Create a route information container
    const routeInfoContainer = document.createElement('div');
    routeInfoContainer.className = 'route-info-legend';
    routeInfoContainer.style.position = 'absolute';
    routeInfoContainer.style.bottom = '10px';
    routeInfoContainer.style.left = '10px';
    routeInfoContainer.style.backgroundColor = 'white';
    routeInfoContainer.style.padding = '10px';
    routeInfoContainer.style.borderRadius = '4px';
    routeInfoContainer.style.boxShadow = '0 1px 4px rgba(0,0,0,0.2)';
    routeInfoContainer.style.zIndex = '1';
    routeInfoContainer.style.fontSize = '12px';
    routeInfoContainer.style.minWidth = '200px';
    routeInfoContainer.innerHTML = `
        <div style="font-weight: bold; margin-bottom: 10px;">Informasi Rute</div>
        <div id="route-details" style="margin-bottom: 10px;">
            <p style="margin: 3px 0; color: #666;">Klik pada dua lokasi berbeda untuk melihat informasi rute</p>
        </div>
        
    `;

    // Add the route info to the map
    map.getViewport().appendChild(routeInfoContainer);

    // Function to update the route info legend
    function updateRouteInfoLegend(startFeature, endFeature, summary) {
        const distance = summary.distance;
        const duration = summary.duration;

        // Format distance (meters to km if large)
        let distanceText = distance < 1000 ? 
            Math.round(distance) + ' m' : 
            (distance / 1000).toFixed(2) + ' km';

        // Format duration (seconds to minutes/hours)
        let durationText;
        if (duration < 60) {
            durationText = Math.round(duration) + ' detik';
        } else if (duration < 3600) {
            durationText = Math.round(duration / 60) + ' menit';
        } else {
            const hours = Math.floor(duration / 3600);
            const minutes = Math.round((duration % 3600) / 60);
            durationText = hours + ' jam ' + minutes + ' menit';
        }

        // Update the route info in the legend
        const routeDetailsElement = document.getElementById('route-details');
        if (routeDetailsElement) {
            routeDetailsElement.innerHTML = `
                <div style="margin-bottom: 5px; font-weight: bold;">Dari: ${startFeature.get('name')}</div>
                <div style="margin-bottom: 10px; font-weight: bold;">Ke: ${endFeature.get('name')}</div>
                <div style="display: flex; align-items: center; margin: 5px 0;">
                    <i class="fas fa-ruler" style="color: #4dabf7; margin-right: 5px; width: 15px;"></i>
                    <span>Jarak: ${distanceText}</span>
                </div>
                <div style="display: flex; align-items: center; margin: 5px 0;">
                    <i class="fas fa-clock" style="color: #4dabf7; margin-right: 5px; width: 15px;"></i>
                    <span>Waktu Tempuh: ${durationText}</span>
                </div>
                <div style="text-align: center; margin-top: 10px;">
                    <a href="https://www.google.com/maps/dir/?api=1&origin=${startFeature.get('coordinates')[1]},${startFeature.get('coordinates')[0]}&destination=${endFeature.get('coordinates')[1]},${endFeature.get('coordinates')[0]}&travelmode=driving" target="_blank" class="btn btn-primary" style="padding: 6px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 14px; border: none;">
                        <i class="fas fa-route" style="margin-right: 5px;"></i> Lihat Rute 
                    </a>
                </div>
                <div style="font-weight: bold; margin-top: 10px; border-top: 1px solid #eee; padding-top: 10px;">Rute Perjalanan</div>
        
        <div style="display: flex; align-items: center; margin-top: 5px;">
            <div style="width: 20px; height: 3px; background-color: rgba(0, 128, 255, 0.7); margin-right: 5px;"></div>
            <span>Motor/Mobil</span>
        </div>
            `;
        }
    }

    // Function to calculate route between two points
    function calculateRoute(start, end) {
        const routeData = {
            coordinates: [start, end]
        };

        const typeRout = [
            'foot-hiking',
            'foot-walking',
            'cycling-regular',
            'cycling-road',
            'cycling-mountain',
            'driving-car',
            'driving-hgv'
        ];
        const url = 'https://api.openrouteservice.org/v2/directions/' + typeRout[5];

        const headers = {
            'Accept': 'application/json, application/geo+json, application/gpx+xml, img/png; charset=utf-8',
            'Content-Type': 'application/json',
            'Authorization': '5b3ce3597851110001cf6248e515b644174f4b1d9b5e9767e8b4c611'
        };

        fetch(url, {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(routeData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            const geometry = data.routes[0].geometry;
            const route = new ol.geom.LineString(
                decodePolyline(geometry).map(coord => ol.proj.fromLonLat(coord))
            );

            // Clear previous routes
            routeSource.clear();

            // Create new route feature
            const routeFeature = new ol.Feature({
                geometry: route,
                distance: data.routes[0].summary.distance,
                duration: data.routes[0].summary.duration
            });

            routeSource.addFeature(routeFeature);

            // Update popup content with route information
            updatePopupWithRouteInfo(data.routes[0].summary);
            
            // Also update the route info legend
            updateRouteInfoLegend(selectedFeature, endFeature, data.routes[0].summary);
        })
        .catch(error => {
            console.error('Error calculating route:', error);
            content.innerHTML += '<p style="color: red;">Error calculating route. Please try again.</p>';
            document.getElementById('route-details').innerHTML = '<p style="color: red;">Error menghitung rute. Silakan coba lagi.</p>';
        });
    }

    // Function to update popup with route information
    function updatePopupWithRouteInfo(summary) {
        const distance = summary.distance;
        const duration = summary.duration;

        // Format distance (meters to km if large)
        let distanceText = distance < 1000 ? 
            Math.round(distance) + ' m' : 
            (distance / 1000).toFixed(2) + ' km';

        // Format duration (seconds to minutes/hours)
        let durationText;
        if (duration < 60) {
            durationText = Math.round(duration) + ' detik';
        } else if (duration < 3600) {
            durationText = Math.round(duration / 60) + ' menit';
        } else {
            const hours = Math.floor(duration / 3600);
            const minutes = Math.round((duration % 3600) / 60);
            durationText = hours + ' jam ' + minutes + ' menit';
        }

        // Add the route information to the existing popup content
        content.innerHTML += `
            <div class="route-info" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                <p style="margin: 5px 0; color: #666;"><i class="fas fa-ruler" style="color: #4dabf7; margin-right: 5px;"></i> Jarak: ${distanceText}</p>
                <p style="margin: 5px 0; color: #666;"><i class="fas fa-clock" style="color: #4dabf7; margin-right: 5px;"></i> Waktu Tempuh: ${durationText}</p>
            </div>`;
    }

    // Display popup on click
    map.on('click', function(evt) {
        const feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
            return feature;
        });
        
        if (feature) {
            const coordinates = feature.getGeometry().getCoordinates();
            popup.setPosition(coordinates);
            
            // Get coordinates for Google Maps
            const lonLat = ol.proj.toLonLat(coordinates);
            const longitude = lonLat[0].toFixed(6);
            const latitude = lonLat[1].toFixed(6);
            
            // Create Google Maps URL
            const googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
            
            if (feature.get('type') === 'domisili') {
                content.innerHTML = 
                    `<div class="popup-header" style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                        <h5 style="margin: 0; font-size: 16px; color: #333;">${feature.get('name')}</h5>
                    </div>
                    <div class="popup-body" style="margin-bottom: 10px;">
                        <p style="margin: 5px 0; color: #666;"><i class="fas fa-map-marker-alt" style="color: #ff6b6b; margin-right: 5px;"></i> Area Terdekat</p>
                    </div>
                    <div class="popup-footer" style="text-align: center;">
                        <a href="${googleMapsUrl}" target="_blank" class="btn btn-primary" style="display: inline-block; padding: 6px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 14px; border: none;">
                            <i class="fas fa-route" style="margin-right: 5px;"></i> Lihat Rute
                        </a>
                    </div>`;
            } else if (feature.get('type') === 'school' || feature.get('type') === 'other_school') {
                // For both main school and other schools
                content.innerHTML = 
                    `<div class="popup-header" style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                        <h5 style="margin: 0; font-size: 16px; color: #333;">${feature.get('name')}</h5>
                    </div>
                    <div class="popup-body" style="margin-bottom: 10px;">
                        <p style="margin: 5px 0; color: #666;"><i class="fas fa-school" style="color: #4dabf7; margin-right: 5px;"></i> Sekolah</p>
                    </div>
                    <div class="popup-footer" style="text-align: center;">
                        <a href="${googleMapsUrl}" target="_blank" class="btn btn-primary" style="display: inline-block; padding: 6px 12px; background-color: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 14px; border: none;">
                            <i class="fas fa-route" style="margin-right: 5px;"></i> Lihat Rute
                        </a>
                    </div>`;
                
                // Select this school in the dropdown if it has an ID
                if (feature.get('id')) {
                    $('#sekolah_1').val(feature.get('id')).trigger('change');
                }
            }

            // If we have a previously selected feature and it's different from the current one
            if (selectedFeature && selectedFeature !== feature && feature.get('coordinates')) {
                // Calculate route between the two features
                const startCoords = selectedFeature.get('coordinates');
                const endCoords = feature.get('coordinates');
                
                if (startCoords && endCoords) {
                    endFeature = feature;
                    calculateRoute(startCoords, endCoords);
                }
            } else {
                // Set this as the selected feature for potential future routing
                selectedFeature = feature;
            }
        } else {
            popup.setPosition(undefined);
            selectedFeature = null;
        }
    });

    // Add hover effect to markers
    const pointerMoveHandler = function(e) {
        if (e.dragging) {
            return;
        }
        
        const pixel = map.getEventPixel(e.originalEvent);
        const hit = map.hasFeatureAtPixel(pixel);
        
        map.getTargetElement().style.cursor = hit ? 'pointer' : '';
    };
    map.on('pointermove', pointerMoveHandler);

    // Initial jalur selection
    const jalurSelected = $('#jalur').find(":selected").val();

    $.ajax({
        type: "POST",
        url: "<?php echo base_url("sekolah/zonasi/get_sekolah"); ?>",
        data: {
            jalur: jalurSelected,
            'zonasi': '<?= $get->dusun ?>',
            'id_siswa': '<?= $get->id_siswa  ?>'
        },
        dataType: "JSON",
        beforeSend: function(e) {
            if (e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(response) {
            console.log(response.list_sekolah);
            $("#sekolah_1").html(response.list_sekolah).show();
            
            if (response.schools_data) {
                addSchoolMarkers(response.schools_data);
            }
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
        }
    });

    $("#jalur").change(function() {
        let jalur = $(this).val();
        
        // Clear previous markers
        domisiliSource.clear();
        routeSource.clear(); // Also clear route lines when changing jalur
        
        // Reset selected features
        selectedFeature = null;
        endFeature = null;
        
        // Load schools based on selected jalur
        $.ajax({
            type: "POST",
            url: "<?php echo base_url("sekolah/zonasi/get_sekolah"); ?>",
            data: {
                'jalur': jalur,
                'zonasi': '<?= $get->dusun ?>',
                'id_siswa': '<?= $get->id_siswa ?>',
            },
            dataType: "JSON",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            // Inside success callback for the "jalur" change event handler:
success: function(response) {
    $("#sekolah_1").html(response.list_sekolah).show();
    
    // If Area Domisili is selected
    if (jalur === "zonasi") {
        // Parse the options to get school names
        let parser = new DOMParser();
        let htmlDoc = parser.parseFromString(response.list_sekolah, 'text/html');
        let options = htmlDoc.querySelectorAll('option');
        
        // Ambil semua nama sekolah, kecuali yang kosong atau 'Pilih'
        let dataSekolah = [];
        
        options.forEach(option => {
            let text = option.textContent.trim();
            if (text !== "Pilih" && text !== "") {
                dataSekolah.push({
                    name: text,
                    id: option.value,
                    kordinat: option.getAttribute('data-kordinat')
                });
            }
        });
        console.log(dataSekolah);

        // Clear previous markers first
        domisiliSource.clear();

        // Style untuk marker dengan shadow effect
        const markerIconStyle = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                src: '<?= base_url() ?>assets/maps.png',
                scale: 0.4 // Increased size
            }),
            zIndex: 2
        });

        let processedCount = 0;

        // Add markers with delay effect for better visualization
        dataSekolah.forEach((school, index) => {
            const koordinatStr = school.kordinat;
            if (!koordinatStr) return;
            
            const [lintang, bujur] = koordinatStr.split(',').map(coord => parseFloat(coord.trim()));
            
            if (!isNaN(lintang) && !isNaN(bujur)) {
                const marker = new ol.Feature({
                    geometry: new ol.geom.Point(ol.proj.fromLonLat([bujur, lintang])),
                    name: school.name,
                    id: school.id,
                    type: 'domisili',
                    coordinates: [bujur, lintang] // Store raw coordinates for routing
                });
                
                marker.setStyle(markerIconStyle);
                
                // Add with delay for visual effect
                setTimeout(() => {
                    domisiliSource.addFeature(marker);
                    processedCount++;
                    
                    // When all features are added, fit the view
                    if (processedCount === dataSekolah.filter(s => s.kordinat).length) {
                        setTimeout(() => {
                            if (domisiliSource.getFeatures().length > 0) {
                                map.getView().fit(domisiliSource.getExtent(), {
                                    padding: [100, 100, 100, 100],
                                    maxZoom: 14
                                });
                            }
                        }, 100);
                    }
                }, index * 50);
            }
        });
    } else {
        // If not Area Domisili, just show schools on map
        if (response.schools_data) {
            addSchoolMarkers(response.schools_data);
        }
    }
},
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    });

    // Update map when school is selected with smooth animation
    $("#sekolah_1").on('change', function() {
        const selectedSchoolId = $(this).val();
        
        // First check in regular school layer
        let found = false;
        vectorSource.getFeatures().forEach(function(feature) {
            if (feature.get('id') == selectedSchoolId) {
                // Zoom to the selected school with smooth animation
                map.getView().animate({
                    center: feature.getGeometry().getCoordinates(),
                    zoom: 16,
                    duration: 1000
                });
                
                // Show popup for the selected school
                setTimeout(() => {
                    popup.setPosition(feature.getGeometry().getCoordinates());
                    content.innerHTML = 
                        `<div class="popup-header" style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                            <h5 style="margin: 0; font-size: 16px; color: #333;">${feature.get('name')}</h5>
                        </div>
                        <div class="popup-body" style="margin-bottom: 10px;">
                            <p style="margin: 5px 0; color: #666;"><i class="fas fa-school" style="color: #4dabf7; margin-right: 5px;"></i> Sekolah</p>
                        </div>`;
                }, 1000);
                found = true;
            }
        });
        
        // If not found in school layer, check in domisili layer
        if (!found) {
            domisiliSource.getFeatures().forEach(function(feature) {
                if (feature.get('id') == selectedSchoolId) {
                    // Zoom to the selected domisili point with smooth animation
                    map.getView().animate({
                        center: feature.getGeometry().getCoordinates(),
                        zoom: 16,
                        duration: 1000
                    });
                    
                    // Show popup for the selected domisili point with delay for better UX
                    setTimeout(() => {
                        popup.setPosition(feature.getGeometry().getCoordinates());
                        content.innerHTML = 
                            `<div class="popup-header" style="margin-bottom: 10px; border-bottom: 1px solid #eee; padding-bottom: 8px;">
                                <h5 style="margin: 0; font-size: 16px; color: #333;">${feature.get('name')}</h5>
                            </div>
                            <div class="popup-body" style="margin-bottom: 10px;">
                                <p style="margin: 5px 0; color: #666;"><i class="fas fa-map-marker-alt" style="color: #ff6b6b; margin-right: 5px;"></i> Jalur Terdekat</p>
                            </div>`;
                    }, 1000);
                }
            });
        }
    });

    // Add a legend to the map
    const legendContainer = document.createElement('div');
    legendContainer.className = 'map-legend';
    legendContainer.style.position = 'absolute';
    legendContainer.style.bottom = '10px';
    legendContainer.style.left = '10px';
    legendContainer.style.backgroundColor = 'white';
    legendContainer.style.padding = '10px';
    legendContainer.style.borderRadius = '4px';
    legendContainer.style.boxShadow = '0 1px 4px rgba(0,0,0,0.2)';
    legendContainer.style.zIndex = '1';
    legendContainer.style.fontSize = '12px';
    legendContainer.innerHTML = `
        
    `;
    
    // Add the legend to the map
    map.getViewport().appendChild(legendContainer);
    
    // Create layer switcher control UI
    const layerSwitcherContainer = document.createElement('div');
    layerSwitcherContainer.className = 'layer-switcher';
    layerSwitcherContainer.style.position = 'absolute';
    layerSwitcherContainer.style.top = '10px';
    layerSwitcherContainer.style.right = '10px';
    layerSwitcherContainer.style.backgroundColor = 'white';
    layerSwitcherContainer.style.padding = '10px';
    layerSwitcherContainer.style.borderRadius = '4px';
    layerSwitcherContainer.style.boxShadow = '0 1px 4px rgba(0,0,0,0.2)';
    layerSwitcherContainer.style.zIndex = '1';
    layerSwitcherContainer.style.fontSize = '12px';
    layerSwitcherContainer.innerHTML = `
        <div style="font-weight: bold; margin-bottom: 8px;">Pilih Layer Peta</div>
        <div class="progress-bar" style="display: flex; flex-direction: column; gap: 5px;">
            <a href="#" data-layer="OSM_Standard" class="active" style="display: flex; align-items: center; padding: 5px; text-decoration: none; color: #333; border-radius: 3px; background-color: #f0f0f0;">
                <span style="width: 12px; height: 12px; background-color: #337ab7; display: inline-block; margin-right: 8px; border-radius: 50%;"></span>
                OpenStreetMap
            </a>
            <a href="#" data-layer="OSM_Humanitarian" style="display: flex; align-items: center; padding: 5px; text-decoration: none; color: #333; border-radius: 3px;">
                <span style="width: 12px; height: 12px; background-color: #f0ad4e; display: inline-block; margin-right: 8px; border-radius: 50%;"></span>
                Humanitarian
            </a>
            <a href="#" data-layer="Google_Maps" style="display: flex; align-items: center; padding: 5px; text-decoration: none; color: #333; border-radius: 3px;">
                <span style="width: 12px; height: 12px; background-color: #d9534f; display: inline-block; margin-right: 8px; border-radius: 50%;"></span>
                Google Maps
            </a>
            <a href="#" data-layer="Satelite" style="display: flex; align-items: center; padding: 5px; text-decoration: none; color: #333; border-radius: 3px;">
                <span style="width: 12px; height: 12px; background-color: #5bc0de; display: inline-block; margin-right: 8px; border-radius: 50%;"></span>
                Satellite
            </a>
        </div>
    `;
    
    // Add the layer switcher to the map
    map.getViewport().appendChild(layerSwitcherContainer);
    
    // Add event listeners to layer switcher links
    const layerLinks = layerSwitcherContainer.querySelectorAll('.progress-bar a');
    layerLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            
            // Remove active class from all links
            layerLinks.forEach(l => {
                l.style.backgroundColor = '';
                l.classList.remove('active');
            });
            
            // Add active class to clicked link
            link.style.backgroundColor = '#f0f0f0';
            link.classList.add('active');
            
            const selectedLayer = link.getAttribute('data-layer');
            
            // Toggle layer visibility
            baseLayerGroup.getLayers().forEach(function(element) {
                const layerTitle = element.get('title');
                element.setVisible(layerTitle === selectedLayer);
            });
        });
    });
});
</script>

<script>
	// hapus semua session set_flashdata
	$(document).ready(function() {
		// Override semua fungsi toastr agar tidak melakukan apapun
		if (typeof toastr !== 'undefined') {
			toastr.success = function() {};
			toastr.info = function() {};
			toastr.warning = function() {};
			toastr.error = function() {};
			toastr.clear = function() {};
			toastr.remove = function() {};
			toastr.options = {}; // reset opsinya juga kalau perlu
		}
	});
</script>

<style>
	.progress-tracker {
		margin-bottom: 2rem;
		position: relative;
	}

	.progress-tracker ul::after {
		content: '';
		position: absolute;
		top: 25px;
		left: 0;
		width: 100%;
		height: 3px;
		background-color: #e0e0e0;
		z-index: 1;
	}

	.progress-step {
		position: relative;
		text-align: center;
		z-index: 2;
		width: 16.666%;
	}

	.progress-marker {
		position: relative;
		display: flex;
		height: 50px;
		width: 50px;
		margin: 0 auto 12px;
		background-color: #f5f7fa;
		border: 3px solid #e0e0e0;
		border-radius: 50%;
		justify-content: center;
		align-items: center;
		z-index: 3;
		transition: all 0.3s ease;
	}

	.progress-marker i {
		font-size: 20px;
		color: #6c757d;
		transition: all 0.3s ease;
	}

	.progress-text {
		padding: 0 8px;
	}

	.step-number {
		display: block;
		font-size: 12px;
		font-weight: 600;
		color: #6c757d;
	}

	.step-title {
		display: block;
		font-size: 14px;
		font-weight: 500;
		color: #6c757d;
	}

	/* Completed step */
	.progress-step.completed .progress-marker {
		background-color: rgba(var(--primary-rgb), 0.1);
		border-color: var(--primary);
	}

	.progress-step.completed .progress-marker i {
		color: var(--primary);
	}

	/* Active step */
	.progress-step.active .progress-marker {
		background-color: var(--primary);
		border-color: var(--primary);
		transform: scale(1.05);
		box-shadow: 0 0 12px rgba(var(--primary-rgb), 0.4);
	}

	.progress-step.active .progress-marker i {
		color: white;
	}

	.progress-step.active .step-number,
	.progress-step.active .step-title {
		color: var(--primary);
		font-weight: 700;
	}

	@media (max-width: 768px) {
		.progress-marker {
			height: 40px;
			width: 40px;
		}

		.progress-marker i {
			font-size: 16px;
		}

		.step-title {
			font-size: 12px;
		}

		.progress-tracker ul::after {
			top: 20px;
		}
	}
</style>