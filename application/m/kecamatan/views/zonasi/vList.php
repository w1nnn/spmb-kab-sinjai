<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

<div class="row ">
    <div class="col-sm-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="iq-advance-course ">
                    <a href="<?= base_url() ?>kecamatan/zonasi/add" class="btn btn-primary  pull-right btn-datatb "> <i class="ri-add-circle-line "></i> Tambah </a>

                    <div class="table-responsive">
                        <table class="table table-hover" id="table">
                            <thead class="text-center iq-bg-primary">
                                <tr>
                                    <th style="width:2%">No.</th>
                                    <th>Kecamatan </th>
                                    <th>Daerah </th>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.all.min.js"></script>

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
                "url": "<?php echo site_url('kecamatan/zonasi/ajax_list') ?>",
                "type": "POST"
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


    });

    function reload_table() {
        table.ajax.reload(null, false); //reload datatable ajax
    }


    function delete_(id) {
        if (confirm('Anda yakin ingin menghapus data ?')) {
            // ajax delete data to database

            $.ajax({
                url: "<?php echo site_url('kecamatan/zonasi/ajax_delete') ?>/" + id,
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