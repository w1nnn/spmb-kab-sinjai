<li class="">
	<a href="<?= base_url()?>home/dashboard" class="iq-waves-effect"><i class="ri-dashboard-line"></i><span>Beranda</span></a>
</li>

<li class="">
	<a href="<?= base_url()?>sekolah/profil" class="iq-waves-effect"><i class="ri-hotel-line "></i><span>Profil Sekolah</span></a>
</li>
<li class="">
	<a href="#pendaftar" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="true">
		<i class="ri-user-2-line "></i><span>Pendaftar </span>
		<i class="ri-arrow-right-s-line iq-arrow-right"></i>
	</a>
	<ul id="pendaftar" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
		<li><a href="<?= base_url() ?>sekolah/laporan?jalur=all&npsn=<?= $this->session->userdata('npsn'); ?>"> Semua Jalur </a></li>
		<?php
		$this->load->model('jalur/jalur_model', 'jalur');
		$jalurs = $this->jalur->get_all();
		foreach ($jalurs AS $jalur):
		?>
			<li><a href="<?= base_url() ?>sekolah/laporan?jalur=<?= $jalur->id ?>&npsn=<?= $this->session->userdata('npsn'); ?>"><?= $jalur->nama ?> </a></li>
		<?php endforeach; ?>
	</ul>
</li>


<li class="">
	<a href="<?= base_url()?>sekolah/zonasi" class="iq-waves-effect"><i class="ri-road-map-line "></i><span>Manajemen Zonasi </span></a>
</li>

<li class="">
	<a href="<?= base_url()?>sekolah/laporan" class="iq-waves-effect"><i class="ri-booklet-line"></i><span>Laporan  </span></a>
</li>
