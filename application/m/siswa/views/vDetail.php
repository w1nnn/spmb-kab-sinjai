<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
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

<div class="row">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height ">
			<div class="iq-card-body relative-background">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12">
								<?php
								if (level_user() == "siswa") {
									if ($get->lock == "y") {  ?>
										<?php
										if ($get->status_verifikasi != "" && date('Y-m-d') >= configs()->pengumuman->start) {
											if ($get->status_verifikasi == "y") {
										?>
												<div class="card text-white bg-success  iq-mb-3">
													<div class="card-body">
														<div class="row">
															<div class="col-md-9">
																<h4 class="card-title text-white"> <i class="ri-check-double-line"></i> Selamat, Anda Lulus dan diterima di <b> <?= sekolah($get->pilihan_sekolah_1)->nama; ?></b> </h3>
																	<h6 class="text-dark"> Silahkan lakukan pendaftaran ulang </h6>
															</div>
															<div class="col-md-3">
																<a href="<?= base_url() ?>siswa/cetak" target="blank" class="btn btn-lg btn-primary btn-block"> Cetak Surat Keterangan Lulus </a>
															</div>
														</div>

													</div>
												</div>
											<?php
											} elseif ($get->status_verifikasi == "n") {
											?>
												<div class="card text-white bg-danger  iq-mb-3">
													<div class="card-body">
														<div class="row">
															<div class="col-md-9">
																<h4 class="card-title text-white"> <i class="ri-information-fill "></i> Maaf, Anda Tidak Lulus di <b> <?= sekolah($get->pilihan_sekolah_1)->nama; ?></b> </h3>
																	<h6 class="text-white"> Catatan : <?= $get->catatan_verifikasi ?> </h6>
															</div>

														</div>
													</div>
												</div>
											<?php
											}
										} else {
											?>
											<div class="card text-white bg-warning  iq-mb-3">
												<div class="card-body">
													<div class="row">
														<div class="col-md-9">
															<h4 class="card-title text-dark"> <i class="ri-check-double-line"></i> Pendaftaran Berhasil, Nomor Pendaftaran : <b><?= $get->no_pendaftaran; ?> </b> </h3>
																<h6 class="text-dark"> Silahkan menunggu pengumuman dari pihak sekolah pada tanggal <b><?php echo \Carbon\Carbon::parse(configs()->pengumuman->start)->locale('id')->translatedFormat('j F Y') ?></b></h6>
														</div>
														<div class="col-md-3">
															<a href="<?= base_url() ?>siswa/cetak " class="btn btn-lg btn-primary btn-block" target="_blank"> <i class="ri-printer-line"></i> Cetak Bukti Pendaftaran </a>
														</div>
													</div>

												</div>
											</div>
								<?php
										}
									}
								}
								?>

								<?php if (level_user() == "admin" || level_user() == "superadmin" || level_user() == "sekolah") { ?>
									<div class="row mb-2">
										<div class="col-md-4">
											<a href="<?= base_url() ?>siswa/cetak/<?= $this->uri->segment(3) ?>" target="blank" class="mt-2 btn btn-lg btn-outline-primary btn-block"> <i class="ri-printer-line"></i> Cetak Bukti Pendaftaran </a>
										</div>
										<div class="col-md-4">
											<!-- <a href="<?= base_url() ?>siswa/edit/?id=<?= $this->uri->segment(3) ?>" class="mt-2 btn btn-lg btn-warning btn-block"> <i class="ri-edit-line"></i> Edit </a> -->
										</div>
										<div class="col-md-4">
											<!-- <a href="#" data-toggle="modal" data-target="#hapus" class="mt-2 btn btn-lg btn-danger btn-block"> <i class="ri-delete-bin-4-line "></i> Hapus</a> -->
										</div>
									</div>

								<?php } ?>
								<ul class="list-group">
									<li class="list-group-item active">
										<h5> Data Diri </h5>
									</li>
								</ul>
								<div class="row">
									<div class="col-md-10">
										<div class="table-responsive">
											<table class="table table-hover">
												<?php if (level_user() == "admin" || level_user() == "superadmin") {  ?>
													<tr>
														<td width="30%">Status </td>
														<td width="2%">:</td>
														<td>
															<b>
																<?php
																if ($get->status_verifikasi != "") {
																	if ($get->status_verifikasi == "y") {
																		echo "DITERIMA";
																	} elseif ($get->status_verifikasi == "n") {
																		echo "DITOLAK";
																	}
																} else {
																?>
																	BELUM DI PROSES
																<?php } ?>
															</b>
														</td>
													</tr>
												<?php } ?>




												<?php if ($get->lock == "y") {  ?>
													<tr>
														<td width="30%">Nomor Pendaftaran</td>
														<td width="2%">:</td>
														<td>
															<b> <?= $get->no_pendaftaran ?></b>
															<?php
															// var_dump($get->no_pendaftaran);
															?>
														</td>
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
											<td width="20%">Jalur</td>
											<td width="2%">:</td>
											<td> <?= jalur($get->jalur)->nama ?> </td>
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
											<td>:</td>
											<td><b> <?= sekolah($get->pilihan_sekolah_1)->nama ?> </b></td>
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
											<td width="40%">KK</td>
											<td>:</td>
											<td>
												<?php if ($get->kk) : ?>
													<a href="<?= base_url() ?>uploads/siswa/<?= $get->kk ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
												<?php else : ?>
													Lampiran tidak tersedia
												<?php endif; ?>
											</td>
										</tr>
										<tr>
											<td>Akta Kelahiran</td>
											<td>:</td>
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
												$title = "Kartu Indonesia Pintar (KIP) / Kartu Indonesia Sehat (KIS)";
											} else if ($get->jalur == "116") {
												$title = "Surat Keterangan Pindah Tugas Orang Tua";
											} else if ($get->jalur == "117") {
												$title = "Sertifikat / Piagam / Rapor";
											}
										?>

											<tr>
												<td><?= $title ?> </td>
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
												<?php echo ($get->tingkat_sekolah == "4") ? "Kartu Imunisasi" : "Surat Keterangan Lulus / Surat Tanda Selesai Belajar (STSB)"   ?>
											</td>
											<td width="2%">:</td>
											<td>
												<?php if ($get->skl) : ?>
													<a href="<?= base_url() ?>uploads/siswa/<?= $get->skl ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran</a>
												<?php else : ?>
													Lampiran tidak tersedia
												<?php endif; ?>
											</td>
										</tr>
										<?php if ($get->lampiran_psikolog) : ?>
											<tr>
												<td>Surat Keterangan Psikolog</td>
												<td>: </td>
												<td>
													<a href="<?= base_url() ?>uploads/siswa/psikolog/<?= $get->lampiran_psikolog ?>" target="_blank" class="btn btn-sm btn-primary">
														<i class="fa fa-search" aria-hidden="true"></i> Lihat Lampiran
													</a>
												</td>
											</tr>
										<?php endif; ?>
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
								<?php if (level_user() != "siswa") { ?>
									<?php if (verifyAccess() || (date('Y-m-d') >= configs()->seleksi->start && date('Y-m-d') <= configs()->seleksi->end)) : ?>
										<h4 class="mb-2">Verifikasi Kelulusan </h4>
										<?php if (is_null($get->status_verifikasi) || $get->status_verifikasi == '') : ?>
											<em class="text-danger">Harap data peserta didik dicermati dengan baik sebelum diterima atau ditolak. <b>PROSES HANYA BISA DILAKUKAN 1 (SATU) KALI!</b></em>
										<?php else : ?>
											<em class="text-success"><b>ANDA SUDAH MELAKUKAN PROSES VERIFIKASI</b></em>
										<?php endif; ?>
										<form action="<?php echo is_null($get->status_verifikasi) || $get->status_verifikasi == '' ? base_url() . 'siswa/daftar/verifikasi' : 'javascript:void(0)' ?>" method="POST" <?php echo !is_null($get->status_verifikasi) && $get->status_verifikasi != '' ? 'disabled' : '' ?>>
											<input type="hidden" name="id" value="<?= $get->id_siswa ?>">
											<div class="form-group">
												<label for=""> Status Kelulusan </label>
												<select name="status_verifikasi" class="form-control" id="" <?php echo !is_null($get->status_verifikasi) && $get->status_verifikasi != '' ? 'disabled' : '' ?> required>
													<option value=""> Pilih Status Kelulusan</option>
													<option value="y" <?= ($get->status_verifikasi == "y") ? "selected" : ""; ?>> Terima </option>
													<option value="n" <?= ($get->status_verifikasi == "n") ? "selected" : ""; ?>> Tolak </option>
												</select>
											</div>
											<div class="form-group">
												<label for=""> Catatan </label>
												<textarea name="catatan_verifikasi" class="form-control" <?php echo !is_null($get->status_verifikasi) && $get->status_verifikasi != '' ? 'disabled' : '' ?>> <?= $get->catatan_verifikasi ?> </textarea>
											</div>
											<button type="submit" class="btn btn-primary" <?= !is_null($get->status_verifikasi) && $get->status_verifikasi != '' ? "disabled" : ""; ?>> <i class="ri-save-2-line"></i> Simpan </button>

										</form>
									<?php else : ?>
										<h4 class="mb-2">Verifikasi Kelulusan </h4>
										<em class="text-primary h6">Proses verifikasi dapat dilakukan pada tanggal <?php echo (\Carbon\Carbon::parse(configs()->seleksi->start)->locale('id')->translatedFormat('j F Y')) . ' s.d. ' . (\Carbon\Carbon::parse(configs()->seleksi->end)->locale('id')->translatedFormat('j F Y')) ?></em>
									<?php endif; ?>
								<?php } ?>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<div class="modal fade " id="hapus" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Hapus Data Siswa ? </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<p>Anda yakin ingin menghapus data siswa ? </p>
			</div>
			<div class="modal-footer">

				<a href="<?= base_url() ?>siswa/delete/<?= $get->id_siswa ?>" data class="btn btn-danger"> Hapus </a>
			</div>
		</div>
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
	function delete_(id) {
		if (confirm('Anda yakin ingin menghapus data ?')) {
			// ajax delete data to database

			$.ajax({
				url: "<?php echo site_url('regulasi/manage/ajax_delete') ?>/" + id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					//if success reload ajax table
					reload_table();
					toastr.error('Berhasil Menghapus Data');

				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error deleting data');
				}
			});

		}
	}
</script>