<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="lanjut" value="datadiri">
	<input type="hidden" name="page" value="jalur">
	<div class="row">
		<div class="col">
			<div class="card text-white bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-white text-center">
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
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
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
				<label for=""> Tingkatan Sekolah <span class="text-danger">*</span> </label>
				<select name="tingkat" class="form-control" id="" required>
					<option value=""> Pilih </option>
					<?php foreach ($tingkat AS $value): $selected = ($value->id == $get->tingkat_sekolah ) ? "selected":"";    ?>
						<option value="<?= $value->id ?>" <?= $selected ?> > <?= $value->level_sekolah ?> </option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="form-group">
				<label for=""> Jalur Pendaftaran  <span class="text-danger">*</span> </label>
				<select name="jalur" class="form-control" id="" required>
					<option value=""> Pilih </option>
					<?php foreach ($jalur AS $value): $selected = ($value->id == $get->jalur) ? "selected":"";    ?>
						<option value="<?= $value->id ?>" <?= $selected ?>> <?= $value->nama ?> </option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>
		
	</div>
	<hr>
	<button class="btn btn-primary pull-right " type="submit"> Selanjutnya <i class="ri-arrow-right-fill"></i></button>

</form>
