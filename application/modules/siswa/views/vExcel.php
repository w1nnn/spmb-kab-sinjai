<?php
if (level_user() == "admin" || level_user()  == "superadmin") {
	$tingkat = $this->input->get('tingkat');
	$jalur = $this->input->get('jalur');
	$npsn = $this->input->get('npsn');

	$vtitle = 'Daftar Siswa Baru';

	if ($tingkat) {
		$vtitle .= ' Tingkat ' . tingkat($tingkat)->level_sekolah;
	} elseif ($npsn) {
		$vtitle .= ' ' . sekolah($npsn)->nama;
	}

	if ($jalur && $jalur != 'all') {
		$vtitle .= ' ' . jalur($jalur)->nama;
	}

	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=" . strtoupper($vtitle) . ".xls");

	if (count($siswas)) {
?>
		<style>
			tr th {
				border: 1px solid black;
			}

			table tr td {
				border: 1px solid black;
			}
		</style>

		<h2>SPMB - Kabupaten Sinjai </h2>

		<table>
			<?php if ($tingkat) : ?>
				<tr>
					<td><b> TINGKAT </b> </td>
					<td><b><?php echo tingkat($tingkat)->level_sekolah ?></b> </td>
				</tr>
			<?php elseif ($npsn) : ?>
				<tr>
					<td><b> SEKOLAH </b> </td>
					<td><b><?php echo sekolah($npsn)->nama ?></b> </td>
				</tr>
			<?php endif; ?>
			<tr>
				<td><b> JALUR </b> </td>
				<td><b><?php if ($jalur == "all" || !$jalur) {
							echo "Semua Jalur";
						} else {
							echo jalur($jalur)->nama;
						}  ?> </b> </td>
			</tr>
			<tr>
				<td><b> TANGGAL DOWNLOAD </b> </td>
				<td><b><?= tgl_indo(date('Y-m-d'))  ?> Pukul : <?= date('H:i:s'); ?> </b> </td>
			</tr>
			<!-- Jenis Data DTKS -->
			<tr>
				<td><b> Jenis Data </b> </td>
				<td><b>
					<?php if ($this->input->get('sts_dtks') == "1") {
							echo "Data Terdaftar di DTKS";
						} elseif ($this->input->get('sts_dtks') == "0") {
							echo "Data Tidak Terdaftar di DTKS";
						} elseif ($this->input->get('sts_dtks') == "3") {
							echo "Proses Verifikasi Data DTKS";
						} else {
							echo "Data Campuran";
						}
						?> 
						
					</b> </td>
			</tr>
		</table>
		<br>
		<div class="table-responsive">
			<table class="table table-hover" id="table" style="border:1px solid black;">
				<tr>
					<th style="border:1px solid black;">No.</th>
					<th style="border:1px solid black;">Sekolah Pilihan </th>
					<th style="border:1px solid black;">Nomor Induk Kependudukan (NIK) </th>
					<th style="border:1px solid black;">Nama </th>
					<th style="border:1px solid black;">Tempat, Tanggal lahir </th>
					<th style="border:1px solid black;">Jenis Kelamin </th>
					<th style="border:1px solid black;">Agama </th>
					<th style="border:1px solid black;">Alamat </th>
					<th style="border:1px solid black;">Jalur </th>
					<th style="border:1px solid black;">Kecamatan </th>
					<th style="border:1px solid black;">Lingkungan </th>
					<th style="border:1px solid black;">Asal Sekolah </th>
					<th style="border:1px solid black;">Nama Ayah</th>
					<th style="border:1px solid black;">Pekerjaan Ayah</th>
					<th style="border:1px solid black;">Nama Ibu</th>
					<th style="border:1px solid black;">Pekerjaan Ibu</th>
					<th style="border:1px solid black;">Nama Wali </th>
					<th style="border:1px solid black;">Pekerjaan Wali</th>
					<th style="border:1px solid black;">No. Handphone</th>
					<th style="border:1px solid black;">No. Kartu Keluarga </th>
					<th style="border:1px solid black;">Ukuran Baju </th>
					<th style="border:1px solid black;">Link File Foto </th>
					<th style="border:1px solid black;">Link File Akta Kelahiran </th>
					<th style="border:1px solid black;">Link File Kartu Keluarga </th>
					<th style="border:1px solid black;">Link File SKL / Kartu Imunisasi </th>
					<th style="border:1px solid black;">Link File Lampiran </th>
					<th style="border:1px solid black;">Status Kelulusan </th>
					<th style="border:1px solid black;">Catatan Sekolah </th>
					<th style="border:1px solid black;">No. Pendaftaran </th>
					<th style="border:1px solid black;">Tanggal Terdaftar </th>
					<th style="border:1px solid black;">Tanggal Buat Akun </th>
					<th style="border:1px solid black;">Status DTKS</th>
				</tr>
				<?php
				$no = 1;
				foreach ($siswas as $siswa) {
				?>
					<tr>
						<td style="border:1px solid black;"><?= $no++ ?> </td>
						<td style="border:1px solid black;"> <?= sekolah($siswa->pilihan_sekolah_1)->nama ?> </td>
						<td style="border:1px solid black;">'<?= $siswa->no_ktp ?> </td>
						<td style="border:1px solid black;"><b><?= strtoupper($siswa->nama_siswa) ?> </b> </td>
						<td style="border:1px solid black;"><?= $siswa->tempat_lahir ?>, <?= tgl_indo($siswa->tgl_lahir) ?> </td>
						<td style="border:1px solid black;"><?= jk($siswa->jk)  ?></td>
						<td style="border:1px solid black;"><?= $siswa->agama  ?></td>
						<td style="border:1px solid black;"><?= $siswa->alamat  ?></td>
						<td style="border:1px solid black;"><?= jalur($siswa->jalur)->nama  ?></td>
						<td style="border:1px solid black;"> <?= kecamatan($siswa->kec)->nama_kec ?> </td>
						<td style="border:1px solid black;"> <?= dusun($siswa->dusun)->daerah_zonasi ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->asal_sekolah ?></td>
						<td style="border:1px solid black;"> <?= $siswa->nm_ayah ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->pekerjaan_ayah ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->nm_ibu ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->pekerjaan_ibu ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->nm_wali ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->pekerjaan_wali ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->no_hp_ortu ?> </td>
						<td style="border:1px solid black;"> '<?= $siswa->no_kk ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->ukuran_baju ?> </td>
						<td style="border:1px solid black;"> <a href="<?= base_url() ?>uploads/siswa/<?= $siswa->foto ?>"> <?= base_url() ?>uploads/siswa/<?= $siswa->foto ?> </a> </td>
						<td style="border:1px solid black;"> <a href="<?= base_url() ?>uploads/siswa/<?= $siswa->akta_kelahiran_siswa ?>"> <?= base_url() ?>uploads/siswa/<?= $siswa->akta_kelahiran_siswa ?> </a> </td>
						<td style="border:1px solid black;"> <a href="<?= base_url() ?>uploads/siswa/<?= $siswa->kk ?>"> <?= base_url() ?>uploads/siswa/<?= $siswa->kk ?> </a> </td>
						<td style="border:1px solid black;">
							<?php if ($siswa->skl == "") {
								echo "-";
							} else {
								echo "<a href=" . base_url() . "uploads/siswa/" . $siswa->skl . ">" . base_url() . "uploads/siswa/" . $siswa->skl . "</a>";
							}  ?>
						</td>
						<td style="border:1px solid black;">
							<?php if ($siswa->suket == "") {
								echo "-";
							} else {
								echo "<a href=" . base_url() . "uploads/siswa/" . $siswa->suket . ">" . base_url() . "uploads/siswa/" . $siswa->suket . "</a>";
							}  ?>
						</td>
						<td style="border:1px solid black;">
							<?php if ($siswa->status_verifikasi == "y") {
								echo "LULUS";
							} elseif ($siswa->status_verifikasi == "n") {
								echo "TIDAK LULULUS";
							} else {
								echo "BELUM DIPROSES";
							}
							?>
						</td>
						<td style="border:1px solid black;"> <?= $siswa->catatan_verifikasi ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->no_pendaftaran ?> </td>
						<td style="border:1px solid black;"> <?= tgl_indo($siswa->tgl_daftar) ?> </td>
						<td style="border:1px solid black;"> <?= tgl_indo($siswa->tgl_buat_akun) ?> </td>
						<td style="border:1px solid black;">
							<?php if ($siswa->sts_dtks == "1") {
								echo "Terdaftar di DTKS";
							} elseif ($siswa->sts_dtks == "0") {
								echo "Tidak Terdaftar di DTKS";
							} elseif ($siswa->sts_dtks == "3") {
								echo "Proses Verifikasi DTKS";
							} else {
								echo "Tidak Diketahui";
							}
							?>
					</tr>
				<?php } ?>

			</table>
		</div>
	<?php
	}
} elseif (level_user() == "sekolah") {

	$jalur = $this->input->get('jalur');

	if ($jalur == "all") {
		$jalurx;
	} else {
		$jalurx = jalur($jalur)->nama;
	}

	$npsn = $this->session->userdata('npsn');
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=Data Calon Siswa - " . $jalurx . " - " . sekolah($npsn)->nama . ".xls");

	?>
	<h2>SPMB - Kabupaten Sinjai </h2>
	<table>
		<tr>
			<td><b> SEKOLAH</b> </td>
			<td><b><?= sekolah($npsn)->nama; ?> </b> </td>
		</tr>
		<tr>
			<td><b> JALUR </b> </td>
			<td><b><?= $jalurx ?> </b> </td>
		</tr>
		<tr>
			<td><b> TANGGAL EXPORT </b> </td>
			<td><b><?= tgl_indo(date('Y-m-d'))  ?> Pukul : <?= date('H:i:s'); ?> </b> </td>
		</tr>
	</table>
	<br>
	<div class="table-responsive">
		<table class="table table-hover" id="table">
			<thead class="text-center iq-bg-primary">
				<tr>
					<th style="border:1px solid black;">No.</th>
					<th style="border:1px solid black;">No. Akta Kelahiran </th>
					<th style="border:1px solid black;">Nama </th>
					<th style="border:1px solid black;">Tempat, Tanggal lahir </th>
					<th style="border:1px solid black;">Jenis Kelamin </th>
					<th style="border:1px solid black;">Agama </th>
					<th style="border:1px solid black;">Alamat </th>
					<th style="border:1px solid black;">Jalur </th>
					<th style="border:1px solid black;">Sekolah Pilihan </th>
					<th style="border:1px solid black;">Kecamatan </th>
					<th style="border:1px solid black;">Lingkungan </th>
					<th style="border:1px solid black;">Asal Sekolah </th>
					<th style="border:1px solid black;">Nama Ayah</th>
					<th style="border:1px solid black;">Pekerjaan Ayah</th>
					<th style="border:1px solid black;">Nama Ibu</th>
					<th style="border:1px solid black;">Pekerjaan Ibu</th>
					<th style="border:1px solid black;">Nama Wali </th>
					<th style="border:1px solid black;">Pekerjaan Wali</th>
					<th style="border:1px solid black;">No. Handphone</th>
					<th style="border:1px solid black;">No. Kartu Keluarga </th>
					<th style="border:1px solid black;">Ukuran Baju </th>
					<th style="border:1px solid black;">Link File Foto </th>
					<th style="border:1px solid black;">Link File Akta Kelahiran </th>
					<th style="border:1px solid black;">Link File Kartu Keluarga </th>
					<th style="border:1px solid black;">Link File SKL / Kartu Imunisasi </th>
					<th style="border:1px solid black;">Link File Lampiran </th>
					<th style="border:1px solid black;">Status Kelulusan </th>
					<th style="border:1px solid black;">Catatan Sekolah </th>
					<th style="border:1px solid black;">No. Pendaftaran </th>
					<th style="border:1px solid black;">Tanggal Terdaftar </th>
					<th style="border:1px solid black;">Tanggal Buat Akun </th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				foreach ($siswas as $siswa) {
				?>
					<tr>
						<td style="border:1px solid black;"><?= $no++ ?> </td>
						<td style="border:1px solid black;"><?= $siswa->no_ktp ?> </td>
						<td style="border:1px solid black;"><b><?= strtoupper($siswa->nama_siswa) ?> </b> </td>
						<td style="border:1px solid black;"><?= $siswa->tempat_lahir ?>, <?= tgl_indo($siswa->tgl_lahir) ?> </td>
						<td style="border:1px solid black;"><?= jk($siswa->jk)  ?></td>
						<td style="border:1px solid black;"><?= $siswa->agama  ?></td>
						<td style="border:1px solid black;"><?= $siswa->alamat  ?></td>
						<td style="border:1px solid black;"><?= jalur($siswa->jalur)->nama  ?></td>
						<td style="border:1px solid black;"> <?= sekolah($siswa->pilihan_sekolah_1)->nama ?> </td>
						<td style="border:1px solid black;"> <?= kecamatan($siswa->kec)->nama_kec ?> </td>
						<td style="border:1px solid black;"> <?= dusun($siswa->dusun)->daerah_zonasi ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->asal_sekolah ?></td>
						<td style="border:1px solid black;"> <?= $siswa->nm_ayah ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->pekerjaan_ayah ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->nm_ibu ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->pekerjaan_ibu ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->nm_wali ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->pekerjaan_wali ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->no_hp_ortu ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->no_kk ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->ukuran_baju ?> </td>
						<td style="border:1px solid black;"> <a href="<?= base_url() ?>uploads/siswa/<?= $siswa->foto ?>"> <?= base_url() ?>uploads/siswa/<?= $siswa->foto ?> </a> </td>
						<td style="border:1px solid black;"> <a href="<?= base_url() ?>uploads/siswa/<?= $siswa->akta_kelahiran_siswa ?>"> <?= base_url() ?>uploads/siswa/<?= $siswa->akta_kelahiran_siswa ?> </a> </td>
						<td style="border:1px solid black;"> <a href="<?= base_url() ?>uploads/siswa/<?= $siswa->kk ?>"> <?= base_url() ?>uploads/siswa/<?= $siswa->kk ?> </a> </td>
						<td style="border:1px solid black;">
							<?php if ($siswa->skl == "") {
								echo "-";
							} else {
								echo "<a href=" . base_url() . "uploads/siswa/" . $siswa->skl . ">" . base_url() . "uploads/siswa/" . $siswa->skl . "</a>";
							}  ?>
						</td>
						<td style="border:1px solid black;">
							<?php if ($siswa->suket == "") {
								echo "-";
							} else {
								echo "<a href=" . base_url() . "uploads/siswa/" . $siswa->suket . ">" . base_url() . "uploads/siswa/" . $siswa->suket . "</a>";
							}  ?>
						</td>
						<td style="border:1px solid black;">
							<?php if ($siswa->status_verifikasi == "y") {
								echo "LULUS";
							} elseif ($siswa->status_verifikasi == "n") {
								echo "TIDAK LULULUS";
							} else {
								echo "BELUM DIPROSES";
							}
							?>
						</td>
						<td style="border:1px solid black;"> <?= $siswa->catatan_verifikasi ?> </td>
						<td style="border:1px solid black;"> <?= $siswa->no_pendaftaran ?> </td>
						<td style="border:1px solid black;"> <?= tgl_indo($siswa->tgl_daftar) ?> </td>
						<td style="border:1px solid black;"> <?= tgl_indo($siswa->tgl_buat_akun) ?> </td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
<?php } ?>