<style>
	.table td, .table th{
		/*padding:15px 5px 10px 5px;*/
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height ">
			<div class="iq-card-body relative-background">
				<form action="">
				<div class="row">
					<div class="col-md-6">
						<div class="table-repsonsive">
							<table class="table table-hover">
								<tr>
									<td colspan="3">
										<h4>Data Diri</h4>
									</td>
								</tr>
								<tr>
									<td width="35%">Nama </td>
									<td width="2%">: </td>
									<td> <?= $get->nama_siswa ?> </td>
								</tr>
								<tr>
									<td>Tempat / Tanggal Lahir </td>
									<td>: </td>
									<td> <?= $get->tempat_lahir ?> / <?= tgl_indo($get->tgl_lahir) ?> </td>
								</tr>
								<tr>
									<td>Jenis Kelamin </td>
									<td>: </td>
									<td> <?= jk($get->jk); ?> </td>
								</tr>
								<tr>
									<td>Agama </td>
									<td>: </td>
									<td> <?= $get->agama ?> </td>
								</tr>
								<tr>
									<td>Ukuran Baju  </td>
									<td>: </td>
									<td> <?= $get->ukuran_baju ?> </td>
								</tr>
								<tr>
									<td>Asal Sekolah </td>
									<td>: </td>
									<td> <?= $get->asal_sekolah ?> </td>
								</tr>
								<tr>
									<td>Alamat</td>
									<td>: </td>
									<td> <?= $get->alamat ?> </td>
								</tr>
								<tr>
									<td>Kecamatan </td>
									<td>: </td>
									<td> <?= $get->nama_kec ?> </td>
								</tr>
								<tr>
									<td>Lingkungan </td>
									<td>: </td>
									<td> <?= $get->daerah_zonasi ?>  </td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-md-6">
						<div class="table-repsonsive">
							<table class="table table-hover">
								<tr>
									<td colspan="3">
										<h4>Data Orang Tua / Wali </h4>
									</td>
								</tr>
								<tr>
									<td width="35%">Nama Ayah  </td>
									<td width="2%">: </td>
									<td> <?= $get->nm_ayah  ?>  </td>
								</tr>
								<tr>
									<td>Pekerjaan Ayah  </td>
									<td>: </td>
									<td> <?= $get->pekerjaan_ayah  ?>  </td>
								</tr>
								<tr>
									<td>Nama Ibu  </td>
									<td>: </td>
									<td> <?= $get->nm_ibu  ?>  </td>
								</tr>
								<tr>
									<td>Pekerjaan Ibu  </td>
									<td>: </td>
									<td> <?= $get->pekerjaan_ibu  ?>  </td>
								</tr>
								<tr>
									<td>Nama Wali  </td>
									<td>: </td>
									<td> <?= $get->nm_wali  ?>  </td>
								</tr>
								<tr>
									<td>Pekerjaan Wali  </td>
									<td>: </td>
									<td> <?= $get->pekerjaan_wali  ?>  </td>
								</tr>
								<tr>
									<td>No Handphone  </td>
									<td>: </td>
									<td> <?= $get->no_hp_ortu  ?>  </td>
								</tr>
								
							</table>
						</div>
					</div>
				
					<div class="col-md-6">
						<div class="table-repsonsive">
							<table class="table table-hover">
								<tr>
									<td colspan="3">
										<h4>Data Pendaftaran</h4>
									</td>
								</tr>
								<tr>
									<td width="35%">Jalur Pendaftaran </td>
									<td width="2%">: </td>
									<td> <?= jalur($get->jalur)->nama ?> </td>
								</tr>
								<tr>
									<td> Pilihan Sekolah 1 </td>
									<td>: </td>
									<td> <?= sekolah($get->pilihan_sekolah_1)->nama ?> </td>
								</tr>
								<tr>
									<td> Pilihan Sekolah 2 </td>
									<td>: </td>
									<td> <?= sekolah($get->pilihan_sekolah_2)->nama ?> </td>
								</tr>
							</table>
						</div>
					</div>
					
					<div class="col-md-6">
						<div class="table-repsonsive">
							<table class="table table-hover">
								<tr>
									<td colspan="3">
										<h4>Lampiran Dokumen</h4>
									</td>
								</tr>
								<tr>
									<td width="35%"> KTP </td>
									<td width="2%">: </td>
									<td><a href="<?= base_url()?>uploads/siswa/<?= $get->ktp_ortu ?>"> <?= $get->ktp_ortu ?> </a> </td>
								</tr>
								<tr>
									<td> KK </td>
									<td>: </td>
									<td><a href="<?= base_url()?>uploads/siswa/<?= $get->kk ?>"> <?= $get->kk ?> </a> </td>
								</tr>
								<tr>
									<td> Akta Kelahiran </td>
									<td>: </td>
									<td><a href="<?= base_url()?>uploads/siswa/<?= $get->akta_kelahiran ?>"> <?= $get->akta_kelahiran ?> </a> </td>
								</tr>
								<tr>
									<td> Bukti </td>
									<td>: </td>
									<td> </td>
								</tr>
							</table>
						</div>
					</div>
					<div class="col-md-8 offset-2 col-xs-12 col-xs-offset-12">
						<hr>
						<p><input type="checkbox" required >  Saya nyatakan data yang saya isi benar-benar sesuai dengan data yang sesungguhnya dan saya siap  mendapatkan sanksi apabila dikemudian hari ada data yg terbukti saya rekayasa.  </p>
						<p> <input type="checkbox" required > Dengan mengisi formulir pendaftaran ini saya nyatakan bersedia mengikuti seluruh peraturan yang berlaku pada sekolah dan tidak menuntut apabila dikemudian hari saya melanggar dan diberi sanksi atau dikeluarkan dari sekolah</p>
						
						<a href="" class="btn btn-warning"> <i class="ri-edit-2-line"></i>  Edit Data  </a>
						<button class="btn btn-primary" type="submit" > <i class="ri-save-2-line"></i>  Simpan  </button>
					</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
