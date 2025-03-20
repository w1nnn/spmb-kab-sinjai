<li class="">
	<a href="<?= base_url() ?>home/dashboard" class="iq-waves-effect"><i class="ri-dashboard-line"></i><span>Dashboard</span></a>
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
		foreach ($jalurs AS $jalur):
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
		foreach ($jenisSekolah AS $value):
		?>
			<li><a href="<?= base_url() ?>sekolah?level=<?= $value->id ?>"><?= $value->level_sekolah ?> </a></li>
		<?php endforeach; ?>
		<?php if(level_user() == "admin" || level_user() == "superadmin" ){ ?>
		<li><a href="<?= base_url() ?>sekolah/tambah">Tambah Sekolah </a></li>
		<?php } ?>

	</ul>
</li>


