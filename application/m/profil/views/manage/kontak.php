<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

<?php if ($this->input->get('alert')): ?>
	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				timerProgressBar: true
			});

			Toast.fire({
				icon: '<?= $this->input->get('alert') ?>',
				title: '<?= $this->input->get('message') ?>'
			});

			// Hapus parameter alert & message dari URL tanpa reload
			if (history.pushState) {
				const url = new URL(window.location);
				url.searchParams.delete('alert');
				url.searchParams.delete('message');
				window.history.replaceState({}, document.title, url.toString());
			}
		});
	</script>
<?php endif; ?>