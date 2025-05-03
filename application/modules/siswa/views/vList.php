<!-- Add these in your <head> section -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<div class="row ">
	<div class="col-md-12">
		<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
			<div class="iq-card-body">
				<div class="iq-advance-course ">
					<?php if (level_user() == 'superadmin' || level_user() == 'admin') : ?>
						<form class="form-list form-horizontal pull-left" method="get">
							<div class="row">
								<div class="form-group col-md-3">
									<select name="tingkat" class="form-control pull-left" onchange="$(this).closest('form').submit()">
										<?php $tnkt = [
											'' => 'Semua Tingkat',
											4 => 'Tingkat TK',
											5 => 'Tingkat SD',
											6 => 'Tingkat SMP'
										]; ?>
										<?php foreach ($tnkt as $t => $n) : ?>
											<option <?= $t == $this->input->get('tingkat') ? 'selected' : '' ?> value="<?php echo $t ?>"><?php echo $n ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group col-md-3">
									<select name="jalur" class="form-control pull-left" onchange="$(this).closest('form').submit()">
										<?php $jlur = [
											'' => 'Semua Jalur',
											114 => 'Jalur Domisili',
											115 => 'Jalur Afirmasi',
											116 => 'Jalur Pindah Tugas',
											117 => 'Jalur Prestasi'
										]; ?>
										<?php foreach ($jlur as $j => $n) : ?>
											<option <?= $j == $this->input->get('jalur') ? 'selected' : '' ?> value="<?php echo $j ?>"><?php echo $n ?></option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="form-group col-md-3">
									<input type="text" name="npsn" class="form-control" value="<?php echo $this->input->get('npsn') ?>" placeholder="NPSN Sekolah">
								</div>
								<div class="form-group col-md-3">
									<select name="sts_dtks" class="form-control pull-left" onchange="$(this).closest('form').submit()">
										<?php $status_dtks = [
											'' => 'Semua Status DTKS',
											'1' => 'Terdaftar DTKS',
											'0' => 'Tidak Terdaftar DTKS'
										]; ?>
										<?php foreach ($status_dtks as $v => $n) : ?>
											<option <?= (string)$v == (string)$this->input->get('sts_dtks') ? 'selected' : '' ?> value="<?php echo $v ?>"><?php echo $n ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</form>
						<div class="clearfix"></div>
						<div class="bexcel">
							<a href="<?= base_url() ?>siswa/daftar/excel?tingkat=<?= $this->input->get('tingkat') ?>&npsn=<?= $this->input->get('npsn') ?>&jalur=<?= $this->input->get('jalur') ?>&sts_dtks=<?= $this->input->get('sts_dtks') ?>" target="blank" class="btn btn-success btn-lg "> <i class="ri-file-excel-2-fill"></i> Export to Excel </a>
						</div>
					<?php endif; ?>
					<div class="table-responsive">
						<table class="table table-hover" id="table">
							<thead class="text-center iq-bg-primary">
								<tr>
									<th style="width:2%">No.</th>
									<th>Foto </th>
									<th>Nama </th>

									<th>TTL </th>
									<?php if (level_user() == "admin" || level_user() == "superadmin") { ?>
										<th> Sekolah Tujuan </th>
									<?php } ?>
									<th>Kecamatan </th>
									<th>Lingkungan </th>
									<th>Status </th>
									<th style="width:20%"></th>
								</tr>
							</thead>
							<tbody>

							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
	var save_method; //for save method string
	var table;
	var tl;


	$(document).ready(function() {
		//datatables
		$("select[name=sts_dtks]").change(function() {
        console.log("DTKS changed to: " + $(this).val());
        table.ajax.reload();
    });
		table = $('#table').DataTable({
			//
			"oLanguage": {
				"oPaginate": {
					"sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
					"sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
				},
				"sSearch": '',
				"sSearchPlaceholder": "Cari...",
			},
			dom: 'Bfrtip',
			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.
			"order": [], //Initial no order.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo $url  ?>",
				"type": "POST",
			},

			//Set column definition initialisation properties.
			"columnDefs": [{
				"targets": [-1], //last column
				"orderable": false, //set not orderable
			}, ],

		});

		//set input/textarea/select event when change value, remove class error and remove text help block
		$("input").change(function() {
			$(this).parent().parent().removeClass('has-error');
			$(this).next().empty();
		});

		$("input[name=npsn]").on("change keyup", function() {
			const th = $(this);
			if (tl != undefined) {
				clearTimeout(tl);
			}
			tl = setTimeout(() => {
				th.closest('form').submit()
			}, 3000);
		});

		// Make sure the table refreshes when the URL changes (due to form submission)
		var currentUrl = window.location.href;
		setInterval(function() {
			if (currentUrl != window.location.href) {
				currentUrl = window.location.href;
				table.ajax.reload();
			}
		}, 500);
	});

	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax
	}


	function delete_(id) {
		if (confirm('Anda yakin ingin menghapus data ?')) {
			// ajax delete data to database

			$.ajax({
				url: "<?php echo site_url('siswa/daftar/ajax_delete') ?>/" + id,
				type: "POST",
				dataType: "JSON",
				success: function(data) {
					//if success reload ajax table
					reload_table();
					toastr.error('Berhasil Menghapus Data');

				},
				error: function(jqXHR, textStatus, errorThrown) {
					alert('Error deleting data');
				}
			});

		}
	}
</script>
