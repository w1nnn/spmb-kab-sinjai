<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 "> <i class="ri-arrow-go-back-line "></i> Kembali </a>
				<div class="clearfix"></div>
				<div class="iq-advance-course ">

					<form action="<?= base_url()?>users/manage/save" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label for=""> Nama  <span class="text-danger">*</span> </label>
							<input type="text" class="form-control" name="nama" autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for=""> Username  <span class="text-danger">*</span> </label>
							<input type="text" class="form-control" name="username" autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for=""> Password  <span class="text-danger">*</span> </label>
							<input type="password" class="form-control" name="password" autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for=""> Ulang Password  <span class="text-danger">*</span> </label>
							<input type="password" class="form-control" name="repassword" autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for=""> Level  <span class="text-danger">*</span> </label>
							<select class="form-control" name="level">
								<option value="admin">Admin</option>
								<option value="kadis">Kadis</option>
								<option value="superadmin">Super Admin</option>
							</select>
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
