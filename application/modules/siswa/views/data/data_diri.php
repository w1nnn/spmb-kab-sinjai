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
<?php
$eUsia = $this->session->userdata('error_usia');
$statusError = $this->session->userdata('status_error');
$message = $this->session->userdata('error_message');

// Jangan lupa untuk menghapus data setelah digunakan
if ($eUsia == 'usia' && $statusError == 'danger') {
	$this->session->unset_userdata('error_usia');
	$this->session->unset_userdata('status_error');
	$this->session->unset_userdata('error_message');
?>
	<script>
		$(document).ready(function() {
			$('#uploadModal').modal('show');
		});
	</script>
<?php } ?>


<!-- Modal Upload File -->
<div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="uploadModalLabel">Upload File Bukti Surat Keterangan Psikolog</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php
				$hasLampiran = !empty($get->lampiran_psikolog);
				?>

				<form action="<?= base_url('siswa/update_psikolog') ?>" method="POST" enctype="multipart/form-data">
					<div class="form-group">
						<label for="fileUpload" style="color: red; font-style: italic;">
							<?= $message ?? "Untuk melanjutkan proses pendaftaran silakan unggah surat keterangan dari psikolog:"; ?>
						</label>

						<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
						<input type="hidden" name="lanjut" value="sekolah">
						<input type="hidden" name="page" value="datadiri">

						<?php if ($hasLampiran): ?>
							<p class="text-success">✅ File sebelumnya sudah diunggah:</p>
							<a href="<?= base_url('uploads/siswa/psikolog/' . $get->lampiran_psikolog) ?>" target="_blank" class="btn btn-outline-info btn-sm">
								Lihat File
							</a>
							<p class="mt-2">Jika ingin mengganti file, unggah file baru di bawah ini:</p>
						<?php endif; ?>

						<input name="lampiran" type="file" class="form-control-file" id="fileUpload" accept=".jpg,.jpeg,.png,.pdf" <?= !$hasLampiran ? 'required' : '' ?>>
					</div>

					<div id="filePreview" class="form-group" style="display:none;">
						<div id="previewContainer"></div>
					</div>

					<hr>
					<p>
						<input type="checkbox" required>
						Saya nyatakan data yang saya unggah benar-benar sesuai dengan data yang asli dan saya siap mendapatkan sanksi apabila di kemudian hari data yang saya unggah terbukti rekayasa.
					</p>

					<button type="submit" class="btn btn-primary" id="submitBtn">Upload</button>
				</form>

			</div>
		</div>
	</div>
