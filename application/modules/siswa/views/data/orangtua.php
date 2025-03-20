<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="lanjut" value="lampiran">
	<input type="hidden" name="page" value="orangtua">
	
	<div class="row">
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-guide-fill fs-30"></i> <br>
						1. Jalur
					</h5>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-user-2-fill fs-30"></i> <br>
						2. Data Diri
					</h5>
				</div>
			</div>
		</div>
		
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-building-fill fs-30"></i> <br>
						3. Sekolah
					</h5>
				</div>
			</div>
		</div>
		
		
		<div class="col">
			<div class="card text-white bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-white text-center">
						<i style="font-size:30px;" class="ri-parent-fill fs-30"></i> <br>
						4. Orang Tua
					</h5>
				</div>
			</div>
		</div>
		
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-booklet-fill fs-30"></i> <br>
						5. Dokumen
					</h5>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-folder-chart-fill fs-30"></i> <br>
						6. Selesai
					</h5>
				</div>
			</div>
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for=""> Nomor Kartu Keluarga <span class="text-danger">*</span> </label>
				<input type="text" name="no_kk" class="form-control" value="<?= $get->no_kk ?>" required>
			</div>
			<div class="form-group">
				<label for=""> Nomor Handphone Ayah / Ibu <span class="text-danger">*</span> </label>
				<input type="text" name="no_hp_ortu" class="form-control" value="<?= $get->no_hp_ortu ?>" required>
			</div>
			<div class="form-group">
				<label for=""> Nama Ayah <span class="text-danger">*</span> </label>
				<input type="text" name="nama_ayah" class="form-control" value="<?= $get->nm_ayah ?>" required>
			</div>
			<div class="form-group">
				<label for=""> Pekerjaan Ayah <span class="text-danger">*</span> </label>
				<input type="text" name="pekerjaan_ayah" class="form-control" value="<?= $get->pekerjaan_ayah ?>" required>
			</div>
			
			<div class="form-group">
				<label for=""> Nama Ibu <span class="text-danger">*</span> </label>
				<input type="text" name="nama_ibu" class="form-control" value="<?= $get->nm_ibu ?> " required>
			</div>
			<div class="form-group">
				<label for=""> Pekerjaan Ibu <span class="text-danger">*</span> </label>
				<input type="text" name="pekerjaan_ibu" class="form-control" value="<?= $get->pekerjaan_ibu ?> " required>
			</div>
			
			<div class="form-group">
				<label for=""> Nama Wali </label>
				<input type="text" name="nama_wali" class="form-control" value="<?= $get->nm_wali ?> ">
			</div>
			<div class="form-group">
				<label for=""> Pekerjaan Wali </label>
				<input type="text" name="pekerjaan_wali" class="form-control" value="<?= $get->pekerjaan_wali ?> ">
			</div>
		</div>
	
	</div>
	<hr>
	<button class="btn btn-primary pull-right " type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>
	
	<?php if(level_user() == "siswa"){ ?>
	<a href="<?= base_url() ?>siswa/profil/sekolah" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php }else{ ?>
	<a href="<?= base_url() ?>siswa/edit/sekolah?id=<?= $get->id_siswa ?>" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>

	<?php }?>

	<!-- <a href="<?= base_url()?>siswa/profil" class="btn btn-warning pull-right mr-3 " > <i class="ri-arrow-left-fill"></i> Kembali </a> -->
	
</form>


