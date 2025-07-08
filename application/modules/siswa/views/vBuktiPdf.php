<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Bukti Pendaftaran</title>
	<style>
		@import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap');
		body {
			font-family: 'IBM Plex Mono', monospace;
			margin: 0;
			padding: 10px;
			background-color: #f5f5f5;
			color: #333;
			font-size: 13px;
		}

		.container {
			max-width: 900px;
			margin: 0 auto;
			background-color: white;
			border-radius: 8px;
			box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
			padding: 15px;
		}

		.header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			border-bottom: 2px solid #f0f0f0;
			padding-bottom: 10px;
			margin-bottom: 15px;
		}

		.header-left {
			display: flex;
			align-items: center;
			gap: 15px;
		}

		.header-left img {
			width: 120px;
		}

		.title-section {
			display: flex;
			flex-direction: column;
		}

		.title {
			margin: 0;
			color: #2c3e50;
			font-size: 1.3em;
		}

		.subtitle {
			margin: 3px 0 0 0;
			color: #7f8c8d;
			font-size: 0.9em;
		}

		.header-right {
			text-align: center;
			font-weight: bold;
			padding: 8px 12px;
			border-radius: 5px;
			font-size: 0.85em;
		}

		.pemadan-data {
			color: #8e44ad;
			background-color: rgba(142, 68, 173, 0.1);
			border: 1px solid #8e44ad;
		}

		.dtks-accepted {
			color: #27ae60;
			background-color: rgba(39, 174, 96, 0.1);
			border: 1px solid #27ae60;
		}

		.dtks-rejected {
			color: #e74c3c;
			background-color: rgba(231, 76, 60, 0.1);
			border: 1px solid #e74c3c;
		}

		/* .dtks-processing, */
		.dtks-unavailable {
			color: #f39c12;
			background-color: rgba(243, 156, 18, 0.1);
			border: 1px solid #f39c12;
		}

		.dtks-processing {
			color: #f39c12;
			background-color: rgba(243, 156, 18, 0.1);
			border: 1px solid #f39c12;
		}

		.dtks-unavailable {
			color: #fff;
			background-color: rgba(229, 163, 87, 0.98);
			border: 1px solid #7f8c8d;
		}

		.main-content {
			display: grid;
			grid-template-columns: 1fr auto;
			gap: 20px;
			margin-bottom: 15px;
			align-items: start;
		}

		.left-section {
			min-width: 0; 
		}

		.right-section {
			display: flex;
			flex-direction: column;
			align-items: center;
			justify-self: end;
		}

		.photo {
			width: 150px;
			height: 130px;
			object-fit: cover;
			border-radius: 5px;
			box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
		}

		.status-section {
			margin-top: 15px;
		}

		.status-message {
			display: flex;
			align-items: center;
			justify-content: center;
			flex-direction: column;
			padding: 12px;
			border-radius: 8px;
			text-align: center;
			font-size: 0.9em;
			margin-bottom: 15px;
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
			margin-top: 10px;
		}

		.details table {
			width: 100%;
			border-collapse: collapse;
			margin-bottom: 8px;
		}

		.details table tr {
			border-bottom: none	;
		}

		.details table tr:last-child {
			border-bottom: none;
		}

		.details table td {
			padding: 4px 6px;
			vertical-align: top;
			font-size: 12px;
		}

		.details table td:first-child {
			width: 35%;
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
			margin: 8px 0;
			height: 1px;
			background-color: #f0f0f0;
		}

		.footer {
			margin-top: 15px;
			text-align: center;
			font-size: 0.7em;
			color: #7f8c8d;
			border-top: 1px solid #e0e0e0;
			padding-top: 8px;
		}

		@media (max-width: 768px) {
			.header {
				flex-direction: column;
				gap: 10px;
				align-items: flex-start;
			}

			.header-right {
				align-self: stretch;
				text-align: center;
			}

			.main-content {
				grid-template-columns: 1fr;
				gap: 15px;
			}
			
			.right-section {
				justify-self: center;
				order: -1; 
			}
			
			.photo {
				width: 80px;
				height: 100px;
			}
		}

		@media print {
			body {
				background-color: white;
				padding: 0;
			}

			.container {
				box-shadow: none;
				padding: 10px;
				max-width: 100%;
			}
			
			.photo {
				width: 80px;
				height: 100px;
			}
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="header">
			<div class="header-left"  style="position: relative">
				<img src="assets/images/logo-br.jpg" alt="Logo">
				<div class="title-section">
					<h1 class="title">Kartu Pendaftaran SPMB</h1>
					<p class="subtitle">Penerimaan Murid Baru Kabupaten Sinjai</p>
				</div>
			</div>
		</div>
	</div>
	<div class="right-section">
		<img src="uploads/siswa/<?= $get->foto ?>" alt="Foto Siswa" class="photo" style="margin-left: 600px; position: absolute; top: 150px; right: 20px; z-index: 1000;">
	</div>
		
		<div class="main-content">
			<div class="left-section">
				<div class="details">
					<table style="border: none;z-index: -1000;">
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
			</div>

			
		</div>

		<div class="status-section">
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
			<div class="header-right <?php 
				if ($get->sts_dtks == '1') echo 'dtks-accepted';
				elseif ($get->sts_dtks == '0') echo 'dtks-rejected'; 
				elseif ($get->sts_dtks == '3') echo 'dtks-processing';
				elseif ($get->sts_dtks == '4') echo 'dtks-unavailable';
				elseif ($get->sts_dtks == '5') echo 'pemadan-data';
				else echo 'dtks-unavailable';
			?>">
				<?php 
				if ($get->sts_dtks == '1') echo 'Selamat NIK Anda Terdaftar di DTKS';
				elseif ($get->sts_dtks == '0') echo 'Mohon Maaf NIK Anda Tidak Terdaftar di DTKS';
				elseif ($get->sts_dtks == '3') echo 'Proses Diverifikasi DTKS';
				elseif ($get->sts_dtks == '4') echo 'NIK Anda Tidak Valid di DTKS';
				elseif ($get->sts_dtks == '5') echo 'Proses Pemadanan Data';
				else echo 'Data DTKS Tidak Tersedia';
				?>
		<div class="footer">
			© <?php echo date('Y'); ?> SPMB Kabupaten Sinjai - Dokumen ini sah tanpa tanda tangan. <br>
			Dicetak pada: <?php echo \Carbon\Carbon::now()->locale('id')->translatedFormat('j F Y H:i:s') ?>
		</div>
	</div>
</body>

</html>