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
    // Initialize the map

    const map = new ol.Map({
        target: 'map',
        layers: [
            new ol.layer.Tile({
                source: new ol.source.OSM()
            })
        ],
        view: new ol.View({
            // Default center coordinates (can be adjusted to your region)
            center: ol.proj.fromLonLat([120.150347, -5.201962]),
            zoom: 12
        })
    });

    // Create a vector source to hold school markers
    const vectorSource = new ol.source.Vector();
    
    // Create a vector layer for school markers with blue style
    const vectorLayer = new ol.layer.Vector({
        source: vectorSource,
        style: function() {
            return new ol.style.Style({
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
        }
    });
    
    // Create a vector source for domisili markers
    const domisiliSource = new ol.source.Vector();
    
    // Create a vector layer for domisili markers with RED style
    const domisiliLayer = new ol.layer.Vector({
        source: domisiliSource,
        style: function() {
            return new ol.style.Style({
                image: new ol.style.Circle({
                    radius: 8,
                    fill: new ol.style.Fill({
                        color: '#ff0000'  // Red color for domisili markers
                    }),
                    stroke: new ol.style.Stroke({
                        color: '#fff',
                        width: 2
                    })
                })
            });
        }
    });
    
    map.addLayer(vectorLayer);
    map.addLayer(domisiliLayer);

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
                    id: school.id
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
            
            if (feature.get('type') === 'domisili') {
                const lonLat = ol.proj.toLonLat(coordinates);
                const longitude = lonLat[0].toFixed(6);
                const latitude = lonLat[1].toFixed(6);
                
                // Create Google Maps URL
                const googleMapsUrl = `https://www.google.com/maps?q=${latitude},${longitude}`;
                
                container.innerHTML = '<div style="background: white; padding: 10px; border-radius: 5px; box-shadow: 0 1px 4px rgba(0,0,0,0.2);">' +
                    '<h5>' + feature.get('name') + '</h5>' +
                    '<p>Area Terdekat</p>' +
                    '<p><a href="' + googleMapsUrl + '" target="_blank" class="btn btn-sm btn-primary">Lihat Rute</a></p>' +
                    '</div>';
            } else {
                // This is a school
                container.innerHTML = '<div style="background: white; padding: 10px; border-radius: 5px; box-shadow: 0 1px 4px rgba(0,0,0,0.2);">' +
                    '<h5>' + feature.get('name') + '</h5>' +
                    '</div>';
                
                // Select this school in the dropdown
                if (feature.get('id')) {
                    $('#sekolah_1').val(feature.get('id')).trigger('change');
                }
            }
        } else {
            popup.setPosition(undefined);
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
            success: function(response) {
                $("#sekolah_1").html(response.list_sekolah).show();
                
                // If Area Domisili is selected
                if (jalur === "zonasi") {
                    // Parse the options to get school names
                    let parser = new DOMParser();
                    let htmlDoc = parser.parseFromString(response.list_sekolah, 'text/html');
                    let options = htmlDoc.querySelectorAll('option');
                    
                    // Ambil semua nama sekolah, kecuali yang kosong atau 'Pilih'
                    let namaSekolah = [];
                    // console.log(namaSekolah);
                    
                    options.forEach(option => {
                        let text = option.textContent.trim();
                        if (text !== "Pilih" && text !== "") {
                            namaSekolah.push({
                                name: text,
                                id: option.value
                            });
                        }
                    });
                    
                    // Add domisili markers based on collected school names
                    let processedCount = 0;
                    
                    // Function to add domisili markers and update map when all are loaded
                    function addDomisiliMarker(nama, id) {
                        let url = `https://api-sekolah-indonesia.vercel.app/sekolah?npsn=${encodeURIComponent(id)}`;
                        
                        fetch(url)
                            .then(response => response.json())
                            .then(data => {
                                if (data.dataSekolah && data.dataSekolah.length > 0) {
                                    let bujur = data.dataSekolah[0].bujur;
                                    let lintang = data.dataSekolah[0].lintang;
                                    
                                    // Create a feature for this domisili point
                                    const marker = new ol.Feature({
                                        geometry: new ol.geom.Point(ol.proj.fromLonLat([parseFloat(bujur), parseFloat(lintang)])),
                                        name: nama,
                                        id: id,
                                        type: 'domisili'
                                    });
                                    
                                    domisiliSource.addFeature(marker);
                                }
                                
                                processedCount++;
                                
                                // If all schools have been processed, fit map to show all markers
                                if (processedCount === namaSekolah.length && domisiliSource.getFeatures().length > 0) {
                                    map.getView().fit(domisiliSource.getExtent(), {
                                        padding: [50, 50, 50, 50],
                                        maxZoom: 15
                                    });
                                }
                            })
                            .catch(error => {
                                console.error(`Gagal mengambil data untuk ${nama}:`, error);
                                processedCount++;
                            });
                    }
                    
                    // Process each school to get coordinates
                    namaSekolah.forEach(school => {
                        addDomisiliMarker(school.name, school.id);
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