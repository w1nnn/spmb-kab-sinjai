<li class="">
	<a href="<?= base_url() ?>home/dashboard" class="iq-waves-effect"><i class="ri-dashboard-line"></i><span>Dashboard</span></a>
</li>
<li class="">
	<a href="#profil" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="true">
		<i class="ri-hotel-line"></i><span>Profil </span><i class="ri-arrow-right-s-line iq-arrow-right"></i>
	</a>
	<ul id="profil" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
		<li><a href="<?= base_url() ?>profil/manage/sambutan">Sambutan </a></li>
		<li><a href="<?= base_url() ?>profil/manage/ppdb">Apa itu PPDB ? </a></li>
		<li><a href="<?= base_url() ?>profil/manage/kontak">Kontak </a></li>
	</ul>
</li>


<li class="">
	<a href="#pendaftar" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="true">
		<i class="ri-user-add-line"></i><span>Pendaftar </span>
		<i class="ri-arrow-right-s-line iq-arrow-right"></i>
	</a>
	<ul id="pendaftar" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
		<li><a href="<?= base_url() ?>siswa/daftar/index/"> Semua Jalur </a></li>
		<?php
		$this->load->model('jalur/jalur_model', 'jalur');
		$jalurs = $this->jalur->get_all();
		foreach ($jalurs as $jalur) :
		?>
			<li><a href="<?= base_url() ?>siswa/daftar/index/?jalur=<?= $jalur->id ?>"><?= $jalur->nama ?> </a></li>
		<?php endforeach; ?>
	</ul>
</li>


<li class="">
	<a href="#sekolah" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="true">
		<i class="ri-building-line "></i><span>Sekolah </span>
		<i class="ri-arrow-right-s-line iq-arrow-right"></i>
	</a>
	<ul id="sekolah" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
		<?php
		$this->load->model('sekolah/sekolah_model', 'sekolah');
		$jenisSekolah = $this->sekolah->get_level_sekolah();
		foreach ($jenisSekolah as $value) :
		?>
			<li><a href="<?= base_url() ?>sekolah?level=<?= $value->id ?>"><?= $value->level_sekolah ?> </a></li>
		<?php endforeach; ?>
		<?php if (level_user() == "admin" || level_user() == "superadmin") { ?>
			<li><a href="<?= base_url() ?>sekolah/tambah">Tambah Sekolah </a></li>
		<?php } ?>
	</ul>
</li>


<li class="">
	<a href="<?= base_url() ?>sekolah/laporan" class="iq-waves-effect"><i class="ri-booklet-line"></i><span>Laporan </span></a>
</li>



<li class="">
	<a href="<?= base_url() ?>sekolah/zonasi" class="iq-waves-effect"><i class="ri-road-map-line "></i><span>Manajemen Zonasi </span></a>
</li>


<li class="">
	<a href="<?= base_url() ?>profil/manage/panduan" class="iq-waves-effect"> <i class="ri-bookmark-line "></i><span>Panduan Pendaftaran </span></a>
</li>

<!-- <li class="">
	<a href="<?= base_url() ?>pengumuman/manage" class="iq-waves-effect"> <i class="ri-mail-send-line"></i><span>Pengumuman </span></a>
</li> -->

<li class="">
	<a href="<?= base_url() ?>dokumen/manage" class="iq-waves-effect"> <i class="ri-article-line"></i><span>Dokumen </span></a>
</li>

<li class="">
	<a href="<?= base_url() ?>regulasi/manage" class="iq-waves-effect"> <i class="ri-auction-line"></i><span>Regulasi </span></a>
</li>


<li class="">
	<a href="#master" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="true">
		<i class="ri-database-2-line "></i><span>Master Data </span>
		<i class="ri-arrow-right-s-line iq-arrow-right"></i>
	</a>
	<ul id="master" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
		<li><a href="<?= base_url() ?>kecamatan/zonasi">Daerah Zonasi Kecamatan </a></li>
		<li><a href="<?= base_url() ?>kecamatan/manage">Kecamatan </a></li>
		<li><a href="<?= base_url() ?>jalur/manage">Jalur Pendaftaran </a></li>
	</ul>
</li>



<li class="">
	<a href="#pengaturan" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="true">
		<i class="ri-settings-2-line "></i><span>Pengaturan </span>
		<i class="ri-arrow-right-s-line iq-arrow-right"></i>
	</a>
	<ul id="pengaturan" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
		<li><a href="<?= base_url() ?>users/manage">Manajemen User </a></li>
		<li><a href="<?= base_url() ?>regulasi/regulasi/jadwal">Pengaturan Jadwal</a></li>
		<li><a href="#">Ubah Password </a></li>
		<!-- <li><a href="index.html">Backup Database </a></li> -->
	</ul>
</li>