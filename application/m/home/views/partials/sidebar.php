<div class="iq-sidebar">
	<div class="iq-sidebar-logo d-flex justify-content-between">
		<a href="<?= base_url() ?>">
			<img src="<?= base_url() ?>assets/images/logo-br.jpg" class="img-fluid" alt="" style="width: 160px; height: auto;">
		</a>
		<div class="iq-menu-bt align-self-center">
			<div class="wrapper-menu">
				<div class="line-menu half start"></div>
				<div class="line-menu"></div>
				<div class="line-menu half end"></div>
			</div>
		</div>
	</div>
	<div id="sidebar-scrollbar">
		<nav class="iq-sidebar-menu">
			<ul id="iq-sidebar-toggle" class="iq-menu">
				<?php
				if (level_user() == "superadmin") {
					include("menu/super.php");
				} elseif (level_user() == "admin") {
					include("menu/admin.php");
				} elseif (level_user() == "sekolah") {
					include("menu/sekolah.php");
				} elseif (level_user() == "siswa") {
					include("menu/siswa.php");
				} elseif (level_user() == "kadis") {
					include("menu/kadis.php");
				} else { // public
					include("menu/public.php");
				}
				?>
			</ul>
		</nav>
		<div class="p-3"></div>
	</div>
</div>