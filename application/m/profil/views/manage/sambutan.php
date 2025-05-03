<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

<div class="row">
	<div class="col-sm-12">
		<form action="<?= base_url() ?>profil/manage/update" method="POST" enctype="multipart/form-data">
			<input type="hidden" name="act" value="sambutan">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<div class="iq-advance-course">
						<div class="form-group">
							<label for=""> Sambutan Kepala Dinas </label>
							<textarea class="form-control" id="" cols="30" name="sambutan"><?= $get->sambutan ?></textarea>
						</div>
						<div class="form-group">
							<label for=""> Nama Kepala Dinas </label>
							<input type="text" class="form-control" name="nama_kadis" value="<?= $get->nama_kadis ?>">
						</div>
						<div class="form-group">
							<label for=""> Foto Kepala Dinas </label> <br>

							<!-- Display existing image -->
							<img id="img-preview" src="<?= base_url() ?>uploads/<?= $get->foto_kadis ?>" class="rounded-circle" alt="Foto Kepala Dinas" style="width:150px; height:150px;">
							<br>

							<!-- File input -->
							<input type="file" class="form-control-file" name="fotokadis" id="foto_kadis" onchange="previewImage(event)">
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