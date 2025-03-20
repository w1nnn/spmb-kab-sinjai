<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 "> <i class="ri-arrow-go-back-line "></i> Kembali </a>
				<div class="clearfix"></div>
				<div class="iq-advance-course ">

					<form action="<?= base_url()?>users/manage/update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?= $get->id ?>">
						<div class="form-group">
							<label for=""> Nama <span class="text-danger">*</span> </label>
							<input type="text" value="<?= $get->nama ?>" class="form-control" name="nama" autocomplete="off" required>
						</div>

						<div class="form-group">
							<label for=""> Username  <span class="text-danger">*</span> </label>
							<input type="text" class="form-control" value="<?= $get->username ?>" name="username" autocomplete="off" required>
						</div>
						<div class="form-group">
							<label for=""> Password </label>
							<input type="password" class="form-control" name="password" autocomplete="off" placeholder="Kosongkan jika tidak ingin mengubah password">
						</div>
						<div class="form-group">
							<label for=""> Ulang Password </label>
							<input type="password" class="form-control" name="repassword" autocomplete="off" placeholder="Kosongkan jika tidak ingin mengubah password">
						</div>
						<div class="form-group">
							<label for=""> Level  <span class="text-danger">*</span> </label>
							<select class="form-control" name="level">
								<option <?= $get->level == 'admin' ? 'selected' : '' ?> value="admin">Admin</option>
								<option <?= $get->level == 'kadis' ? 'selected' : '' ?> value="kadis">Kadis</option>
								<option <?= $get->level == 'superadmin' ? 'selected' : '' ?> value="superadmin">Super Admin</option>
							</select>
						</div>
						<hr>

						<button class="btn btn-primary pull-right" type="submit"> <i class="ri-refresh-line "></i>  Update  </button>
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
