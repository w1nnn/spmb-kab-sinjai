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
    <div class="alert mt-3 alert-warning text-dark" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <i class="ri-alert-line" style="margin-right: 5px;"></i> Proses ini akan mengubah status siswa yang telah mendaftar dengan NIK sedang dalam proses pemadanan data.
    </div>
    <label for="range1" class="form-label mt-1">Tanggal Mulai</label>
    <input type="date" name="range1" id="range1" class="form-control" required>

    <label for="range2" class="form-label mt-3">Tanggal Akhir</label>
    <input type="date" name="range2" id="range2" class="form-control" required>
    <p class="mt-3">
  <i class="ri-information-line" style="margin-right: 5px;"></i>
  Pastikan rentang waktu yang Anda pilih mencakup tanggal pendaftaran siswa yang ingin diupdate 
  (<strong>Input tanggal yang sama jika tidak memiliki rentang waktu khusus</strong>).
</p>

    <button type="submit" name="set" class="btn mt-3" style="width:100%; background-color:#343a40; color:#fefae0; border:none;">
      Update Status Pemadanan Data Siswa
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
                            <button type="button" class="btn" id="syncButton" onclick="synchronize_data()" style="background-color:#606c38; color:#fefae0; border:none;">
                                <i class="ri-menu-search-line" id="syncIcon"></i> 
                                <span id="syncText">Sinkronisasi Data</span>
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
<script>
    window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 4000);
</script>
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

    function synchronize_data() {
        Swal.fire({
            title: 'Konfirmasi Sinkronisasi',
            text: 'Anda yakin ingin melakukan sinkronisasi data DTKS?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#606c38',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Sinkronkan!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Ubah tampilan tombol menjadi loading
                const syncButton = document.getElementById('syncButton');
                const syncIcon = document.getElementById('syncIcon');
                const syncText = document.getElementById('syncText');
                
                // Disable tombol dan ubah tampilan
                syncButton.disabled = true;
                syncButton.style.opacity = '0.7';
                syncIcon.className = 'ri-loader-4-line';
                syncIcon.style.animation = 'spin 1s linear infinite';
                syncText.textContent = 'Sedang Sinkronisasi...';
                
                // Tambahkan CSS untuk animasi spinner
                if (!document.getElementById('spinnerStyle')) {
                    const style = document.createElement('style');
                    style.id = 'spinnerStyle';
                    style.textContent = `
                        @keyframes spin {
                            0% { transform: rotate(0deg); }
                            100% { transform: rotate(360deg); }
                        }
                    `;
                    document.head.appendChild(style);
                }

                // Lakukan request Ajax untuk sinkronisasi
                $.ajax({
                    url: "<?php echo site_url('siswa/daftar/bulk_update_dtks_status') ?>",
                    type: "POST",
                    dataType: "JSON",
                    timeout: 300000, // 5 menit timeout
                    success: function(data) {
                        // Reset tampilan tombol
                        resetSyncButton();
                        
                        // Reload table untuk menampilkan data terbaru
                        reload_table();
                        
                        // Cek status response
                        if (data.status === 'success') {
                            // Tampilkan notifikasi sukses
                            Swal.fire({
                                title: 'Berhasil!',
                                text: data.message || 'Sinkronisasi data berhasil dilakukan.',
                                icon: 'success',
                                timer: 4000,
                                showConfirmButton: false
                            });
                        } else {
                            // Tampilkan notifikasi error dari server
                            Swal.fire({
                                title: 'Error!',
                                text: data.message || 'Terjadi kesalahan saat sinkronisasi.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Reset tampilan tombol
                        resetSyncButton();
                        
                        let errorMessage = 'Gagal melakukan sinkronisasi data.';
                        
                        if (textStatus === 'timeout') {
                            errorMessage = 'Proses sinkronisasi timeout. Silakan coba lagi.';
                        } else if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMessage = jqXHR.responseJSON.message;
                        } else if (jqXHR.responseText) {
                            try {
                                const response = JSON.parse(jqXHR.responseText);
                                errorMessage = response.message || errorMessage;
                            } catch (e) {
                                // Jika tidak bisa parse JSON, gunakan error message default
                                console.log('Response tidak valid JSON:', jqXHR.responseText);
                            }
                        }
                        
                        Swal.fire({
                            title: 'Error!',
                            text: errorMessage,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }

    function resetSyncButton() {
        const syncButton = document.getElementById('syncButton');
        const syncIcon = document.getElementById('syncIcon');
        const syncText = document.getElementById('syncText');
        
        // Reset tombol ke kondisi normal
        syncButton.disabled = false;
        syncButton.style.opacity = '1';
        syncIcon.className = 'ri-menu-search-line';
        syncIcon.style.animation = '';
        syncText.textContent = 'Sinkronisasi Data';
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