<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="lanjut" value="orangtua">
	<input type="hidden" name="page" value="sekolah">

	<div class="row mb-0">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<?php
$nik = $get->no_ktp;
$this->db->where('nik', $nik);
$query = $this->db->get('tbl_status_dtks');

if ($query->num_rows() > 0) {
    $dtks_data = $query->row();
    $status = $dtks_data->status;
    
    if ($status == 'Terdaftar') {
        echo '<div class="alert alert-success" role="alert">
                <i class="ri-checkbox-circle-line mr-2"></i> Selamat NIK Anda Terdaftar di DTKS
              </div>';
    } elseif ($status == 'Tidak Terdaftar') {
        echo '<div class="alert alert-danger" role="alert">
                <i class="ri-close-circle-line mr-2"></i> Mohon Maaf NIK Anda Tidak Terdaftar di DTKS
              </div>';
    } elseif ($status == 'NIK Tidak Valid') {
        echo '<div class="alert alert-warning text-dark" role="alert">
                <i class="ri-error-warning-line mr-2"></i> NIK Tidak Valid, Silakan Periksa Kembali
              </div>';
    } else {
        echo '<div class="alert alert-info" role="alert">
                <i class="ri-information-line mr-2"></i> Proses Verifikasi DTKS
              </div>';
    }
} else {
    echo '<div class="alert alert-secondary" role="alert">
            <i class="ri-question-line mr-2"></i> Data Tidak Ditemukan - Proses Verifikasi DTKS
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
					<label for=""> Pilih Area <span class="text-danger">*</span> </label>
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
			<div id="quota_info"></div>
			<!-- NPSN -->
			 <div id="npsn_info"></div>
		</div>
	</div>
	<hr>
	<div id="map_container">
		<?php
		include "response.php";
		?>
	</div>		
	<button class="btn btn-primary pull-right btn-lanjut mt-4" type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>

	<?php if (level_user() == "siswa") { ?>
		<a href="<?= base_url() ?>siswa/profil/datadiri" class="btn mt-4 btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } else { ?>
		<a href="<?= base_url() ?>siswa/edit/datadiri?id=<?= $get->id_siswa ?>" class="btn mt-4 btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } ?>

</form>

<script>
$('#sekolah_1').on('change', function() {
  var selectedSchool = $(this).val();
  var npsn = document.querySelector('#npsn_info');
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
            $('#quota_info').html('<span class="text-danger">Tidak ada Kuota Pendaftar Tersedia!</span>');
            $('.btn-lanjut').attr('disabled', true);
          }
        } else {
          $('#quota_info').html('');
          $('.btn-lanjut').attr('disabled', false);
        }
      }
    });

    $.ajax({
      type: "POST",
      url: "<?= base_url() ?>/request.php",
      data: {
        selectedSchool: selectedSchool
      },
      success: function(mapHtml) {
        $('#map_container').html(mapHtml);
      },
      error: function() {
        console.log('Error fetching school map');
      }
    });
    
  } else {
    $('#quota_info').html('');
    $('.btn-lanjut').attr('disabled', false);
    $('#map_container').html(''); 
  }
});
</script>

<script>
	$(document).ready(function() {
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
			},
			error: function(xhr, ajaxOptions, thrownError) {
				alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
			}
		});

		// Load sekolah ketika jalur diubah
		$("#jalur").change(function() {
			let jalur = $(this).val();
			
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
				},
				error: function(xhr, ajaxOptions, thrownError) {
					alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
				}
			});
		});
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