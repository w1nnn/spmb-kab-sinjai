<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 "> <i class="ri-arrow-go-back-line "></i> Kembali </a>
				<div class="clearfix"></div>
				<div class="iq-advance-course ">
					
					<form action="<?= base_url()?>dokumen/manage/save" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<label for=""> Nama <span class="text-danger">*</span> </label>
							<input type="text" class="form-control" name="nama" autocomplete="off" required>
						</div>
						
						<div class="form-group">
							<label for=""> Lampiran (jpg/pdf) </label>
							<input type="file" class="form-control-file" name="lampiran" autocomplete="off">
						</div>
						<div class="form-group">
							<label for=""> Jenis File <span class="text-danger">*</span> </label>
							<select name="jenis_file" class="form-control" required>
								<option value="">-- Pilih Jenis File --</option>
								<option value="sktm">Surat Keterangan Tidak Mampu (SKTM)</option>
								<option value="surat_aktif">Surat Keterangan Aktif Sekolah</option>
								<option value="surat_pindah">Surat Pindah Sekolah</option>
								<option value="surat_lulus">Surat Keterangan Lulus</option>
								<option value="rapor">Rapor</option>
								<option value="ijazah">Ijazah</option>
								<option value="ktp">Kartu Tanda Penduduk (KTP)</option>
								<option value="kk">Kartu Keluarga (KK)</option>
								<option value="kip">Kartu Indonesia Pintar (KIP)</option>
								<option value="kks">Kartu Keluarga Sejahtera (KKS)</option>
								<option value="foto">Pas Foto Terbaru</option>
								<option value="permohonan_beasiswa">Surat Permohonan Beasiswa</option>
								<option value="rekomendasi_sekolah">Surat Rekomendasi dari Sekolah</option>
								<option value="izin_orangtua">Surat Izin Orang Tua / Wali</option>
								<option value="pengantar_rt">Surat Pengantar RT/RW</option>
								<option value="dokumen_panduan">Dokumen Panduan</option>
								<option value="lainnya">Lainnya</option>
							</select>
						<hr>
						<button class="btn btn-primary pull-right" type="submit"> <i class="ri-save-line"></i>  Simpan  </button>
						<div class="clearfix"></div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
