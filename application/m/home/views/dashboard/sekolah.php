<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js"></script>

<div class="row ">
	<div class="col-sm-12">


		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">


				<div class="iq-advance-course d-flex align-items-center justify-content-between">
					<div class="left-block">
						<div class="d-flex align-items-center">
							<img src="<?= base_url() ?>assets/images/page-img/29.png" class="img-fluid">
							<div class=" ml-3">
								<h4 class="">Selamat Datang di Sistem Penerimaan Murid Baru</h4>
								<p class="mb-0">Dinas Pendidikan Kabupaten Sinjai .</p>
							</div>
						</div>
					</div>

				</div>
			</div>






		</div>


	</div>

	<div class="col-sm-12">
		<div class="alert alert-success  alert-dismissible text-dark">
			<a href="#" class="close text-dark" data-dismiss="alert" aria-label="close">&times;</a>
			<p style="">
				Perhatian !! Disampaikan ke seluruh operator sekolah, agar melengkapi daerah zona sekolah masing - masing pada Menu Manajemen Zonasi atau <a href="<?= base_url() ?>sekolah/zonasi/add"> Klik Disini </a>
			</p>
		</div>

		<div class="alert alert-success  alert-dismissible text-dark">
			<a href="#" class="close text-dark" data-dismiss="alert" aria-label="close">&times;</a>

			<p style=""> Lihat referensi tentang zonasi sesuai Peraturan Bupati Sinjai Nomor 4 Tahun 2020 Pedoman Pelaksanaan Penerimaan Peserta Didik Baru Pada Satuan Pendidikan <a href="<?= base_url() ?>uploads/lampiran/lampiran_perbup.pdf" target="blank"> disini </a> </p>
		</div>


	</div>



	<div class="col-md-12">
		<div class="row">
			<?php foreach ($jalurs as $value) : ?>
				<div class="col-md-3 col-lg-3">
					<div class="iq-card iq-card-block iq-card-stretch iq-card-height ">
						<div class="iq-card-body relative-background">
							<a href="#">
								<div class="d-flex align-items-center">
									<div class="rounded-circle iq-card-icon iq-bg-<?= $value->color ?> mr-3"><i class="<?= $value->icon ?>"></i></div>
									<div class="text-left">
										<h6 class="text-<?= $value->color ?>"> <?= $value->nama ?></h6>
										<h2 class="text-<?= $value->color ?>"> <?= totalByJalur($value->id) ?> <small style="font-size:14px;">Terdaftar</small> </h2>
										<a href="<?= base_url() ?>siswa/daftar/index/<?= $value->id ?>">Selengkapnya...</a>
									</div>
								</div>

							</a>
						</div>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>

	<div class="col-md-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height ">
			<div class="iq-card-body relative-background">
				<div class="row">
					<div class="col-md-5">
						<canvas style="width: 100% !important;height: 50px !important; margin-top:50px;" height="200" id="graph">
					</div>


					<div class="col-md-7">
						<canvas style="width: 100% !important;height: 50px !important;" height="400" id="myChart4">
					</div>

				</div>
			</div>
		</div>

	</div>


</div>

<script>
	var ctx = document.getElementById("myChart4").getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ["<?= $this->session->userdata('nama') ?>"],
			datasets: [
				<?php foreach ($jalurs as $value) : ?> {
						label: '<?= $value->nama ?>',
						backgroundColor: '<?= $value->rgba ?>',
						data: [<?= totalByJalur($value->id) ?>],
					},
				<?php endforeach; ?>
			],

		},
		options: {
			tooltips: {
				displayColors: true,
				callbacks: {
					mode: 'x',
				},
			},
			scales: {
				xAxes: [{
					stacked: false,
					gridLines: {
						display: false,
					}
				}],
				yAxes: [{
					stacked: false,
					ticks: {
						beginAtZero: true,
					},
					type: 'linear',
				}]
			},
			responsive: true,
			maintainAspectRatio: false,
			legend: {
				position: 'bottom'
			},
		}
	});





	var ctx = document.getElementById('graph').getContext('2d');
	var chart = new Chart(ctx, {
		// The type of chart we want to create
		type: 'doughnut',
		// The data for our dataset
		data: {
			labels: ["Laki - Laki", "Perempuan"],
			datasets: [{

				backgroundColor: [
					"rgba(255, 206, 86, 1)", "rgba(255,99,132,1)"
				],
				data: [<?= $total_genders['L'] ?>, <?= $total_genders['P'] ?>],
			}]
		},

		// Configuration options go here
		options: {
			legend: {
				display: true,
				position: 'bottom'
			},
			//   tooltips: {
			//         enabled: true,
			//         mode: 'index',

			//   }

			tooltips: {
				displayColors: true,
				callbacks: {
					mode: 'x',
				},
			},


		}
	});
</script>