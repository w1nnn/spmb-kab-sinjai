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
    // Koordinat dari database
    const schoolLongitude = <?php echo $longitude; ?>;
    const schoolLatitude = <?php echo $latitude; ?>;
    const schoolName = "<?= $nama_sekolah ?>"; 
    console.log(schoolLongitude)
    // Initialize the map
    const map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            // Center on the school location
            center: ol.proj.fromLonLat([schoolLatitude, schoolLongitude]),
            zoom: 15
        })
    });

    // Create custom marker style using the maps.png image
    const customMarkerStyle = new ol.style.Style({
        image: new ol.style.Icon({
            anchor: [0.5, 1], // Anchor at the bottom center of the image
            anchorXUnits: 'fraction',
            anchorYUnits: 'fraction',
            src: '<?= base_url() ?>assets/maps.png',
            scale: 0.3 // Adjust scale as needed
        })
    });

    // Create a blue circle style for school markers
    const schoolMarkerStyle = new ol.style.Style({
        image: new ol.style.Circle({
            radius: 8,
            fill: new ol.style.Fill({
                color: '#0066ff'
            }),
            stroke: new ol.style.Stroke({
                color: '#fff',
                width: 2
            })
        })
    });

    // Create a red circle style for domisili markers
    const domisiliMarkerStyle = new ol.style.Style({
        image: new ol.style.Circle({
            radius: 8,
            fill: new ol.style.Fill({
                color: '#ff0000'
            }),
            stroke: new ol.style.Stroke({
                color: '#fff',
                width: 2
            })
        })
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

    // Add all layers to the map
    map.addLayer(schoolLayer);   // Custom image marker for school
    map.addLayer(vectorLayer);   // Blue circles for other points
    map.addLayer(domisiliLayer); // Red circles for domisili points

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
                    type: 'other_school'
                });
                
                vectorSource.addFeature(marker);
            }
        });
        
        // Zoom to fit all markers if there are any
        if (vectorSource.getFeatures().length > 0) {
            map.getView().fit(vectorSource.getExtent(), {
                padding: [50, 50, 50, 50],
                maxZoom: 15
            });
        }
    }

    // Function to add domisili marker
    function addDomisiliMarker(longitude, latitude, name) {
        const feature = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([longitude, latitude])),
            name: name,
            type: 'domisili'
        });
        domisiliSource.addFeature(feature);
    }

    // Add popup overlay for school information
    const container = document.createElement('div');
    container.className = 'ol-popup';

    const popup = new ol.Overlay({
        element: container,
        positioning: 'bottom-center',
        stopEvent: false,
        offset: [0, -10]
    });
    map.addOverlay(popup);

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
                container.innerHTML = '<div style="background: white; padding: 10px; border-radius: 5px; box-shadow: 0 1px 4px rgba(0,0,0,0.2);">' +
                    '<h5>' + feature.get('name') + '</h5>' +
                    '<p>Area Terdekat</p>' +
                    '<p><a href="' + googleMapsUrl + '" target="_blank" class="btn btn-sm btn-primary">Lihat Rute</a></p>' +
                    '</div>';
            } else if (feature.get('type') === 'school' || feature.get('type') === 'other_school') {
                // For both main school and other schools
                container.innerHTML = '<div style="background: white; padding: 10px; border-radius: 5px; box-shadow: 0 1px 4px rgba(0,0,0,0.2);">' +
                    '<h5>' + feature.get('name') + '</h5>' +
                    // '<p>Sekolah</p>' +
                    '<p><a href="' + googleMapsUrl + '" target="_blank" class="btn btn-sm btn-primary">Lihat Rute</a></p>' +
                    '</div>';
                
                // Select this school in the dropdown if it has an ID
                if (feature.get('id')) {
                    $('#sekolah_1').val(feature.get('id')).trigger('change');
                }
            }
        } else {
            // popup.setPosition(undefined);
        }
    });

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


            // Kerjakan Ini
            success: function(response) {
                // console.log(response.list_sekolah);
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

// Style untuk marker
const markerIconStyle = new ol.style.Style({
    image: new ol.style.Icon({
        anchor: [0.5, 1],
        anchorXUnits: 'fraction',
        anchorYUnits: 'fraction',
        src: '<?= base_url() ?>assets/maps.png',
        scale: 0.3
    })
});

// Style untuk garis penghubung
const lineStyle = new ol.style.Style({
    stroke: new ol.style.Stroke({
        color: 'rgba(0, 128, 255, 0.8)',
        width: 2,
        lineDash: [5, 5]
    })
});

// Sumber dan layer untuk garis penghubung
const connectingLineSource = new ol.source.Vector();
const connectingLineLayer = new ol.layer.Vector({
    source: connectingLineSource,
    style: lineStyle,
    zIndex: 100 // Pastikan garis muncul di atas marker
});

// Tambahkan layer garis ke peta
map.addLayer(connectingLineLayer);

let processedCount = 0;
domisiliSource.clear();

// Tambahkan marker ke peta
dataSekolah.forEach((school, index) => {
    const koordinatStr = school.kordinat;
    const [lintang, bujur] = koordinatStr.split(',').map(coord => parseFloat(coord.trim()));
    
    if (!isNaN(lintang) && !isNaN(bujur)) {
        const marker = new ol.Feature({
            geometry: new ol.geom.Point(ol.proj.fromLonLat([bujur, lintang])),
            name: school.name,
            id: school.id,
            type: 'domisili',
            coordinates: [bujur, lintang] // Simpan koordinat asli untuk membuat garis
        });
        
        marker.setStyle(markerIconStyle);
        domisiliSource.addFeature(marker);
        
        processedCount++;
    } else {
        // console.error(`Invalid coordinates: ${koordinatStr}`);
    }
});

// Fit map view jika ada marker
if (domisiliSource.getFeatures().length > 0) {
    map.getView().fit(domisiliSource.getExtent(), {
        padding: [50, 50, 50, 50],
        maxZoom: 15
    });
}

// Fungsi untuk membuat garis penghubung
function createConnectingLines(hoveredFeature) {
    // Hapus garis yang ada
    connectingLineSource.clear();
    
    if (!hoveredFeature) return;
    
    // Koordinat dari marker yang di-hover
    const hoveredCoords = hoveredFeature.get('coordinates');
    const hoveredPoint = ol.proj.fromLonLat(hoveredCoords);
    
    // Buat garis ke semua marker lain
    const features = domisiliSource.getFeatures();
    features.forEach(feature => {
        if (feature !== hoveredFeature) {
            const featureCoords = feature.get('coordinates');
            const featurePoint = ol.proj.fromLonLat(featureCoords);
            
            // Buat garis penghubung
            const line = new ol.Feature({
                geometry: new ol.geom.LineString([hoveredPoint, featurePoint])
            });
            
            connectingLineSource.addFeature(line);
        }
    });
}

// Tambahkan event pointer move untuk hover
let currentHoveredFeature = null;

map.on('pointermove', function(e) {
    if (e.dragging) return;
    
    const pixel = map.getEventPixel(e.originalEvent);
    const hit = map.hasFeatureAtPixel(pixel);
    
    map.getTargetElement().style.cursor = hit ? 'pointer' : '';
    
    // Cek apakah pointer berada di atas feature
    let hoveredFeature = null;
    map.forEachFeatureAtPixel(pixel, function(feature, layer) {
        if (feature.get('type') === 'domisili') {
            hoveredFeature = feature;
            return true; // Hentikan iterasi
        }
    });
    
    // Jika fitur yang di-hover berubah
    if (hoveredFeature !== currentHoveredFeature) {
        currentHoveredFeature = hoveredFeature;
        createConnectingLines(currentHoveredFeature);
    }
});

// Tambahkan event untuk menghapus garis saat mouse meninggalkan peta
map.getViewport().addEventListener('mouseout', function() {
    currentHoveredFeature = null;
    connectingLineSource.clear();
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

    // Update map when school is selected
    $("#sekolah_1").on('change', function() {
        const selectedSchoolId = $(this).val();
        
        // First check in regular school layer
        let found = false;
        vectorSource.getFeatures().forEach(function(feature) {
            if (feature.get('id') == selectedSchoolId) {
                // Zoom to the selected school
                map.getView().animate({
                    center: feature.getGeometry().getCoordinates(),
                    zoom: 16,
                    duration: 1000
                });
                
                // Show popup for the selected school
                popup.setPosition(feature.getGeometry().getCoordinates());
                container.innerHTML = '<div style="background: white; padding: 10px; border-radius: 5px; box-shadow: 0 1px 4px rgba(0,0,0,0.2);">' +
                    '<h5>' + feature.get('name') + '</h5>' +
                    '</div>';
                found = true;
            }
        });
        
        // If not found in school layer, check in domisili layer
        if (!found) {
            domisiliSource.getFeatures().forEach(function(feature) {
                if (feature.get('id') == selectedSchoolId) {
                    // Zoom to the selected domisili point
                    map.getView().animate({
                        center: feature.getGeometry().getCoordinates(),
                        zoom: 16,
                        duration: 1000
                    });
                    
                    // Show popup for the selected domisili point
                    popup.setPosition(feature.getGeometry().getCoordinates());
                    container.innerHTML = '<div style="background: white; padding: 10px; border-radius: 5px; box-shadow: 0 1px 4px rgba(0,0,0,0.2);">' +
                        '<h5>' + feature.get('name') + '</h5>' +
                        '<p>Jalur Terdekat</p>' +
                        '</div>';
                }
            });
        }
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