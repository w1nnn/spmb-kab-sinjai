<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
<?php
    if(isset($_POST['set'])) {
        $range1 = $_POST['range1'];
        $range2 = $_POST['range2'];
        $start_date = $range1 . ' 00:00:00';
        $end_date = $range2 . ' 23:59:59';
        
        $sql = "UPDATE `tbl_siswa` SET `sts_dtks` = 5 WHERE `tgl_daftar` >= ? AND `tgl_daftar` <= ?";
        
        $query = $this->db->query($sql, array($start_date, $end_date));
        
        if($query) {
            redirect('dtks/manage?alert=success&message=Data DTKS berhasil diupdate');
        } else {
            redirect('dtks/manage?alert=error&message=Gagal mengupdate data DTKS');
        }
    }
?>
<div class="row">
    <div class="col-sm-12 iq-card iq-card-block iq-card-stretch iq-card-height">
    <form action="" method="POST">
  <div class="iq-card-body">
    <h5>Update Data Pemadanan</h5>
    <p class="text-orimary">
    <i class="ri-alert-line" style="margin-right: 5px;"></i>
    Proses ini akan mengubah status siswa yang NIK-nya sedang dalam proses pemadanan data.
    </p>
    <label for="range1" class="form-label mt-3">Tanggal Mulai</label>
    <input type="date" name="range1" id="range1" class="form-control" required>

    <label for="range2" class="form-label mt-3">Tanggal Akhir</label>
    <input type="date" name="range2" id="range2" class="form-control" value="<?= date('Y-m-d') ?>" required>

    <!-- <p class="mt-4">
      <input type="checkbox" required>
      Saya telah memperhatikan rentang waktu yang telah ditentukan.
    </p> -->

    <button type="submit" name="set" class="btn mt-3" style="width:100%; background-color:#343a40; color:#fefae0; border:none;">
      Update Data
    </button>
  </div>
</form>

</div>
</div>
<div class="row ">
    <div class="col-sm-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="iq-advance-course ">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Data DTKS</h5>

                        <div class="btn-group" role="group">
                            <a href="<?= base_url() ?>dtks/manage/add" class="btn" style="background-color:#274c77; color:#fefae0; border:none;"> 
                                <i class="ri-add-circle-line"></i> Tambah 
                            </a>
                            <button type="button" class="btn" onclick="reset_all_data()" style="background-color:#197278; color:#fefae0; border:none;"> 
                                <i class="ri-loop-left-line"></i> Reset Semua Data 
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover" id="table">
                            <thead class="text-center iq-bg-primary">
                                <tr>
                                    <th style="width:5%">No.</th>
                                    <th>NIK</th>
                                    <th>Status</th>
                                    <th style="width:20%">Aksi</th>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

<!-- Notifikasi Toast -->
<?php if ($this->input->get('alert')): ?>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });

            Toast.fire({
                icon: '<?= $this->input->get('alert') ?>',
                title: '<?= $this->input->get('message') ?>'
            });

            // Hapus parameter alert & message dari URL tanpa reload
            if (history.pushState) {
                const url = new URL(window.location);
                url.searchParams.delete('alert');
                url.searchParams.delete('message');
                window.history.replaceState({}, document.title, url.toString());
            }
        });
    </script>
<?php endif; ?>

<script type="text/javascript">
    var save_method; //for save method string
    var table;

    $(document).ready(function() {
        //datatables
        table = $('#table').DataTable({
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>'
                },
                "sSearch": '',
                "sSearchPlaceholder": "Cari NIK...",
            },
            dom: 'Bfrtip',
            "processing": true,
            "serverSide": true,
            "order": [],

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('dtks/manage/ajax_list') ?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [{
                "targets": [-1], //last column
                "orderable": false, //set not orderable
            }],
        });

        //set input/textarea/select event when change value, remove class error and remove text help block
        $("input").change(function() {
            $(this).parent().parent().removeClass('has-error');
            $(this).next().empty();
        });
    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax
    }

    function delete_(id) {
        Swal.fire({
            title: 'Konfirmasi Hapus',
            text: 'Anda yakin ingin menghapus data ini?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // ajax delete data to database
                $.ajax({
                    url: "<?php echo site_url('dtks/manage/ajax_delete') ?>/" + id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        //if success reload ajax table
                        reload_table();
                        
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus.',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus data.',
                            icon: 'error'
                        });
                    }
                });
            }
        });
    }

    function reset_all_data() {
        Swal.fire({
            title: 'Konfirmasi Reset Semua Data',
            text: 'Anda yakin ingin menghapus SEMUA data DTKS?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Reset Semua!',
            cancelButtonText: 'Batal',
            input: 'text',
            inputPlaceholder: 'Ketik "RESET" untuk konfirmasi',
            inputValidator: (value) => {
                if (value !== 'RESET') {
                    return 'Ketik "RESET" untuk melanjutkan!'
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Sedang Menghapus...',
                    text: 'Mohon tunggu, sedang menghapus semua data.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // ajax reset all data from database
                $.ajax({
                    url: "<?php echo site_url('dtks/manage/ajax_reset_all') ?>",
                    type: "POST",
                    dataType: "JSON",
                    success: function(data) {
                        //if success reload ajax table
                        reload_table();
                        
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Semua data berhasil dihapus dari tabel.',
                            icon: 'success',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal menghapus semua data. Silakan coba lagi.',
                            icon: 'error'
                        });
                    }
                });
                
            }
        });
    }
</script>