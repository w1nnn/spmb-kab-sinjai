

<li class="">
	<a href="<?= base_url()?>siswa/profil" class="iq-waves-effect"> <i class="ri-mail-send-line"></i><span>Daftar  </span></a>
</li>
<li class="">
	<a href="<?= base_url()?>jalur/" class="iq-waves-effect"> <i class="ri-mail-send-line"></i><span>Jalur Pendaftaran  </span></a>
</li>


<li class="">
	<a href="<?= base_url()?>profil/panduan" class="iq-waves-effect"> <i class="ri-mail-send-line"></i><span>Panduan Pendaftaran  </span></a>
</li>

<li class="">
	<a href="#pendaftar" class="iq-waves-effect collapsed" data-toggle="collapse" aria-expanded="true">
		<i class="ri-hotel-line"></i><span>Sekolah </span>
		<i class="ri-arrow-right-s-line iq-arrow-right"></i>
	</a>
	<ul id="pendaftar" class="iq-submenu collapse" data-parent="#iq-sidebar-toggle">
		<?php
		$this->load->model('sekolah/sekolah_model', 'sekolah');
		$jenisSekolah = $this->sekolah->get_level_sekolah();
		foreach ($jenisSekolah AS $value):
			?>
			<li><a href="<?= base_url() ?>sekolah?level=<?= $value->id ?>"><?= $value->level_sekolah ?> </a></li>
		<?php endforeach; ?>
	</ul>
</li>

<!-- <li class="#">
	<a href="<?= base_url()?>pengumuman/manage" class="iq-waves-effect"> <i class="ri-mail-send-line"></i><span>Ubah Password </span></a>
</li> -->



