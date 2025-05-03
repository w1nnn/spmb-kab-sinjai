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
						echo '<div class="alert alert-warning" role="alert">
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
						<option value="zonasi"> Area Domisili</option>
						<option value="all"> Area Jarak Terdekat</option>
					</select>
				</div>
			<?php } ?>

			<div class="form-group">
				<label for=""> Sekolah Pilihan <span class="text-danger">*</span> </label>
				<select name="sekolah_pilihan_1" class="form-control select2 sekolah" id="sekolah_1" style="width: 100%;" required>
					<option value=""></option>
				</select>
			</div>

			<!-- GIS Map Section -->
			<div class="card mt-4">
				<div class="card-header">
					<h5 class="card-title">Peta Lokasi Sekolah</h5>
				</div>
				<div class="card-body">
					<div id="map" style="width: 100%; height: 400px;"></div>
				</div>
			</div>
			<!-- End GIS Map Section -->

		</div>
	</div>
	<hr>
	<p class="text-danger">** Sekolah tampil berdasarkan jalur yang dipilih dan daerah tempat tinggal kecuali jalur
		prestasi </p>
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
				center: ol.proj.fromLonLat([120.150347, -5.201962]), // Default to Bandung, Indonesia
				zoom: 12
			})
		});

		// Create a vector source to hold school markers
		const vectorSource = new ol.source.Vector();
		
		// Create a vector layer for school markers
		const vectorLayer = new ol.layer.Vector({
			source: vectorSource,
			style: new ol.style.Style({
				image: new ol.style.Icon({
					anchor: [0.5, 1],
					src: 'https://cdn.jsdelivr.net/npm/ol@v7.4.0/examples/data/icon.png' // Default marker
				})
			})
		});
		
		map.addLayer(vectorLayer);

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
				
				container.innerHTML = '<div style="background: white; padding: 10px; border-radius: 5px; box-shadow: 0 1px 4px rgba(0,0,0,0.2);">' +
					'<h5>' + feature.get('name') + '</h5>' +
					'</div>';
				
				// Select this school in the dropdown
				$('#sekolah_1').val(feature.get('id')).trigger('change');
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
			}, // data yang akan dikirim ke file yang dituju
			dataType: "JSON",
			beforeSend: function(e) {
				if (e && e.overrideMimeType) {
					e.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			success: function(response) {
				$("#sekolah_1").html(response.list_sekolah).show();
				
				// If there's school location data, add it to the map
				if (response.schools_data) {
					addSchoolMarkers(response.schools_data);
				}
			},
			error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
				alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
			}
		});

		$("#jalur").change(function() {
			let jalur;
			let url;
			
			url = "<?php echo base_url("sekolah/zonasi/get_sekolah"); ?>";
			jalur = $("#jalur").val();

			$.ajax({
				type: "POST",
				url: url,
				data: {
					'jalur': $("#jalur").val(),
					'zonasi': '<?= $get->dusun ?>',
					'id_siswa': '<?= $get->id_siswa ?>',
				}, // data yang akan dikirim ke file yang dituju
				dataType: "JSON",
				beforeSend: function(e) {
					if (e && e.overrideMimeType) {
						e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function(response) {
					// Misal response.list_sekolah isinya:
					// <option value=''>Pilih  </option><option value='40304700'>SD NEGERI 162 DUMME</option><option value='40304728'>SD NEGERI 127 TAKKALALA</option>

					let parser = new DOMParser();
					let htmlDoc = parser.parseFromString(response.list_sekolah, 'text/html');
					let options = htmlDoc.querySelectorAll('option');

					// Ambil semua nama sekolah, kecuali yang kosong atau 'Pilih'
					let namaSekolah = [];

					options.forEach(option => {
					let text = option.textContent.trim();
					if (text !== "Pilih" && text !== "") {
						namaSekolah.push(text);
					}
					});


					function cariSekolah(nama) {
					let url = `https://api-sekolah-indonesia.vercel.app/sekolah/s?sekolah=${encodeURIComponent(nama)}`;

					fetch(url)
						.then(response => response.json())
						.then(data => {
						let bujur = data.dataSekolah[0].bujur;
						let lintang = data.dataSekolah[0].lintang;
						console.log(bujur, lintang);
						})
						.catch(error => {
						console.error(`Gagal mengambil data untuk ${nama}:`, error);
						});
					}
					namaSekolah.forEach(sekolah => {
					cariSekolah(sekolah);
					});

					$("#sekolah_1").html(response.list_sekolah).show();
					
					// If there's school location data, add it to the map
					if (response.schools_data) {
						addSchoolMarkers(response.schools_data);
					}
				},
				error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
				}
			});
		});

		// Update map when school is selected
		$("#sekolah_1").on('change', function() {
			const selectedSchoolId = $(this).val();
			
			// Highlight the selected school on the map
			vectorSource.getFeatures().forEach(function(feature) {
				if (feature.get('id') == selectedSchoolId) {
					// Zoom to the selected school
					map.getView().animate({
						center: feature.getGeometry().getCoordinates(),
						zoom: 20,
						duration: 1000
					});
					
					// Show popup for the selected school
					popup.setPosition(feature.getGeometry().getCoordinates());
					container.innerHTML = '<div style="background: white; padding: 10px; border-radius: 5px; box-shadow: 0 1px 4px rgba(0,0,0,0.2);">' +
						'<h5>' + feature.get('name') + '</h5>' +
						'</div>';
				}
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