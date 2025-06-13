<?php 
	$npsn  = $this->input->get('npsn');
	$jalur = $this->input->get('jalur');
	$sts_dtks = $this->input->get('sts_dtks');
?>
<div class="row">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<div class="row">
					<div class="col-md-12">
						<form action="#">
						<div class="row mb-4">
							<div class="col-md-3">
								<select name="jalur" class="form-control select2" id="jalur" required>
									<option value=""> Tampilkan Berdasarkan Jalur </option>
									<option value="all" <?= ($jalur == "all") ? "selected":"";  ?> > Semua Jalur  </option>
									<?php 
										foreach($jalurs AS $jalurx){
										if($jalurx->id == $jalur ) { $select = "selected"; }else{ $select = ""; }
									?>
										<option value="<?= $jalurx->id ?>" <?= $select ?>> <?= $jalurx->nama ?> </option>
									<?php } ?>
								</select>
							</div>
							<?php  if(level_user() == "admin" || level_user()  == "superadmin" ){   ?>
							<div class="col-md-5">
									<select name="npsn" class="form-control sekolah select2" required>
									<option value=""> Pilih Sekolah</option>
									<?php 
										foreach ($sekolah AS $getSekolah): 
										if($getSekolah->npsn == $npsn){ $selected = "selected"; }else{ $selected = ""; }
									?>
										<option value="<?= $getSekolah->npsn ?>" <?= $selected ?> > <?= $getSekolah->nama ?> </option>
									<?php endforeach; ?>
								</select>
							</div>
							<?php } ?>
							<?php  if(level_user() == "admin" || level_user()  == "superadmin"  || level_user()  == "sekolah" ){   ?>
							<div class="col-md-4 mb-2">
								<select id="sts_dtks" name="sts_dtks" class="form-control">
									<option value="">Semua Pendaftar</option>
									<option value="1">Terdaftar DTKS</option>
									<option value="0">Tidak Terdaftar DTKS</option>
									<option value="3">Proses Verivikasi DTKS</option>
								</select>
							</div>
							<?php } ?>

							<div class="col-md-2">
								<button type="submit" class="btn btn-lg btn-block btn-primary"> <i class="ri-search-2-line"></i> Tampilkan </button>
							</div>

							<div class="col-md-2">
								<div class="pull-right">
									<a href="<?= base_url()?>sekolah/excel?jalur=<?= $this->input->get('jalur') ?>&npsn=<?= $this->input->get('npsn') ?>&sts_dtks=<?= $this->input->get('sts_dtks') ?>" target="blank" class="btn btn-success btn-lg "> <i class="ri-file-excel-2-fill"></i> Export to Excel  </a>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						</form>
						<hr>
						<?php 
							if(level_user() == "admin" || level_user()  == "superadmin" ){ 
							
								if(!empty($npsn) AND !empty($jalur)) {
						?>
							
							<h4>Daftar Calon Siswa <b><?= sekolah($npsn)->nama; ?></b> </h4>
							<h5><b><?= jalur($jalur)->nama ?></b> </h5>
							<br>
							<div class="table-responsive">
							<table class="table table-hover" id="table">
								<thead class="text-center iq-bg-primary">
								<tr>
									<th style="width:2%">No.</th>
									<th style="width:20%">Nama </th>
									<th>TTL </th>
									<th>Jenis Kelamin </th>
									<th>Jalur </th>
									<th> Sekolah </th>
									<th>Kecamatan </th>
									<th>Lingkungan </th>
									<th>Asal Sekolah </th>
									<th>Nama Ayah</th>
									<th>Nama Ibu</th>
									<th>No. Hp</th>
									<th>Tanggal Terdaftar </th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$no = 1;
								foreach($siswas AS $siswa){
								?>
								<tr>
									<td><?= $no++ ?> </td>
									<td><b><a href="">  <?= strtoupper($siswa->nama_siswa) ?> </a> </b> </td>
									<td><?= $siswa->tempat_lahir ?>, <?= tgl_indo($siswa->tgl_lahir) ?>  </td>
									<td><?= jk($siswa->jk)  ?></td>
									<td><?= jalur($siswa->jalur)->nama  ?></td>
									<td> <?= sekolah($siswa->pilihan_sekolah_1)->nama ?> </td>
									<td> <?= kecamatan($siswa->kec)->nama_kec ?> </td>
									<td> <?= dusun($siswa->dusun)->daerah_zonasi ?> </td>
									<td> <?= $siswa->asal_sekolah ?></td>
									<td> <?= $siswa->nm_ayah ?> </td>
									<td> <?= $siswa->nm_ibu ?> </td>
									<td> <?= $siswa->no_hp_ortu ?> </td>
									<td> <?= tgl_indo($siswa->tgl_daftar) ?> </td>
								</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
						
						<?php 
							}

						}elseif (level_user() == "sekolah" ) { ?>

						<div class="table-responsive">
							<table class="table table-hover" id="table">
								<thead class="text-center iq-bg-primary">
								<tr>
									<th style="width:2%">No.</th>
									<th style="width:20%">Nama </th>
									<th>TTL </th>
									<th>Jenis Kelamin </th>
									<th>Jalur </th>
									<?php if(level_user() == "admin" || level_user() == "superadmin"){ ?>
									<th> Sekolah </th>
									<?php } ?>
									<th>Kecamatan </th>
									<th>Lingkungan </th>
									<th>Asal Sekolah </th>
									<th>Nama Ayah</th>
									<th>Nama Ibu</th>
									<th>No. Hp</th>
									<th>Tanggal Terdaftar </th>
								</tr>
								</thead>
								<tbody>
								<?php 
								$no = 1;
								foreach($siswas AS $siswa){
								?>
								<tr>
									<td><?= $no++ ?> </td>
									<td><b><a href="">  <?= strtoupper($siswa->nama_siswa) ?> </a> </b> </td>
									<td><?= $siswa->tempat_lahir ?>, <?= tgl_indo($siswa->tgl_lahir) ?>  </td>
									<td><?= jk($siswa->jk)  ?></td>
									<td><?= jalur($siswa->jalur)->nama  ?></td>
									
									<?php if(level_user() == "admin" || level_user() == "superadmin"){ ?>
									<td> <?= sekolah($siswa->pilihan_sekolah_1)->nama ?> </td>
									<?php } ?>

									<td> <?= kecamatan($siswa->kec)->nama_kec ?> </td>
									<td> <?= dusun($siswa->dusun)->daerah_zonasi ?> </td>
									<td> <?= $siswa->asal_sekolah ?></td>
									<td> <?= $siswa->nm_ayah ?> </td>
									<td> <?= $siswa->nm_ibu ?> </td>
									<td> <?= $siswa->no_hp_ortu ?> </td>
									<td> <?= tgl_indo($siswa->tgl_daftar) ?> </td>
								</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
						<?php } ?>


					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
    $(document).ready(function () {
        $('#table').DataTable({
			"oLanguage": {
                "sSearch": '',
                "sSearchPlaceholder": "Cari ... ",
            },
            dom: 'Bfrtip',
			"paginate" : false,
			"info" :false
		});
	});

</script>

