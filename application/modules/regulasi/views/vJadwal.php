<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
<div class="row">
	<div class="container-fluid">
		<?php if ($this->session->flashdata('msg')) : ?>
			<div id="notif" class="alert alert-success h6"><?= $this->session->flashdata('msg') ?></div>
		<?php elseif ($this->session->flashdata('error')) : ?>
			<div id="notif" class="alert alert-danger h6"><?= $this->session->flashdata('error') ?></div>
		<?php endif; ?>
		<form action="<?= base_url() ?>regulasi/regulasi/setjadwal" method="post" class="bg-white rounded rounded-lg p-3">
			<div class="form-group border border-info rounded p-3">
				<label class="font-weight-bold h6">Jadwal Zonasi</label>
				<div class="row">
					<div class="col-md-6">
						<label for="zonasi_start">Mulai</label>
						<input id="zonasi_start" type="date" name="zonasi[start]" class="form-control" value="<?php echo $jadwal ? $jadwal->zonasi->start : null ?>">
					</div>
					<div class="col-md-6">
						<label for="zonasi_end">Selesai</label>
						<input id="zonasi_end" type="date" name="zonasi[end]" class="form-control" value="<?php echo $jadwal ? $jadwal->zonasi->end : null ?>">
					</div>
				</div>
			</div>
			<div class="form-group border border-info rounded p-3">
				<label class="font-weight-bold h6">Jadwal Pendaftaran</label>
				<div class="row">
					<div class="col-md-6">
						<label for="daftar_start">Mulai</label>
						<input id="daftar_start" type="date" name="daftar[start]" class="form-control" value="<?php echo $jadwal ? $jadwal->daftar->start : null ?>">
					</div>
					<div class="col-md-6">
						<label for="daftar_end">Selesai</label>
						<input id="daftar_end" type="date" name="daftar[end]" class="form-control" value="<?php echo $jadwal ? $jadwal->daftar->end : null ?>">
					</div>
				</div>
			</div>
			<div class="form-group border border-info rounded p-3">
				<label class="font-weight-bold h6">Jadwal Seleksi</label>
				<div class="row">
					<div class="col-md-6">
						<label for="seleksi_start">Mulai</label>
						<input id="seleksi_start" type="date" name="seleksi[start]" class="form-control" value="<?php echo $jadwal ? $jadwal->seleksi->start : null ?>">
					</div>
					<div class="col-md-6">
						<label for="seleksi_end">Selesai</label>
						<input id="seleksi_end" type="date" name="seleksi[end]" class="form-control" value="<?php echo $jadwal ? $jadwal->seleksi->end : null ?>">
					</div>
				</div>
			</div>
			<div class="form-group border border-info rounded p-3">
				<label class="font-weight-bold h6">Jadwal Pengumuman</label>
				<div class="row">
					<div class="col-md-6">
						<label for="pengumuman_start">Mulai</label>
						<input id="pengumuman_start" type="date" name="pengumuman[start]" class="form-control" value="<?php echo $jadwal ? $jadwal->pengumuman->start : null ?>">
					</div>
					<div class="col-md-6">
						<label for="pengumuman_end">Selesai</label>
						<input id="pengumuman_end" type="date" name="pengumuman[end]" class="form-control" value="<?php echo $jadwal ? $jadwal->pengumuman->end : null ?>">
					</div>
				</div>
			</div>
			<div class="form-group border border-info rounded p-3">
				<label class="font-weight-bold h6">Jadwal Edit Kuota Diterima</label>
				<div class="row">
					<div class="col-md-6">
						<label for="kuota_start">Mulai</label>
						<input id="kuota_start" type="date" name="kuota[start]" class="form-control" value="<?php echo $jadwal ? $jadwal->kuota->start : null ?>">
					</div>
					<div class="col-md-6">
						<label for="kuota_end">Selesai</label>
						<input id="kuota_end" type="date" name="kuota[end]" class="form-control" value="<?php echo $jadwal ? $jadwal->kuota->end : null ?>">
					</div>
				</div>
			</div>
			<!-- JadwalEdit Data Siswa -->
			<div class="form-group border border-info rounded p-3">
				<label class="font-weight-bold h6">Jadwal Edit Data Siswa</label>
				<div class="row">
					<div class="col-md-6">
						<label for="edit_siswa_start">Mulai</label>
						<input id="edit_siswa_start" type="date" name="edit_siswa[start]" class="form-control" value="<?php echo $jadwal ? $jadwal->edit_siswa->start : null ?>">
					</div>
					<div class="col-md-6">
						<label for="edit_siswa_end">Selesai</label>
						<input id="edit_siswa_end" type="date" name="edit_siswa[end]" class="form-control" value="<?php echo $jadwal ? $jadwal->edit_siswa->end : null ?>">
					</div>
				</div>
			</div>
			<!-- Jadwal Edit Data Siswa End -->
			<div class="form-group pt-3">
				<button class="btn btn-primary btn-lg btn-block" type="submit">SIMPAN JADWAL</button>
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
<script>
	if ($("#notif").length > 0) {
		setTimeout(() => {
			$("#notif").fadeOut();
		}, 5000)
	}
</script>