</div>
<!-- Modal end -->
<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="lanjut" value="sekolah">
	<input type="hidden" name="page" value="datadiri">
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
        <i class="mr-2"></i> Proses Verifikasi DTKS
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
					<li class="progress-step active">
						<div class="progress-marker">
							<i class="ri-user-2-fill"></i>
						</div>
						<div class="progress-text">
							<span class="step-number">2</span>
							<span class="step-title">Data Diri</span>
						</div>
					</li>
					<li class="progress-step">
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
		<div class="col-md-6">
			<div class="form-group">
				<label for=""> Nomor Induk Kependudukan <span class="text-danger">*</span> </label>
				<input type="number" readonly maxlength="16" oninput="this.value=this.value.slice(0,this.maxLength)" value="<?= $get->no_ktp ?>" class="form-control" name="no_ktp" required>
			</div>
			<div class="form-group">
				<label for=""> Nama Calon Siswa <span class="text-danger">*</span> </label>
				<input type="text" readonly value="<?= $get->nama_siswa ?>" class="form-control" name="nama_siswa" required>
			</div>
			<div class="form-group">
				<label for=""> Tempat Lahir <span class="text-danger">*</span> </label>
				<input autocomplete="off" type="text" value="<?= $get->tempat_lahir ?>" class="form-control" name="tempat_lahir" required>
			</div>
			<div class="form-group">
				<label for=""> Tanggal Lahir <span class="text-danger">*</span> </label>
				<input type="date" value="<?= $get->tgl_lahir ?>" class="form-control" name="tgl_lahir" required>
			</div>
			<div class="form-group">
				<label for=""> Jenis Kelamin <span class="text-danger">*</span> </label>
				<select name="jk" class="form-control" id="" required>
					<option value=""> Pilih</option>
					<option value="L" <?= ($get->jk == "L") ? "selected" : ""; ?>> Laki - Laki</option>
					<option value="P" <?= ($get->jk == "P") ? "selected" : ""; ?>> Perempuan</option>
				</select>
			</div>
			<div class="form-group">
				<label for=""> Agama <span class="text-danger">*</span> </label>
				<select name="agama" class="form-control" id="" required>
					<option value=""> Pilih</option>
					<option value="Islam" <?= ($get->agama == "Islam") ? "selected" : ""; ?>> Islam</option>
					<option value="Katolik" <?= ($get->agama == "Katolik") ? "selected" : ""; ?>> Katolik</option>
					<option value="Protestan" <?= ($get->agama == "Protestan") ? "selected" : ""; ?>> Protestan
					</option>
					<option value="Hindu" <?= ($get->agama == "Hindu") ? "selected" : ""; ?>> Hindu</option>
					<option value="Budha" <?= ($get->agama == "Budha") ? "selected" : ""; ?>> Budha</option>
				</select>
			</div>
		</div>
		<div class="col-md-6">

			<div class="form-group">
				<label for=""> Ukuran Baju <span class="text-danger">*</span> </label>
				<!-- <input type="text" name="ukuran_baju" class="form-control" value="<?= $get->ukuran_baju ?>" required> -->
				<select class="form-control" name="ukuran_baju" required>
					<option value="">Pilih Ukuran Baju</option>
					<?php
					$ub = ['S', 'M', 'L', 'XL', 'XXL'];
					?>
					<?php foreach ($ub as $key => $vb) : ?>
						<option <?php echo $vb == $get->ukuran_baju ? 'selected' : '' ?> value="<?php echo $vb ?>"><?php echo $vb ?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<?php if ($get->tingkat_sekolah != "4") {  ?>
				<!-- <div class="form-group">
					<label for=""> Asal Sekolah <span class="text-danger">*</span> </label>
					<input autocomplete="off" type="text" class="form-control" name="asal_sekolah" value="<?= $get->asal_sekolah ?>">
				</div> -->
				<div class="form-group">
					<label for=""> Asal Sekolah <span class="text-danger">*</span> </label>
					<select name="asal_sekolah" class="form-control select2 sekolah" id="sekolah_1" style="width: 100%;" required data-tags="true">
						<option value=""></option>
						<?php if(!empty($get->asal_sekolah)): ?>
							<option value="<?= $get->asal_sekolah ?>" selected><?= $get->asal_sekolah ?></option>
						<?php endif; ?>
					</select>
					<!-- <small id="quota_info" class="form-text text-muted"></small> -->
					<!-- Input Kuota Update -->
					 <input type="hidden" name="kuota_lulusan" id="kuota_lulusan">
				</div>
			<?php } ?>
			<div class="form-group">
				<label for=""> Alamat Rumah <span class="text-danger">*</span> </label>
				<textarea autocomplete="off" name="alamat" class="form-control" required><?= $get->alamat ?> </textarea>
			</div>
			<div class="form-group">
				<label for=""> Kecamatan <span class="text-danger">*</span> </label>
				<select name="kec" class="form-control select2 kecamatan" id="kecamatan" required data-tags="true">
					<option value="">Pilih Kecamatan</option>
					<?php foreach ($kecamatan as $value) : $selected = ($get->kec == $value->id_kec) ? "selected" : ""; ?>
						<option value="<?= $value->id_kec ?>" <?= $selected ?>> <?= $value->nama_kec ?> </option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for=""> Desa / Dusun / Jalan / Lingkungan Tempat Tinggal <span class="text-danger">*</span>
				</label>
				<select name="dusun" class="form-control select2" id="zonasi" required data-tags="true">
					<option value=""></option>
				</select>
			</div>
		</div>
	</div>
	<hr>
	<button class="btn btn-primary btn-lanjut pull-right" type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>
	<?php if (level_user() == "siswa") { ?>
		<a href="<?= base_url() ?>siswa/profil" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } else { ?>
		<a href="<?= base_url() ?>siswa/edit?id=<?= $get->id_siswa ?>" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>

	<?php } ?>
