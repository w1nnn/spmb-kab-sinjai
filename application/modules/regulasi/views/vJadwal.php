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
			<div class="form-group pt-3">
				<button class="btn btn-primary btn-lg btn-block" type="submit">SIMPAN JADWAL</button>
			</div>
		</form>
	</div>
</div>
<script>
	if ($("#notif").length > 0) {
		setTimeout(() => {
			$("#notif").fadeOut();
		}, 5000)
	}
</script>