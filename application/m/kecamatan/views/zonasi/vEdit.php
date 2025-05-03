<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 "> <i class="ri-arrow-go-back-line "></i> Kembali </a>
				<div class="clearfix"></div>
				<div class="iq-advance-course ">
					
					<form action="<?= base_url()?>kecamatan/zonasi/update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?= $get->id_master_zonasi ?>">
						<div class="form-group">
							<label for=""> Kecamatan <span class="text-danger">*</span> </label>
							<select name="kecamatan" class="form-control" id="">
								<option value=""> Pilih Kecamatan </option>
								<?php foreach ($kecamatan AS $value): ?>
									<option value="<?= $value->id_kec ?> " <?=  ($value->id_kec == $get->kecamatan) ? "selected":"";  ?>  > <?= $value->nama_kec ?> </option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<div class="form-group">
							<label for=""> Nama Daerah Zonasi <span class="text-danger">*</span> </label>
							<input type="text" class="form-control" name="daerah" autocomplete="off" value="<?= $get->daerah_zonasi ?>" required>
						</div>
						
						<hr>
						<button class="btn btn-primary pull-right" type="submit"> <i class="ri-save-line"></i>  Simpan  </button>
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
