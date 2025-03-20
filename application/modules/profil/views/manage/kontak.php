<div class="row ">
	<div class="col-sm-12">
		<form action="<?= base_url() ?>profil/manage/update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="act" value="kontak">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<div class="iq-advance-course ">
						<div class="form-group">
							<label for="">Alamat </label>
							<textarea name="alamat" class="form-control"><?= $get->alamat  ?></textarea>
						</div>
						<div class="form-group">
							<label for="">Nomor Handphone</label>
							<input type="text" name="hp" class="form-control" value="<?= $get->hp  ?>">
						</div>
						<div class="form-group">
							<label for="">Nomor WhatsApp</label>
							<input type="text" name="wa" class="form-control" value="<?= $get->wa ?>">
						</div>
						<div class="form-group">
							<label for="">E-mail</label>
							<input type="text" name="email" class="form-control" value="<?= $get->email  ?>">
						</div>
						<div class="form-group">
							<label for="">Akun Facebook</label>
							<input type="text" name="fb" class="form-control" value="<?= $get->fb  ?>">
						</div>
						<div class="form-group">
							<label for="">Akun Instagram </label>
							<input type="text" name="ig" class="form-control" value="<?= $get->ig  ?>">
						</div>
						<div class="form-group">
							<label for="">Akun Twitter</label>
							<!-- <input type="text" name="twitter" class="form-control" value="<?= $get->twitter  ?>"> -->
							<input type="text" name="twitter" class="form-control" value="@SPMB Sinjai">
						</div>


						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="reset" class="btn iq-bg-danger">Batal</button>

					</div>
				</div>
			</div>
		</form>
	</div>
</div>