<li class="">
	<a href="<?= base_url()?>home/dashboard" class="iq-waves-effect"><i class="ri-dashboard-line"></i><span>Beranda</span></a>
</li>
<li class="">
	<a href="#profil" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="true"><i class="ri-hotel-line"></i><span>Tentang Kami</span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
	<ul id="profil" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
		<li><a href="<?= base_url()?>profil/sambutan">Sambutan  </a></li>
		<li><a href="<?= base_url()?>profil/ppdb">Apa itu PPDB ? </a></li>
	</ul>
</li>


<li class="">
	<a href="<?= base_url()?>profil/panduan" class="iq-waves-effect"><i class="ri-booklet-line"></i><span>Panduan </span></a>
</li>

<li class="">
	<a href="<?= base_url()?>profil/jadwal" class="iq-waves-effect"><i class="ri-calendar-line "></i><span>Jadwal</span></a>
</li>

<li class="">
	<a href="<?= base_url()?>jalur/" class="iq-waves-effect"><i class="ri-git-merge-line"></i><span>Jalur </span></a>
</li>


<li class="">
	<a href="#sekolah" class="iq-waves-effect collapsed"  data-toggle="collapse" aria-expanded="true"><i class="ri-map-pin-line"></i><span>Sekolah </span><i class="ri-arrow-right-s-line iq-arrow-right"></i></a>
	<ul id="sekolah" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
		<?php
		$this->load->model('sekolah/sekolah_model','sekolah');
		$jenisSekolah = $this->sekolah->get_level_sekolah();
		foreach ($jenisSekolah AS $value):
		?>
			<li><a href="<?= base_url()?>sekolah?level=<?= $value->id ?>"><?= $value->level_sekolah ?> </a></li>
		<?php endforeach; ?>
	</ul>
</li>
<li class="">
	<a href="<?= base_url()?>siswa/pengumuman/" class="iq-waves-effect"> <i class="ri-volume-up-line"></i><span>Pengumuman </span></a>
</li>
<li class="">
	<a href="<?= base_url()?>dokumen" class="iq-waves-effect"> <i class="ri-article-line"></i><span>Dokumen </span></a>
</li>
<li class="">
	<a href="<?= base_url()?>regulasi" class="iq-waves-effect"> <i class="ri-auction-line"></i><span>Regulasi </span></a>
</li>

<li class="">
	<a href="<?= base_url()?>profil/kontak" class="iq-waves-effect"> <i class="ri-whatsapp-line"></i><span>Kontak </span></a>
</li>