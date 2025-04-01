<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
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
								<p class="mb-0">Dinas Pendidikan Kabupaten Sinjai</p>
							</div>
						</div>
					</div>
					<div class="right-block position-relativ">
						<img src="<?= base_url() ?>assets/images/page-img/34.png" class="img-fluid image-absulute image-absulute-1">
						<img src="<?= base_url() ?>assets/images/page-img/35.png" class="img-fluid image-absulute image-absulute-2">
					</div>
				</div>
			</div>
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
										<a href="<?= base_url() ?>siswa/daftar/index/?jalur=<?= $value->id ?>">Selengkapnya...</a>
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
		<div class="row">
			<?php foreach ($levelSekolahs as $levelSekolah) : ?>
				<div class="col-md-4">
					<div class="iq-card iq-card-block iq-card-stretch iq-card-height" style="<?= $levelSekolah->color ?>">
						<div class="iq-card-body relative-background">
							<a href="#">
								<div class="d-flex align-items-center">
									<img src="<?= base_url() ?>assets/images/<?= $levelSekolah->logo ?>" alt="" width="80px" style="padding-right:10px;">
									<div class="text-left">
										<h6 class="text-white"> <?= $levelSekolah->level_sekolah ?></h6>
										<h2 class="text-white"> <?= totalByTingkatan('', $levelSekolah->id) ?> <small style="font-size:14px;"></small> </h2>
										<a class="text-white" href="<?= base_url() ?>siswa/daftar/index/?tingkat=<?= $levelSekolah->id ?>">Selengkapnya...</a>
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
					<div class="col-md-4">
						<canvas style="width: 100% !important;height: 50px !important; margin-top:50px;" height="200" id="graph">
					</div>


					<div class="col-md-8">
						<canvas style="width: 100% !important;height: 50px !important;" height="400" id="myChart4">
					</div>

					<div class="col-md-12" style="margin-top:60px;">
						<canvas style="width: 100% !important;height: 50px !important;" height="400" id="smp">
					</div>

					<div class="col-md-12" style="margin-top:60px;">
						<canvas style="width: 100% !important;height: 50px !important;" height="400" id="sd">
					</div>


					<div class="col-md-12" style="margin-top:60px;">
						<canvas style="width: 100% !important;height: 50px !important;" height="400" id="tk">
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
			labels: ["TK", "SD", "SMP"],
			datasets: [
				<?php foreach ($jalurs as $value) : ?> {
						label: '<?= $value->nama ?>',
						backgroundColor: '<?= $value->rgba ?>',
						data: [<?= totalByTingkatan($value->id, '4') ?>, <?= totalByTingkatan($value->id, '5') ?>, <?= totalByTingkatan($value->id, '6') ?>],
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
					stacked: true,
					gridLines: {
						display: false,
					}
				}],
				yAxes: [{
					stacked: true,
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

			tooltips: {
				displayColors: true,
				callbacks: {
					mode: 'x',
				},
			},


		}
	});
</script>


<script>
	function getRandomColor() {
		var letters = '0123456789ABCDEF'.split('');
		var color = '#';
		for (var i = 0; i < 6; i++) {
			color += letters[Math.floor(Math.random() * 16)];
		}
		return color;
	}


	var tk = document.getElementById("tk").getContext("2d");
	var MeSeData_tk = {
		labels: [
			<?php
			$top_10_tk = $this->home->top_10('4');
			foreach ($top_10_tk as $rekap_tk) {
				echo ' " ' . $rekap_tk->nm_sekolah . ' ", ';
			}
			?>
		],

		datasets: [{
			label: "TOP 10 PEMINAT TINGKAT TK  - KABUPATEN SINJAI  ",
			data: [
				<?php
				foreach ($top_10_tk as $rekap_tk) {
					echo ' " ' . $rekap_tk->total . ' ", ';
				}
				?>

			],
			backgroundColor: [<?php
								foreach ($top_10_tk as $rekap_tk) {
								?>
					getRandomColor(),
				<?php
								}
				?>
			],
			// hoverBackgroundColor: ["#66A2EB", "#FCCE56"]
		}]
	};

	var MeSeChart = new Chart(tk, {
		type: 'horizontalBar',
		data: MeSeData_tk,
		options: {
			scales: {
				xAxes: [{
					ticks: {
						min: 0
					}
				}],
				yAxes: [{
					stacked: true
				}],
			},

			responsive: true,
			maintainAspectRatio: false,

		}
	});




	var sd = document.getElementById("sd").getContext("2d");
	var MeSeData_sd = {
		labels: [
			<?php
			$top_10_sd = $this->home->top_10('5');
			foreach ($top_10_sd as $rekap_sd) {
				echo ' " ' . $rekap_sd->nm_sekolah . ' ", ';
			}
			?>
		],

		datasets: [{
			label: "TOP 10 PEMINAT TINGKAT SD  - KABUPATEN SINJAI  ",
			data: [
				<?php
				foreach ($top_10_sd as $rekap_sd) {
					echo ' " ' . $rekap_sd->total . ' ", ';
				}
				?>

			],
			backgroundColor: [<?php
								foreach ($top_10_sd as $rekap_sd) {
								?>
					getRandomColor(),
				<?php
								}
				?>
			],
			// hoverBackgroundColor: ["#66A2EB", "#FCCE56"]
		}]
	};

	var MeSeChart = new Chart(sd, {
		type: 'horizontalBar',
		data: MeSeData_sd,
		options: {
			scales: {
				xAxes: [{
					ticks: {
						min: 0
					}
				}],
				yAxes: [{
					stacked: true
				}],
			},

			responsive: true,
			maintainAspectRatio: false,

		}
	});






	var smp = document.getElementById("smp").getContext("2d");
	var MeSeData_smp = {
		labels: [
			<?php
			$top_10_smp = $this->home->top_10('6');
			foreach ($top_10_smp as $rekap_smp) {
				echo ' " ' . $rekap_smp->nm_sekolah . ' ", ';
			}
			?>
		],

		datasets: [{
			label: "TOP 10 PEMINAT TINGKAT SMP  - KABUPATEN SINJAI  ",
			data: [
				<?php
				foreach ($top_10_smp as $rekap_smp) {
					echo ' " ' . $rekap_smp->total . ' ", ';
				}
				?>

			],

			backgroundColor: [<?php
								foreach ($top_10_smp as $rekap_smp) {
								?>
					getRandomColor(),
				<?php
								}
				?>
			],
			// hoverBackgroundColor: ["#66A2EB", "#FCCE56"]
		}]
	};

	var MeSeChart = new Chart(smp, {
		type: 'horizontalBar',
		data: MeSeData_smp,
		options: {
			scales: {
				xAxes: [{
					ticks: {
						min: 0
					}
				}],
				yAxes: [{
					stacked: true
				}],
			},
			plugins: {
				datalabels: {
					formatter: function(value) {
						return value + '%';
					}
				}
			},


			responsive: true,
			maintainAspectRatio: false,

		}
	});
</script>