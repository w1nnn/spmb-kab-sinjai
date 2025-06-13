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
				<!-- <input type="text" name="kuota_lulusan" id="kuota_lulusan"> -->
                <div id="quota_info"></div>
                <!-- Cek semua pendaftar yang memilih sekolah 1 -->
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
	<button class="btn btn-primary pull-right btn-lanjut" type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>

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
$('#sekolah_1').on('change', function() {
  var selectedSchool = $(this).val();
  // console.log(selectedSchool);
  
  if (selectedSchool) {
    $.ajax({
      type: "POST",
      url: "<?= base_url('sekolah/get_school_quota') ?>",
      data: {
        school_name: selectedSchool
      },
      dataType: "JSON",
      success: function(response) {
        if (response.exists) {
          if (response.quota > 0) {
            const quotaLeft = response.quota - response.pendaftar;
            
            if (quotaLeft > 0) {
              $('#quota_info').html('<span class="text-success">Kuota tersisa:</span> ' + '<b>' + quotaLeft + '</b>');
              $('.btn-lanjut').attr('disabled', false);
            } else {
              $('#quota_info').html('<span class="text-danger">Kuota sudah penuh, silahkan pilih sekolah lain!</span>');
              $('.btn-lanjut').attr('disabled', true);
            }
          } else {
            $('#quota_info').html('<span class="text-danger">Tidak ada Kuota lulusan Tersedia!</span>');
            $('.btn-lanjut').attr('disabled', true);
          }
        } else {
          $('#quota_info').html('');
          $('.btn-lanjut').attr('disabled', false);
        }
      }
    });
  } else {
    $('#quota_info').html('');
    $('.btn-lanjut').attr('disabled', false);
  }
});
</script>
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
    // console.log(schoolLongitude);

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
            src: '<?= base_url() ?>assets/marker.png', // Path to your custom marker image
            scale: 0.05
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
        <div id="route-details" style="margin-bottom: 10px; text-align: center;">
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
        
                <div style="display: flex; justify-content: center; gap: 20px;">
                <div style="text-align: center;">
                    <svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M280 32c-13.3 0-24 10.7-24 24s10.7 24 24 24l57.7 0 16.4 30.3L256 192l-45.3-45.3c-12-12-28.3-18.7-45.3-18.7L64 128c-17.7 0-32 14.3-32 32l0 32 96 0c88.4 0 160 71.6 160 160c0 11-1.1 21.7-3.2 32l70.4 0c-2.1-10.3-3.2-21-3.2-32c0-52.2 25-98.6 63.7-127.8l15.4 28.6C402.4 276.3 384 312 384 352c0 70.7 57.3 128 128 128s128-57.3 128-128s-57.3-128-128-128c-13.5 0-26.5 2.1-38.7 6L418.2 128l61.8 0c17.7 0 32-14.3 32-32l0-32c0-17.7-14.3-32-32-32l-20.4 0c-7.5 0-14.7 2.6-20.5 7.4L391.7 78.9l-14-26c-7-12.9-20.5-21-35.2-21L280 32zM462.7 311.2l28.2 52.2c6.3 11.7 20.9 16 32.5 9.7s16-20.9 9.7-32.5l-28.2-52.2c2.3-.3 4.7-.4 7.1-.4c35.3 0 64 28.7 64 64s-28.7 64-64 64s-64-28.7-64-64c0-15.5 5.5-29.7 14.7-40.8zM187.3 376c-9.5 23.5-32.5 40-59.3 40c-35.3 0-64-28.7-64-64s28.7-64 64-64c26.9 0 49.9 16.5 59.3 40l66.4 0C242.5 268.8 190.5 224 128 224C57.3 224 0 281.3 0 352s57.3 128 128 128c62.5 0 114.5-44.8 125.8-104l-66.4 0zM128 384a32 32 0 1 0 0-64 32 32 0 1 0 0 64z"/></svg>
                    <div>
                        <input type="radio" checked name="route" value="cycling-mountain"> 
                    </div>
                </div>
                <div style="text-align: center;">
                    <svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M171.3 96L224 96l0 96-112.7 0 30.4-75.9C146.5 104 158.2 96 171.3 96zM272 192l0-96 81.2 0c9.7 0 18.9 4.4 25 12l67.2 84L272 192zm256.2 1L428.2 68c-18.2-22.8-45.8-36-75-36L171.3 32c-39.3 0-74.6 23.9-89.1 60.3L40.6 196.4C16.8 205.8 0 228.9 0 256L0 368c0 17.7 14.3 32 32 32l33.3 0c7.6 45.4 47.1 80 94.7 80s87.1-34.6 94.7-80l130.7 0c7.6 45.4 47.1 80 94.7 80s87.1-34.6 94.7-80l33.3 0c17.7 0 32-14.3 32-32l0-48c0-65.2-48.8-119-111.8-127zM434.7 368a48 48 0 1 1 90.5 32 48 48 0 1 1 -90.5-32zM160 336a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                    <div>
                        <input type="radio" name="route" value="driving-car" disabled> 
                    </div>
                </div>
                <div style="text-align: center;">
                        <svg width="10" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M160 48a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zM126.5 199.3c-1 .4-1.9 .8-2.9 1.2l-8 3.5c-16.4 7.3-29 21.2-34.7 38.2l-2.6 7.8c-5.6 16.8-23.7 25.8-40.5 20.2s-25.8-23.7-20.2-40.5l2.6-7.8c11.4-34.1 36.6-61.9 69.4-76.5l8-3.5c20.8-9.2 43.3-14 66.1-14c44.6 0 84.8 26.8 101.9 67.9L281 232.7l21.4 10.7c15.8 7.9 22.2 27.1 14.3 42.9s-27.1 22.2-42.9 14.3L247 287.3c-10.3-5.2-18.4-13.8-22.8-24.5l-9.6-23-19.3 65.5 49.5 54c5.4 5.9 9.2 13 11.2 20.8l23 92.1c4.3 17.1-6.1 34.5-23.3 38.8s-34.5-6.1-38.8-23.3l-22-88.1-70.7-77.1c-14.8-16.1-20.3-38.6-14.7-59.7l16.9-63.5zM68.7 398l25-62.4c2.1 3 4.5 5.8 7 8.6l40.7 44.4-14.5 36.2c-2.4 6-6 11.5-10.6 16.1L54.6 502.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L68.7 398z"/></svg>
                    <div>
                        <input type="radio" name="route" value="foot-walking" disabled> 
                    </div>
                </div>
                <div style="text-align: center;">
                    <svg width="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path d="M312 32c-13.3 0-24 10.7-24 24s10.7 24 24 24l25.7 0 34.6 64-149.4 0-27.4-38C191 99.7 183.7 96 176 96l-56 0c-13.3 0-24 10.7-24 24s10.7 24 24 24l43.7 0 22.1 30.7-26.6 53.1c-10-2.5-20.5-3.8-31.2-3.8C57.3 224 0 281.3 0 352s57.3 128 128 128c65.3 0 119.1-48.9 127-112l49 0c8.5 0 16.3-4.5 20.7-11.8l84.8-143.5 21.7 40.1C402.4 276.3 384 312 384 352c0 70.7 57.3 128 128 128s128-57.3 128-128s-57.3-128-128-128c-13.5 0-26.5 2.1-38.7 6L375.4 48.8C369.8 38.4 359 32 347.2 32L312 32zM458.6 303.7l32.3 59.7c6.3 11.7 20.9 16 32.5 9.7s16-20.9 9.7-32.5l-32.3-59.7c3.6-.6 7.4-.9 11.2-.9c39.8 0 72 32.2 72 72s-32.2 72-72 72s-72-32.2-72-72c0-18.6 7-35.5 18.6-48.3zM133.2 368l65 0c-7.3 32.1-36 56-70.2 56c-39.8 0-72-32.2-72-72s32.2-72 72-72c1.7 0 3.4 .1 5.1 .2l-24.2 48.5c-9 18.1 4.1 39.4 24.3 39.4zm33.7-48l50.7-101.3 72.9 101.2-.1 .1-123.5 0zm90.6-128l108.5 0L317 274.8 257.4 192z"/></svg>
                    <div>
                        <input type="radio" name="route" value="cycling-regular" disabled> 
                    </div>
                </div>
            </div>
            `;
        }
    }

    let selectedRouteType = 'cycling-regular'; // Default route type
    window.addEventListener('change', function(event) {
    const target = event.target;
    if (target && target.name === 'route' && target.type === 'radio') {
        selectedRouteType = target.value;
        console.log('Selected route type:', selectedRouteType);
    }
});



    // Function to calculate route between two points
    function calculateRoute(start, end) {
    const routeData = {
        coordinates: [start, end]
    };


    const url = 'https://api.openrouteservice.org/v2/directions/' + selectedRouteType;

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

        routeSource.clear();

        const routeFeature = new ol.Feature({
            geometry: route,
            distance: data.routes[0].summary.distance,
            duration: data.routes[0].summary.duration
        });

        routeSource.addFeature(routeFeature);
        updatePopupWithRouteInfo(data.routes[0].summary);
        updateRouteInfoLegend(selectedFeature, endFeature, data.routes[0].summary);
    })
    .catch(error => {
        console.error('Error calculating route:', error);
        content.innerHTML += '<p style="color: red;">Error calculating route. Please try again.</p>';
        document.getElementById('route-details').innerHTML = '<p style="color: red;">Gagal menghitung rute. Silakan coba lagi.</p>';
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
            // console.log(response.list_sekolah);
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
        // console.log(dataSekolah);

        // Clear previous markers first
        domisiliSource.clear();

        // Style untuk marker dengan shadow effect
        const markerIconStyle = new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 1],
                anchorXUnits: 'fraction',
                anchorYUnits: 'fraction',
                src: '<?= base_url() ?>assets/marker.png', // Path to your custom marker image',
                scale: 0.05 // Increased size
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
                <span style="margin-right: 5px;">
                 <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-stack" viewBox="0 0 16 16">
  <path d="m14.12 10.163 1.715.858c.22.11.22.424 0 .534L8.267 15.34a.6.6 0 0 1-.534 0L.165 11.555a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0l5.317-2.66zM7.733.063a.6.6 0 0 1 .534 0l7.568 3.784a.3.3 0 0 1 0 .535L8.267 8.165a.6.6 0 0 1-.534 0L.165 4.382a.299.299 0 0 1 0-.535z"/>
  <path d="m14.12 6.576 1.715.858c.22.11.22.424 0 .534l-7.568 3.784a.6.6 0 0 1-.534 0L.165 7.968a.299.299 0 0 1 0-.534l1.716-.858 5.317 2.659c.505.252 1.1.252 1.604 0z"/>
</svg>
                </span> 
                 OpenStreetMap
            </a>
            <a href="#" data-layer="OSM_Humanitarian" style="display: flex; align-items: center; padding: 5px; text-decoration: none; color: #333; border-radius: 3px;">
                <span style="margin-right: 5px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map-fill" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M16 .5a.5.5 0 0 0-.598-.49L10.5.99 5.598.01a.5.5 0 0 0-.196 0l-5 1A.5.5 0 0 0 0 1.5v14a.5.5 0 0 0 .598.49l4.902-.98 4.902.98a.5.5 0 0 0 .196 0l5-1A.5.5 0 0 0 16 14.5zM5 14.09V1.11l.5-.1.5.1v12.98l-.402-.08a.5.5 0 0 0-.196 0zm5 .8V1.91l.402.08a.5.5 0 0 0 .196 0L11 1.91v12.98l-.5.1z"/>
</svg></span>
                Humanitarian
            </a>
            <a href="#" data-layer="Google_Maps" style="display: flex; align-items: center; padding: 5px; text-decoration: none; color: #333; border-radius: 3px;">
                <span style="margin-right: 5px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
  <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6"/>
</svg></span>
                Google Maps
            </a>
            <a href="#" data-layer="Satelite" style="display: flex; align-items: center; padding: 5px; text-decoration: none; color: #333; border-radius: 3px;">
                <span style="margin-right: 5px;">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe-americas" viewBox="0 0 16 16">
  <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0M2.04 4.326c.325 1.329 2.532 2.54 3.717 3.19.48.263.793.434.743.484q-.121.12-.242.234c-.416.396-.787.749-.758 1.266.035.634.618.824 1.214 1.017.577.188 1.168.38 1.286.983.082.417-.075.988-.22 1.52-.215.782-.406 1.48.22 1.48 1.5-.5 3.798-3.186 4-5 .138-1.243-2-2-3.5-2.5-.478-.16-.755.081-.99.284-.172.15-.322.279-.51.216-.445-.148-2.5-2-1.5-2.5.78-.39.952-.171 1.227.182.078.099.163.208.273.318.609.304.662-.132.723-.633.039-.322.081-.671.277-.867.434-.434 1.265-.791 2.028-1.12.712-.306 1.365-.587 1.579-.88A7 7 0 1 1 2.04 4.327Z"/>
</svg></span>
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