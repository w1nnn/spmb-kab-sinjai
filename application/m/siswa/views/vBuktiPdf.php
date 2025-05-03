<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bukti Pendaftaran</title>
	<style>
		body {
			font-family: 'Helvetica', Arial, sans-serif;
			margin: 0;
			padding: 20px;
			background-color: #f5f5f5;
			color: #333;
		}

		.container {
			max-width: 800px;
			margin: 0 auto;
			background-color: white;
			border-radius: 10px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			padding: 30px;
		}

		.header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-bottom: 2px solid #f0f0f0;
			padding-bottom: 15px;
			margin-bottom: 20px;
		}

		.header-left {
			display: flex;
			flex-direction: column;
		}

		.header-right {
			text-align: right;
			font-size: 0.8em;
			color: #777;
		}

		.title {
			margin: 0;
			color: #2c3e50;
			font-size: 1.5em;
		}

		.subtitle {
			margin: 5px 0 0 0;
			color: #7f8c8d;
			font-size: 1em;
		}

		.student-info {
			display: flex;
			margin-bottom: 30px;
		}

		.photo {
			width: 150px;
			height: 180px;
			object-fit: cover;
			border-radius: 5px;
			border: 1px solid #ddd;
			margin-right: 30px;
		}

		.status-message {
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			padding: 20px;
			border-radius: 10px;
			text-align: center;
			font-size: 1.1em;
			margin-top: 10px;
			min-width: 250px;
		}

		.status-accepted {
			border: 2px solid #27ae60;
			color: #27ae60;
			background-color: rgba(39, 174, 96, 0.1);
		}

		.status-rejected {
			border: 2px solid #e74c3c;
			color: #e74c3c;
			background-color: rgba(231, 76, 60, 0.1);
		}

		.details {
			margin-top: 20px;
		}

		.details table {
			width: 100%;
			border-collapse: collapse;
		}

		.details table tr {
			border-bottom: 1px solid #f0f0f0;
		}

		.details table tr:last-child {
			border-bottom: none;
		}

		.details table td {
			padding: 12px 10px;
			vertical-align: top;
		}

		.details table td:first-child {
			width: 30%;
			color: #555;
		}

		.details table td:nth-child(2) {
			width: 2%;
			text-align: center;
		}

		.details table td:last-child {
			font-weight: 400;
		}

		.highlight {
			font-weight: bold;
			color: #2c3e50;
		}

		.divider {
			margin: 20px 0;
			height: 1px;
			background-color: #f0f0f0;
		}

		.footer {
			margin-top: 30px;
			text-align: center;
			font-size: 0.8em;
			color: #7f8c8d;
		}

		@media print {
			body {
				background-color: white;
			}

			.container {
				box-shadow: none;
				padding: 0;
			}
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="header">
			<div class="header-left">
				<img src="assets/images/logo-br.jpg" style="width:180px;" alt="Logo">
				<h1 class="title">Kartu Pendaftaran SPMB</h1>
				<p class="subtitle">Penerimaan Murid Baru Kabupaten Sinjai</p>
			</div>
			<div class="header-right">

			</div>
		</div>

		<div class="student-info">
			<img src="uploads/siswa/<?= $get->foto ?>" alt="Foto Siswa" class="photo">

			<?php if (!is_null($get->status_verifikasi) && date('Y-m-d') >= configs()->pengumuman->start) : ?>
				<?php if ($get->status_verifikasi == 'y') : ?>
					<div class="status-message status-accepted">
						<span>Selamat, Anda Lulus dan diterima di</span>
						<strong><?= sekolah($get->pilihan_sekolah_1)->nama; ?></strong>
						<span>Silahkan lakukan pendaftaran ulang</span>
					</div>
				<?php else : ?>
					<div class="status-message status-rejected">
						<span>Maaf, Anda Tidak Lulus di</span>
						<strong><?= sekolah($get->pilihan_sekolah_1)->nama; ?></strong>
						<em>Catatan: <?= $get->catatan_verifikasi ?? '-' ?></em>
					</div>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<div class="details">
			<table>
				<?php if ($get->lock == "y") {  ?>
					<tr>
						<td>Nomor Pendaftaran</td>
						<td>:</td>
						<td class="highlight"><?= $get->no_pendaftaran ?></td>
					</tr>
				<?php } ?>
				<tr>
					<td>Nama Calon Siswa</td>
					<td>:</td>
					<td class="highlight"><?= $get->nama_siswa ?></td>
				</tr>
				<tr>
					<td>Nomor Induk Kependudukan (NIK)</td>
					<td>:</td>
					<td><?= $get->no_ktp ?></td>
				</tr>
				<tr>
					<td>Tempat / Tanggal Lahir</td>
					<td>:</td>
					<td><?= $get->tempat_lahir ?> / <?= tgl_indo($get->tgl_lahir) ?> (<?= \Carbon\Carbon::parse($get->tgl_lahir)->age . ' Tahun' ?>)</td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td>:</td>
					<td><?= jk($get->jk) ?></td>
				</tr>
				<tr>
					<td>Agama</td>
					<td>:</td>
					<td><?= $get->agama ?></td>
				</tr>
				<?php if ($get->tingkat_sekolah != "4") { ?>
					<tr>
						<td>Asal Sekolah</td>
						<td>:</td>
						<td><?= $get->asal_sekolah ?></td>
					</tr>
				<?php } ?>
				<tr>
					<td>Alamat</td>
					<td>:</td>
					<td><?= $get->alamat ?></td>
				</tr>
				<tr>
					<td>Kecamatan</td>
					<td>:</td>
					<td><?= kecamatan($get->kec)->nama_kec; ?></td>
				</tr>
				<tr>
					<td>Desa / Dusun / Lingkungan</td>
					<td>:</td>
					<td><?= dusun($get->dusun)->daerah_zonasi; ?></td>
				</tr>
				<tr>
					<td>Ukuran Baju</td>
					<td>:</td>
					<td><?= $get->ukuran_baju ?></td>
				</tr>
			</table>

			<div class="divider"></div>

			<table>
				<tr>
					<td>Nomor KK</td>
					<td>:</td>
					<td><?= $get->no_kk ?></td>
				</tr>
				<tr>
					<td>Nama Ayah</td>
					<td>:</td>
					<td><?= $get->nm_ayah ?></td>
				</tr>
				<tr>
					<td>Pekerjaan Ayah</td>
					<td>:</td>
					<td><?= $get->pekerjaan_ayah ?></td>
				</tr>
				<tr>
					<td>Nama Ibu</td>
					<td>:</td>
					<td><?= $get->nm_ibu ?></td>
				</tr>
				<tr>
					<td>Pekerjaan Ibu</td>
					<td>:</td>
					<td><?= $get->pekerjaan_ibu ?></td>
				</tr>
				<tr>
					<td>Nama Wali</td>
					<td>:</td>
					<td><?= $get->nm_wali ?></td>
				</tr>
				<tr>
					<td>Pekerjaan Wali</td>
					<td>:</td>
					<td><?= $get->pekerjaan_wali ?></td>
				</tr>
				<tr>
					<td>No Handphone</td>
					<td>:</td>
					<td><?= $get->no_hp_ortu ?></td>
				</tr>
			</table>

			<div class="divider"></div>

			<table>
				<tr>
					<td>Jalur</td>
					<td>:</td>
					<td><?= jalur($get->jalur)->nama ?></td>
				</tr>
				<tr>
					<td>Sekolah Pilihan</td>
					<td>:</td>
					<td class="highlight"><?= sekolah($get->pilihan_sekolah_1)->nama ?></td>
				</tr>
				<tr>
					<td>Tanggal Mendaftar</td>
					<td>:</td>
					<td><?= tgl_indo($get->tgl_daftar) ?></td>
				</tr>
			</table>
		</div>

		<div class="footer">
			© <?php echo date('Y'); ?> SPMB Kabupaten Sinjai - Dokumen ini sah tanpa tanda tangan. <br>
			Dicetak pada: <?php echo \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y H:i:s') ?>
		</div>
	</div>
</body>

</html>