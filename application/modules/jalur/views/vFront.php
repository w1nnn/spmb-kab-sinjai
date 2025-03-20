<div class="row">
	<?php foreach ($jalurs AS $value): ?>
		<div class="col-md-12 col-lg-12">
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height ">
				<div class="iq-card-body relative-background">
					<div class="d-flex align-items-center">
						<div class="rounded-circle iq-card-icon iq-bg-<?= $value->color ?> mr-3"><i
									class="<?= $value->icon ?>"></i></div>
						<div class="text-left">
							<h3 class="text-<?= $value->color ?>"> <?= substr($value->nama, 6, 100); ?></h3>
						</div>
					</div>
					<p><?= $value->deskripsi ?></p>
					<div class="background-image">
						<img src="<?= base_url() ?>assets/images/page-img/36.png" class="img-fluid"
						     style="opacity: 0.5;">
					</div>
				</div>
			</div>
		</div>
	<?php endforeach; ?>
</div>
