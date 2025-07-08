<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 "> <i class="ri-arrow-go-back-line "></i> Kembali </a>
				<div class="clearfix"></div>
				<div class="iq-advance-course ">

					<form action="<?= base_url()?>dokumen/manage/update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="id" value="<?= $get->id ?>">
						<div class="form-group">
							<label for=""> Judul <span class="text-danger">*</span> </label>
							<input type="text" value="<?= $get->nama ?>" class="form-control" name="nama" autocomplete="off" required>
						</div>
					
						<div class="form-group">
							<label for=""> Lampiran (jpg/pdf) </label>
							<input type="file" class="form-control-file" name="lampiran" autocomplete="off">
						</div>
						<div class="form-group">
							<label for=""> Jenis File <span class="text-danger">*</span> </label>
							<select name="jenis_file" class="form-control" required>
								<option value="">-- Pilih Jenis File --</option>
								<option value="sktm" <?= $get->jenis_file == 'sktm' ? 'selected' : '' ?>>Surat Keterangan Tidak Mampu (SKTM)</option>
								<option value="surat_aktif" <?= $get->jenis_file == 'surat_aktif' ? 'selected' : '' ?>>Surat Keterangan Aktif Sekolah</option>
								<option value="surat_pindah" <?= $get->jenis_file == 'surat_pindah' ? 'selected' : '' ?>>Surat Pindah Sekolah</option>
								<option value="surat_lulus" <?= $get->jenis_file == 'surat_lulus' ? 'selected' : '' ?>>Surat Keterangan Lulus</option>
								<option value="rapor" <?= $get->jenis_file == 'rapor' ? 'selected' : '' ?>>Rapor</option>
								<option value="ijazah" <?= $get->jenis_file == 'ijazah' ? 'selected' : '' ?>>Ijazah</option>
								<option value="ktp" <?= $get->jenis_file == 'ktp' ? 'selected' : '' ?>>Kartu Tanda Penduduk (KTP)</option>
								<option value="kk" <?= $get->jenis_file == 'kk' ? 'selected' : '' ?>>Kartu Keluarga (KK)</option>
								<option value="kip" <?= $get->jenis_file == 'kip' ? 'selected' : '' ?>>Kartu Indonesia Pintar (KIP)</option>
								<option value="kks" <?= $get->jenis_file == 'kks' ? 'selected' : '' ?>>Kartu Keluarga Sejahtera (KKS)</option>
								<option value="foto" <?= $get->jenis_file == 'foto' ? 'selected' : '' ?>>Pas Foto Terbaru</option>
								<option value="permohonan_beasiswa" <?= $get->jenis_file == 'permohonan_beasiswa' ? 'selected' : '' ?>>Surat Permohonan Beasiswa</option>
								<option value="rekomendasi_sekolah" <?= $get->jenis_file == 'rekomendasi_sekolah' ? 'selected' : '' ?>>Surat Rekomendasi dari Sekolah</option>
								<option value="izin_orangtua" <?= $get->jenis_file == 'izin_orangtua' ? 'selected' : '' ?>>Surat Izin Orang Tua / Wali</option>
								<option value="pengantar_rt" <?= $get->jenis_file == 'pengantar_rt' ? 'selected' : '' ?>>Surat Pengantar RT/RW</option>
								<option value="dokumen_panduan" <?= $get->jenis_file == 'dokumen_panduan' ? 'selected' : '' ?>>Dokumen Panduan</option>
								<option value="lainnya" <?= $get->jenis_file == 'lainnya' ? 'selected' : '' ?>>Lainnya</option>
							</select>
						</div>
						<hr>
						
						<button class="btn btn-primary pull-right" type="submit"> <i class="ri-refresh-line "></i>  Update  </button>
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>