</form>
<!-- Menambahkan SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>

<script>


$(document).ready(function() {
	// $('#sekolah_1').select2({
    //     tags: true, // Memungkinkan input manual
    //     placeholder: "Pilih atau ketik nama sekolah",
    //     allowClear: true
    // });
    // Initialize select2
    $('.select2').select2({
		tags: true,
        placeholder: "Pilih Sekolah Asal",
        allowClear: true
    });

    // Load schools with Ajax
    loadSekolahAsal();

    function loadSekolahAsal() {
        $.ajax({
            type: "POST",
            url: "<?= base_url('sekolah/get_all_sekolah') ?>",
            dataType: "JSON",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
            },
            success: function(response) {
                $("#sekolah_1").html(response.list_sekolah).show();
                
                // Preserve selected value if exists
                <?php if(!empty($get->asal_sekolah)): ?>
                $("#sekolah_1").val("<?= $get->asal_sekolah ?>").trigger('change');
                <?php endif; ?>
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
            }
        });
    }
    
    // Display quota information when a school is selected
    $('#sekolah_1').on('change', function() {
        var selectedSchool = $(this).val();
        
        if (selectedSchool) {
            $.ajax({
                type: "POST",
                url: "<?= base_url('sekolah/get_school_quota') ?>",
                data: { school_name: selectedSchool },
                dataType: "JSON",
                success: function(response) {
                    if (response.exists) {
                        if (response.quota > 0) {
                            $('#quota_info').html('<span class="text-success">Kuota tersisa:</span> ' + '<b>' + response.quota +'</b>');
							// $('.btn-lanjut').attr('disabled', false);
							// Tampung nilai kuota
							var quotaLulusanUpdate = response.quota - 1;
							$('#kuota_lulusan').val(quotaLulusanUpdate);
						} else {
                            $('#quota_info').html('<span class="text-danger">Tidak ada Kuota lulusan Tersedia!</span>');
							// $('.btn-lanjut').attr('disabled', true);
                        }
                    } else {
                        $('#quota_info').html('');
                    }
                }
            });
        } else {
            $('#quota_info').html('');
        }
    });
});
	// alert($('.kecamatan').find(":selected").val());
	$(document).ready(function() {
		if ('<?php echo $eUsia ?>' == 'usia') {
			$("input[name='tgl_lahir']").focus();
		}
		const kecamatanDefault = $('.kecamatan').find(":selected").val();

		$.ajax({
			type: "POST",
			url: "<?php echo base_url("sekolah/zonasi/getDaerahKecamatan"); ?>",
			data: {
				kecamatan: kecamatanDefault,
				'id_siswa': '<?= $get->id_siswa  ?>'
			}, // data yang akan dikirim ke file yang dituju
			dataType: "JSON",
			beforeSend: function(e) {
				if (e && e.overrideMimeType) {
					e.overrideMimeType("application/json;charset=UTF-8");
				}
			},
			success: function(response) {
				$("#zonasi").html(response.list_daerah).show();

			},
			error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
				alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
			}
		});

		$("#kecamatan").change(function() {

			const kecamatanValue = $('.kecamatan').val();

			$.ajax({
				type: "POST",
				url: "<?php echo base_url("sekolah/zonasi/getDaerahKecamatan"); ?>",
				data: {
					kecamatan: kecamatanValue,
					'id_siswa': '<?= $get->id_siswa  ?>'
				}, // data yang akan dikirim ke file yang dituju
				dataType: "JSON",
				beforeSend: function(e) {
					if (e && e.overrideMimeType) {
						e.overrideMimeType("application/json;charset=UTF-8");
					}
				},
				success: function(response) {
					$("#zonasi").html(response.list_daerah).show();

				},
				error: function(xhr, ajaxOptions, thrownError) { // Ketika ada error
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError); // Munculkan alert error
				}
			});
		});
	});
