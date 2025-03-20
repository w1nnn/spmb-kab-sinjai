<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<a href="#" onclick="goBack()" class="btn btn-sm btn-warning mb-2 "> <i class="ri-arrow-go-back-line "></i> Kembali </a>
				<div class="clearfix"></div>
				<div class="iq-advance-course ">
					<br>
					<h4> <?= $get->nama ?>  </h4>
					<hr>
					<?= $get->deskripsi ?>
					<a href="<?= base_url()?>uploads/lampiran/<?= $get->lampiran ?>" class="btn btn-outline-primary"> Lampiran  </a>
					
				</div>
			</div>
		</div>
	</div>
</div>
