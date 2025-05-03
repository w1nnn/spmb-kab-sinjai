<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<div class="iq-advance-course ">

					<ul class="iq-timeline">
						<li>
							<div class="timeline-dots"></div>
							<h6 class="float-left mb-1">Buat Akun </h6>
							<div class="d-inline-block w-100">
								<p>Buat akun, masukan nama, nomor induk kependudukan (NIK), dan password</p>
							</div>
						</li>
						<li>
							<div class="timeline-dots"></div>
							<h6 class="float-left mb-1">Pilih Tingkatan Sekolah Dan Jalur Pendaftaran </h6>
							<div class="d-inline-block w-100">
								<p>Pilih tingkatan sekolah dan pilih jalur sesuai minat anda , klik <a href="<?= base_url() ?>jalur"> disini </a> untuk penjelasan jalur pendaftaram </p>
							</div>
						</li>
						<li>
							<div class="timeline-dots"></div>
							<h6 class="float-left mb-1">Lengkapi Data Diri </h6>
							<div class="d-inline-block w-100">
								<p>Lengkapi data diri, pilih sekolah tujuan dan upload berkas persyaratan. klik <a href="#" data-toggle="modal" data-target="#dok">Disini</a> untuk melihat daftar berkas yang akan diupload </p>
							</div>
						</li>
						<li>
							<div class="timeline-dots"></div>
							<h6 class="float-left mb-1">Review dan Selesaikan data pendaftaran</h6>
							<div class="d-inline-block w-100">
								<p>Review data sebelum menyelesaikan pendaftaran</p>
							</div>
						</li>
						<li>
							<div class="timeline-dots"></div>
							<h6 class="float-left mb-1">Klik Selesai dan menunggu pengumuman dari sekolah </h6>
							<div class="d-inline-block w-100">
								<p>Setelah selesai melengkapi data pendaftaran, Calon siswa menunggu hasil pengumuman dari sekolah masing - masing </p>
							</div>
						</li>
						<li>
							<div class="timeline-dots"></div>
							<h6 class="float-left mb-1">Ada masalah ketika melakukan proses pendaftaran? </h6>
							<div class="d-inline-block w-100">
								<p>Jika mendapati masalah ketika melakukan proses pendaftaran, silahkan klik <a href="https://disdik.macca.id/aduan-ppdb" target="_blank" class="text-white bg-primary font-weight-bold" style="padding: 3px 7px;border-radius: 5px"><i class="fa fa-fw fa-question-circle"></i> DI SINI</a> untuk melaporkan masalah tersebut agar segera ditindaklanjuti oleh operator kabupaten.</p>
							</div>
						</li>

					</ul>

					<a href="<?= base_url() ?>uploads/panduan/<?= $get->panduan ?>" target="blank" class="btn btn-lg mt-1 btn-primary"> <i class="ri-download-2-fill"></i> Download Panduan Pendaftaran </a>
					<!-- <a href="<?= base_url() ?>assets/ppdb.apk" class="btn btn-lg mt-1 btn-success"> <i class="ri-download-2-fill"></i> Download Aplikasi PPDB  </a>
				<a href="<?= base_url() ?>assets/ppdb-admin.apk" class="btn btn-lg mt-1 btn-danger"> <i class="ri-download-2-fill"></i> Download Aplikasi PPDB Admin  </a> -->


				</div>
			</div>
		</div>
	</div>
</div>

<div class="modal fade " id="dok" tabindex="-1" role="dialog">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"> Persyaratan Dokumen</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">
				<h5>Dokumen Umum yang perlu dipersiapkan sebelum mendaftar : </h4>
					<ol>
						<li> Scan Kartu Keluarga </li>
						<li> Scan Akta Kelahiran Calon Pendaftar </li>
						<li> Foto 3x4 </li>
						<li> Surat Keterangan Lulus, Khusus untuk pendaftar di TK digantikan dengan Surat Imunisasi </li>
					</ol>

					<h5>Dokumen khusus per jalur yang dipilih : </h4>
						<ol>
							<li> Jalur Afirmasi : <b> Surat Keterangan Tidak Mampu </b> </li>
							<li> Jalur Perpindahan Orang Tua : <b> Surat Keterangan Pindah Tugas Orang Tua </b> </li>
							<li> Jalur Prestasi : <b> Bukti Prestasi (piagam / sertifikat / nilai raport ) </b> </li>
						</ol>


			</div>
			<div class="modal-footer">
				<button data-dismiss="modal" class="btn btn-outline-primary"> Keluar </button>
			</div>
		</div>
	</div>
</div>