</script>
<!-- <script>
	// Menampilkan preview dan validasi file
	$(document).ready(function() {
		// Menampilkan modal upload file jika ada error dan status 'danger'
		<?php if ($eUsia && $statusError == 'danger'): ?>
			$('#uploadModal').modal('show');
		<?php endif; ?>

		// File input change handler
		$('#fileUpload').change(function() {
			// Get the file input value and file size
			var file = this.files[0];
			var fileSize = file.size / 1024; // Size in KB
			var fileName = file.name;
			var fileExtension = fileName.split('.').pop().toLowerCase();

			// Validasi file extension (hanya gambar dan pdf)
			var validExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
			if ($.inArray(fileExtension, validExtensions) == -1) {
				alert("File harus berupa gambar (JPG, JPEG, PNG) atau PDF.");
				$('#fileUpload').val(''); // Clear the input
				$('#filePreview').hide(); // Hide preview
				return;
			}

			// Validasi ukuran file (maksimal 500 KB)
			if (fileSize > 500) {
				alert("Ukuran file maksimal 500 KB.");
				$('#fileUpload').val(''); // Clear the input
				$('#filePreview').hide(); // Hide preview
				return;
			}

			// Menampilkan preview file berdasarkan jenis file
			if (fileExtension == 'pdf') {
				// Jika file PDF
				$('#filePreview').show();
				$('#previewContainer').html('<embed src="' + URL.createObjectURL(file) + '" width="100%" height="400px" type="application/pdf">');
			} else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
				// Jika file gambar
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#filePreview').show();
					$('#previewContainer').html('<img src="' + e.target.result + '" class="img-fluid" alt="Preview">');
				};
				reader.readAsDataURL(file);
			}
		});
	});
</script> -->
<script>
	// Menampilkan preview dan validasi file
	$(document).ready(function() {
		// Menampilkan modal upload file jika error dan status 'danger'
		<?php if ($eUsia && $statusError == 'danger'): ?>
			$('#uploadModal').modal('show');
		<?php endif; ?>

		// File input change handler
		$('#fileUpload').change(function() {
			// Get the file input value and file size
			var file = this.files[0];
			var fileSize = file.size / 1024; // Size in KB
			var fileName = file.name;
			var fileExtension = fileName.split('.').pop().toLowerCase();

			// Validasi file extension (hanya gambar dan pdf)
			var validExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
			if ($.inArray(fileExtension, validExtensions) == -1) {
				// Menampilkan alert menggunakan SweetAlert2
				Swal.fire({
					icon: 'error',
					title: 'File tidak valid!',
					text: 'File harus berupa gambar (JPG, JPEG, PNG) atau PDF.'
				});
				$('#fileUpload').val(''); // Clear the input
				$('#filePreview').hide(); // Hide preview
				return;
			}

			// Validasi ukuran file (maksimal 500 KB)
			if (fileSize > 500) {
				// Menampilkan alert menggunakan SweetAlert2
				Swal.fire({
					icon: 'error',
					title: 'Ukuran file terlalu besar!',
					text: 'Ukuran file maksimal 500 KB.'
				});
				$('#fileUpload').val(''); // Clear the input
				$('#filePreview').hide(); // Hide preview
				return;
			}

			// Menampilkan preview file berdasarkan jenis file
			if (fileExtension == 'pdf') {
				// Jika file PDF
				$('#filePreview').show();
				$('#previewContainer').html('<embed src="' + URL.createObjectURL(file) + '" width="100%" height="400px" type="application/pdf">');
			} else if (['jpg', 'jpeg', 'png'].includes(fileExtension)) {
				// Jika file gambar
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#filePreview').show();
					$('#previewContainer').html('<img src="' + e.target.result + '" class="img-fluid" alt="Preview">');
				};
				reader.readAsDataURL(file);
			}
		});
	});
</script>