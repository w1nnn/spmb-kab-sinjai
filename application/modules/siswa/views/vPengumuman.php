<div class="row ">
	<div class="col-sm-12">
		<div class="iq-card ">
			<div class="iq-card-body">
				<?php if (date('Y-m-d') >= configs()->pengumuman->start): ?>
					<div class="iq-advance-course ">
						<form action="" method="GET">
							<div class="row">
								<div class="col-md-8">
									<select name="npsn" class="form-control select2" id="">
										<option value=""> Pilih Sekolah </option>
										<?php foreach($sekolahs AS $sekolah): ?>
											<option value="<?= $sekolah->npsn ?>"><?= $sekolah->nama ?> </option>
										<?php endforeach; ?>
									</select>
								</div>
								<div class="col-md-4">
									<button class="btn btn-block btn-primary"> Tampilkan Pengumuman  </button>
								</div>
							</div>
						</form>
					</div>
				<?php else: ?>
					<em class="text-primary h6">Pengumuman akan terbuka pada tanggal <b><?php echo \Carbon\Carbon::parse(configs()->pengumuman->start)->locale('id')->translatedFormat('j F Y') ?></b></em>
				<?php endif; ?>
			</div>
		</div>
		<?php
		$npsn = $this->input->get('npsn');
		if(!empty($npsn) && date('Y-m-d') >= configs()->pengumuman->start) {
			?>
			<div class="iq-card iq-card-block iq-card-stretch iq-card-height">
				<div class="iq-card-body">
					<div class="iq-advance-course ">
						<div class="table-responsive">
							<table class="table table-hover" id="table">
								<thead class="text-center iq-bg-primary">
									<tr>
										<th style="width:2%">No.</th>
										<th>Nama </th>
										<th>Tempat / Tanggal Lahir </th>
										<th>Sekolah Tujuan </th>
										<th>Jalur</th>
										<th>Status </th>
										<th>Keterangan  </th>
									</tr>
								</thead>
								<tbody>

								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<script type="text/javascript">

			var save_method; 
			var table;


			$(document).ready(function () {

				table = $('#table').DataTable({
					"oLanguage": {
						"oPaginate": {
							"sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
							"sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
						},
						"sSearch": '',
						"sSearchPlaceholder": "Cari Nama Anda Disini",
					},
					dom: 'Bfrtip',
					"processing": true, 
					"serverSide": true, 
					"order": [], 
					"ajax": {
						"url": "<?php echo site_url('siswa/pengumuman/ajax_list?npsn='.$npsn.' ')  ?>",
						"type": "POST"
					},

					"columnDefs": [
						{
							"targets": [-1],
							"orderable": false,
						},
					],

				});
				$("input").change(function () {
					$(this).parent().parent().removeClass('has-error');
					$(this).next().empty();
				});
			});

			function reload_table() {
				table.ajax.reload(null, false);
			}


			function delete_(id) {
				if (confirm('Anda yakin ingin menghapus data ?')) {
					$.ajax({
						url: "<?php echo site_url('siswa/daftar/ajax_delete')?>/" + id,
						type: "POST",
						dataType: "JSON",
						success: function (data) {
							reload_table();
							toastr.error('Berhasil Menghapus Data');

						},
						error: function (jqXHR, textStatus, errorThrown) {
							alert('Error deleting data');
						}
					});

				}
			}
			</script>
		<?php } ?>
	</div>
</div>
