<style>
	.h1,
	.h2,
	.h3,
	.h4,
	.h5,
	.h6,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6 {
		margin-bottom: 0px;
	}
</style>
<form action="<?= base_url() ?>siswa/save" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
	<input type="hidden" name="lanjut" value="detail">
	<input type="hidden" name="page" value="selesai">


	<div class="row">
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-guide-fill fs-30"></i> <br>
						1. Jalur
					</h5>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-user-2-fill fs-30"></i> <br>
						2. Data Diri
					</h5>
				</div>
			</div>
		</div>

		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-building-fill fs-30"></i> <br>
						3. Sekolah
					</h5>
				</div>
			</div>
		</div>


		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-parent-fill fs-30"></i> <br>
						4. Orang Tua
					</h5>
				</div>
			</div>
		</div>

		<div class="col">
			<div class="card text-white iq-bg-primary iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-primary text-center">
						<i style="font-size:30px;" class="ri-booklet-fill fs-30"></i> <br>
						5. Dokumen
					</h5>
				</div>
			</div>
		</div>
		<div class="col">
			<div class="card text-white bg-success iq-mb-3">
				<div class="card-body">
					<h5 class="card-title text-white text-center">
						<i style="font-size:30px;" class="ri-folder-chart-fill fs-30"></i> <br>
						6. Selesai
					</h5>
				</div>
			</div>
		</div>
	</div>


	<div class="row">
		<div class="col-md-12">
			<ul class="list-group">
				<li class="list-group-item active">
					<h5> Data Diri </h5>
				</li>
			</ul>
			<div class="row">
				<div class="col-md-10">
					<div class="table-responsive">
						<table class="table table-hover">
							<tr>
								<td width="30%">Nama Calon Siswa </td>
								<td width="2%">: </td>
								<td> <b><?= $get->nama_siswa  ?> </b> </td>
							</tr>
							<tr>
								<td>Nomor Induk Kependudukan (NIK)</td>
								<td>: </td>
								<td> <?= $get->no_ktp  ?> </td>
							</tr>
							<tr>
								<td>Tempat / Tanggal Lahir </td>
								<td>: </td>
								<td> <?= $get->tempat_lahir  ?> / <?= tgl_indo($get->tgl_lahir) ?> (<?= \Carbon\Carbon::parse($get->tgl_lahir)->age . ' Tahun'  ?>) </td>
							</tr>
							<tr>
								<td>Jenis Kelamin </td>
								<td>: </td>
								<td> <?= jk($get->jk)  ?> </td>
							</tr>
							<tr>
								<td>Agama </td>
								<td>: </td>
								<td> <?= $get->agama  ?> </td>
							</tr>
							<?php
							if ($get->tingkat_sekolah != "4") {
							?>
								<tr>
									<td>Asal Sekolah </td>
									<td>: </td>
									<td> <?= $get->asal_sekolah  ?> </td>
								</tr>
							<?php } ?>
							<tr>
								<td>Alamat </td>
								<td>: </td>
								<td> <?= $get->alamat  ?> </td>
							</tr>
							<tr>
								<td>Kecamatan </td>
								<td>: </td>
								<td> <?= kecamatan($get->kec)->nama_kec;  ?> </td>
							</tr>

							<tr>
								<td>Desa / Dusun / Lingkungan </td>
								<td>: </td>
								<td> <?= dusun($get->dusun)->daerah_zonasi;  ?> </td>
							</tr>
							<tr>
								<td>Ukuran Baju </td>
								<td>: </td>
								<td> <?= $get->ukuran_baju  ?> </td>
							</tr>

						</table>
					</div>
				</div>
				<div class="col-md-2">
					<img src="<?= base_url() ?>uploads/siswa/<?= $get->foto ?>" width="100%;" alt="" class="mt-3 rounded">
				</div>
			</div>



			<ul class="list-group">
				<li class="list-group-item active">
					<h5> Data Orang Tua </h5>
				</li>
			</ul>
			<div class="table-responsive">
				<table class="table table-hover">
					<tr>
						<td width="20%">Nomor KK </td>
						<td width="2%">: </td>
						<td> <?= $get->no_kk  ?> </td>
					</tr>
					<tr>
						<td width="20%">Nama Ayah </td>
						<td width="2%">: </td>
						<td> <?= $get->nm_ayah  ?> </td>
					</tr>
					<tr>
						<td>Pekerjaan Ayah </td>
						<td>: </td>
						<td> <?= $get->pekerjaan_ayah  ?> </td>
					</tr>
					<tr>
						<td>Nama Ibu </td>
						<td>: </td>
						<td> <?= $get->nm_ibu  ?> </td>
					</tr>
					<tr>
						<td>Pekerjaan Ibu </td>
						<td>: </td>
						<td> <?= $get->pekerjaan_ibu  ?> </td>
					</tr>
					<tr>
						<td>Nama Wali </td>
						<td>: </td>
						<td> <?= $get->nm_wali  ?> </td>
					</tr>
					<tr>
						<td>Pekerjaan Wali </td>
						<td>: </td>
						<td> <?= $get->pekerjaan_wali  ?> </td>
					</tr>
					<tr>
						<td>No Handphone </td>
						<td>: </td>
						<td> <?= $get->no_hp_ortu  ?> </td>
					</tr>

				</table>

			</div>

			<ul class="list-group">
				<li class="list-group-item active">
					<h5> Sekolah Tujuan </h5>
				</li>
			</ul>
			<div class="table-responsive">
				<table class="table table-hover">
					<tr>
						<td width="20%">Jalur </td>
						<td width="2%">: </td>
						<td> <?= jalur($get->jalur)->nama  ?> </td>
					</tr>

					<?php if ($get->jalur == "117") { ?>
						<tr>
							<td width="20%">
								Bidang Prestasi
							</td>
							<td width="2%">:</td>
							<td> <?= $get->bidang_prestasi  ?> </td>
						</tr>
					<?php } ?>

					<tr>
						<td>Sekolah Pilihan </td>
						<td>: </td>
						<td> <b> <?= sekolah($get->pilihan_sekolah_1)->nama  ?> </b> </td>
					</tr>


				</table>
			</div>



			<ul class="list-group">
				<li class="list-group-item active">
					<h5> Lampiran Dokumen </h5>
				</li>
			</ul>
			<div class="table-responsive">
				<table class="table table-hover">

					<tr>
						<td>KK </td>
						<td>: </td>
						<td>
							<?php if ($get->kk) : ?>
								<a href="<?= base_url() ?>uploads/siswa/<?= $get->kk ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
							<?php else : ?>
								Lampiran tidak tersedia
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td>Akta Kelahiran </td>
						<td>: </td>
						<td>
							<?php if ($get->akta_kelahiran_siswa) : ?>
								<a href="<?= base_url() ?>uploads/siswa/<?= $get->akta_kelahiran_siswa ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
							<?php else : ?>
								Lampiran tidak tersedia
							<?php endif; ?>
						</td>
					</tr>
					<?php
					if ($get->jalur != "114") {
						if ($get->jalur == "115") {
							$title = "Surat Keterangan Tidak Mampu";
						} elseif ($get->jalur == "116") {
							$title = "Surat Keterangan Pindah Tugas Orang Tua";
						} elseif ($get->jalur == "117") {
							$title = "Sertifikat / Piagam / Rapor";
						}
					?>

						<tr>
							<td><b><?= $title  ?> </b> </td>
							<td>:</td>
							<td>
								<?php if ($get->suket) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->suket ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</td>
						</tr>
					<?php } ?>
					<tr>
						<td width="20%">
							<?php echo ($get->tingkat_sekolah == "4") ? "Kartu Imunisasi" : "Surat Keterangan Lulus"   ?>
						</td>
						<td width="2%">: </td>
						<td>
							<?php if ($get->skl) : ?>
								<a href="<?= base_url() ?>uploads/siswa/<?= $get->skl ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
							<?php else : ?>
								Lampiran tidak tersedia
							<?php endif; ?>
						</td>
					</tr>


					<?php if ($get->jalur == "117") { ?>

						<tr>
							<td width="20%">
								Lampiran Bukti Prestasi Lainnya
							</td>
							<td width="2%">:</td>
							<td>
								<?php if ($get->suket_prestasi) : ?>
									<a href="<?= base_url() ?>uploads/siswa/<?= $get->suket_prestasi ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
								<?php else : ?>
									Lampiran tidak tersedia
								<?php endif; ?>
							</td>
						</tr>

					<?php } ?>





				</table>
			</div>



			<hr>
			<p><input type="checkbox" required> Saya nyatakan data yang saya isi benar-benar sesuai dengan data yang sesungguhnya dan saya siap mendapatkan sanksi apabila dikemudian hari ada data yg terbukti saya rekayasa. </p>
			<p> <input type="checkbox" required> Dengan mengisi formulir pendaftaran ini saya nyatakan bersedia mengikuti seluruh peraturan yang berlaku pada sekolah dan tidak menuntut apabila dikemudian hari saya melanggar dan diberi sanksi atau dikeluarkan dari sekolah</p>



		</div>
	</div>
	<hr>
	<button class="btn btn-success pull-right " type="submit"> Simpan </button>
	<?php if (level_user() == "siswa") { ?>
		<a href="<?= base_url() ?>siswa/profil/lampiran" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>
	<?php } else { ?>
		<a href="<?= base_url() ?>siswa/edit/lampiran?id=<?= $get->id_siswa ?>" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a>

	<?php } ?>

	<!-- <a href="<?= base_url() ?>siswa/profil/lampiran" class="btn btn-warning pull-right mr-3 "> <i class="ri-arrow-left-fill"></i> Kembali </a> -->
</form>