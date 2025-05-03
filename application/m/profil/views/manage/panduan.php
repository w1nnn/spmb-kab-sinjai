<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

<div class="row">
	<div class="col-sm-12">
		<form action="<?= base_url() ?>profil/manage/update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="act" value="panduan">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<div class="iq-advance-course">
						<div class="form-group">
							<label for="">Upload File Panduan Pendaftaran (PDF)</label>
							<input type="file" class="form-control-file" name="panduan" accept="application/pdf">
						</div>
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="reset" class="btn iq-bg-danger">Batal</button>
						<hr>

						<?php if (isset($get) && !empty($get->panduan)): ?>
							<!-- Tombol Download jika file ada -->
							<a href="<?= base_url('uploads/panduan/' . $get->panduan) ?>" class="btn btn-info" download>
								<i class="ri-download-2-fill"></i> Download Panduan
							</a>
							<a class="btn btn-success" href="<?= base_url() ?>uploads/<?= $get->panduan ?> " target="_blank"> Lihat Panduan </a>

							<br><br>

							<!-- Menampilkan preview file yang sudah ada di database -->
							<!-- <iframe src="<?= base_url('uploads/panduan/' . $get->panduan) ?>" width="100%" height="500px"></iframe> -->
						<?php else: ?>
							<p>Tidak ada panduan yang diupload.</p>
						<?php endif; ?>
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
<script src="https://cdn.ckeditor.com/ckeditor5/36.0.1/classic/ckeditor.js"></script>
<script>
	// Initialize CKEditor for text area
	ClassicEditor
		.create(document.querySelector('textarea'))
		.catch(error => {
			console.error(error);
		});

	// Function to preview image before uploading
	function previewImage(event) {
		// Get the file from input
		var file = event.target.files[0];
		var reader = new FileReader();

		// Set the image preview
		reader.onload = function() {
			var output = document.getElementById('img-preview');
			output.src = reader.result;
		};

		// Read the file as a data URL
		if (file) {
			reader.readAsDataURL(file);
		}
	}
</script>