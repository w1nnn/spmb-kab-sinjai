<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bukti Pendaftaran</title>
	<style>
		body {
			font-family: 'Helvetica';
		}
	</style>
</head>

<body>
	<div style="float: right;font-size: 0.8em">
		Dicetak pada: <?php echo \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y H:i:s') ?>
	</div>
	<img src="assets/images/ppdb-logo-text.png" style="width:200px;" alt="">

	<h3 style="margin-bottom: 0"><b>BUKTI PENDAFTARAN </b></h3>
	<h4 style="margin-bottom: 5px;margin-top: 0">Penerimaan Peserta Didik Baru Kabupaten Sinjai</h4>
	<img src="uploads/siswa/<?= $get->foto ?>" width="150px" alt="" class="mt-3 rounded" style="border-radius:5px;float: left">
	<?php if (!is_null($get->status_verifikasi) && date('Y-m-d') >= configs()->pengumuman->start) : ?>
		<?php if ($get->status_verifikasi == 'y') : ?>
			<div style="float: left;color: green;padding: 30px 10px;border: solid 2px green;border-radius: 30px;text-align: center;margin-left: 35px;margin-top: 30px">
				Selamat, Anda Lulus dan diterima di <br><b> <?= sekolah($get->pilihan_sekolah_1)->nama; ?></b><br>
				Silahkan lakukan pendaftaran ulang
			</div>
		<?php else : ?>
			<div style="float: left;color: red;padding: 30px 10px;border: solid 2px red;border-radius: 30px;text-align: center;margin-left: 35px;margin-top: 30px">
				Maaf, Anda Tidak Lulus di <br><b> <?= sekolah($get->pilihan_sekolah_1)->nama; ?></b><br>
				<em>Catatan: <?= $get->catatan_verifikasi ?? '-' ?></em>
			</div>
		<?php endif; ?>
	<?php endif; ?>
	<div style="width: 100%;float: none;clear: both"></div>


	<div class="row" style="margin-top:-30px;">
		<div class="col-md-12">
			<div class="table-responsive">
				<table class="table table-hover">

					<?php if ($get->lock == "y") {  ?>
						<tr>
							<td width="30%">Nomor Pendaftaran</td>
							<td width="2%">:</td>
							<td><b><?= $get->no_pendaftaran ?> </b></td>
						</tr>
					<?php } ?>

					<tr>
						<td width="30%">Nama Calon Siswa</td>
						<td width="2%">:</td>
						<td><b><?= $get->nama_siswa ?> </b></td>
					</tr>
					<tr>
						<td>Nomor Induk Kependudukan (NIK)</td>
						<td>: </td>
						<td> <?= $get->no_ktp  ?> </td>
					</tr>

					<tr>
						<td>Tempat / Tanggal Lahir</td>
						<td>:</td>
						<td> <?= $get->tempat_lahir ?>
							/ <?= tgl_indo($get->tgl_lahir) ?> (<?= \Carbon\Carbon::parse($get->tgl_lahir)->age . ' Tahun'  ?>) </td>
					</tr>
					<tr>
						<td>Jenis Kelamin</td>
						<td>:</td>
						<td> <?= jk($get->jk) ?> </td>
					</tr>
					<tr>
						<td>Agama</td>
						<td>:</td>
						<td> <?= $get->agama ?> </td>
					</tr>
					<?php
					if ($get->tingkat_sekolah != "4") {
					?>
						<tr>
							<td>Asal Sekolah</td>
							<td>:</td>
							<td> <?= $get->asal_sekolah ?> </td>
						</tr>
					<?php } ?>
					<tr>
						<td>Alamat</td>
						<td>:</td>
						<td> <?= $get->alamat ?> </td>
					</tr>
					<tr>
						<td>Kecamatan</td>
						<td>:</td>
						<td> <?= kecamatan($get->kec)->nama_kec; ?> </td>
					</tr>

					<tr>
						<td>Desa / Dusun / Lingkungan</td>
						<td>:</td>
						<td> <?= dusun($get->dusun)->daerah_zonasi; ?> </td>
					</tr>
					<tr>
						<td>Ukuran Baju</td>
						<td>:</td>
						<td> <?= $get->ukuran_baju ?> </td>
					</tr>
					<tr>
						<td width="20%">Nomor KK </td>
						<td width="2%">: </td>
						<td> <?= $get->no_kk  ?> </td>
					</tr>

					<tr>
						<td width="20%">Nama Ayah</td>
						<td width="2%">:</td>
						<td> <?= $get->nm_ayah ?> </td>
					</tr>
					<tr>
						<td>Pekerjaan Ayah</td>
						<td>:</td>
						<td> <?= $get->pekerjaan_ayah ?> </td>
					</tr>
					<tr>
						<td>Nama Ibu</td>
						<td>:</td>
						<td> <?= $get->nm_ibu ?> </td>
					</tr>
					<tr>
						<td>Pekerjaan Ibu</td>
						<td>:</td>
						<td> <?= $get->pekerjaan_ibu ?> </td>
					</tr>
					<tr>
						<td>Nama Wali</td>
						<td>:</td>
						<td> <?= $get->nm_wali ?> </td>
					</tr>
					<tr>
						<td>Pekerjaan Wali</td>
						<td>:</td>
						<td> <?= $get->pekerjaan_wali ?> </td>
					</tr>
					<tr>
						<td>No Handphone</td>
						<td>:</td>
						<td> <?= $get->no_hp_ortu ?> </td>
					</tr>
					<tr>
						<td width="20%">Jalur</td>
						<td width="2%">:</td>
						<td> <?= jalur($get->jalur)->nama ?> </td>
					</tr>
					<tr>
						<td>Sekolah Pilihan </td>
						<td>:</td>
						<td><b> <?= sekolah($get->pilihan_sekolah_1)->nama ?> </b></td>
					</tr>
					<tr>
						<td width="30%">Tanggal Mendaftar</td>
						<td width="2%">:</td>
						<td><?= tgl_indo($get->tgl_daftar) ?> </td>
					</tr>


				</table>
			</div>
		</div>

	</div>

</body>

</html>