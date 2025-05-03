<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

<div class="row">
	<div class="col-sm-12">
		<form action="<?= base_url() ?>profil/manage/update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="act" value="ppdb">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<div class="iq-advance-course ">
						<div class="form-group">
							<label for=""> Penjelasan Singkat SPMB </label>
							<!-- Mengganti textarea dengan ID untuk CKEditor -->
							<textarea name="ppdb" class="form-control" id="template"> <?= $get->ppdb ?> </textarea>
						</div>
						<div class="form-group">
							<label for=""> Lampiran File PDF </label>
							<a href="<?= base_url() ?>uploads/etc/<?= $get->lampiran ?> " target="_blank"> Lihat Lampiran </a>
							<input type="file" class="form-control-file" name="lampiran">
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
<!-- Menyertakan CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>

<script>
	// Inisialisasi CKEditor
	ClassicEditor
		.create(document.querySelector('#template'))
		.catch(error => {
			console.error(error);
		});
</script>