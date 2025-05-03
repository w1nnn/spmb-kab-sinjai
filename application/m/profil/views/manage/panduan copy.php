<?php if ($this->session->flashdata('message')): ?>
	<div class="alert alert-success">
		<?= $this->session->flashdata('message'); ?>
	</div>
<?php endif; ?>

<!-- Menampilkan pesan error -->
<?php if ($this->session->flashdata('error')): ?>
	<div class="alert alert-danger">
		<?= $this->session->flashdata('error'); ?>
	</div>
<?php endif; ?>

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
							<a href="<?= base_url('uploads/panduan/' . $get->panduan) ?>" class="btn btn-primary" download>
								<i class="ri-download-2-fill"></i> Download Panduan
							</a>

							<br><br>

							<!-- Menampilkan preview file jika itu adalah file PDF -->
							<iframe src="<?= base_url('uploads/etc/' . $get->panduan) ?>" width="100%" height="500px"></iframe>
						<?php else: ?>
							<p>Tidak ada panduan yang diupload.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>