<div class="row">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<div class="row">
					<div class="col-md-12">
						<form action="<?= base_url()?>sekolah/save" method="POST">
							<input type="hidden" name="kab" value="7303">
							<div class="form-group">
								<label for=""> Tingkat </label>
								<select name="tingkat" class="form-control" id="" required>
									<option value=""> Pilih </option>
									<?php foreach($tingkats AS $tingkat){ ?>
										<option value="<?= $tingkat->id ?> "> <?= $tingkat->level_sekolah ?> </option>
									<?php }?>
								</select>
							</div>
							<div class="form-group">
								<label for=""> NPSN </label>
								<input type="text" class="form-control" name="npsn">
							</div>
							<div class="form-group">
								<label for=""> Nama Sekolah </label>
								<input type="text" class="form-control" name="nama">
							</div>
							<div class="form-group">
								<label for=""> Alamat </label>
								<input type="text" class="form-control" name="alamat">
							</div>
							<div class="form-group">
								<label for=""> Kelurahan </label>
								<input type="text" class="form-control" name="kel">
							</div>
							<div class="form-group">
								<label for=""> Kecamatan </label>
								<select name="kec" class="form-control" id="" required>
									<option value=""> Pilih </option>
									<?php foreach($kecamatans AS $kecamatan){ ?>
										<option value="<?= $kecamatan->id_kec ?> "> <?= $kecamatan->nama_kec ?> </option>
									<?php }?>
								</select>
							</div>
							<div class="form-group">
								<label for=""> Status </label>
								<select name="status" class="form-control" id="" required>
									<option value=""> Pilih </option>
									<option value="NEGERI"> NEGERI </option>
									<option value="SWASTA"> SWASTA </option>
								</select>
							</div>
							<div class="form-group">
								<label for=""> Email </label>
								<input type="text" class="form-control" name="email">
							</div>
							<div class="form-group">
								<label for=""> No HP Operator </label>
								<input type="text" class="form-control" name="no_hp">
							</div>
							<div class="form-group">
								<label for=""> No HP Kepala Sekolah </label>
								<input type="text" class="form-control" name="no_hp_kepsek">
							</div>
							<button class="btn btn-primary" type="submit" > Simpan </button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
