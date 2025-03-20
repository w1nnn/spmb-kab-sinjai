<div class="row ">
    <div class="col-sm-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <?php if (level_user() == 'sekolah'): ?>
                    <p><em><span class="text-danger">Catatan: Batas penginputan atau mengubah zonasi sekolah adalah mulai tanggal <?php echo '<b>' . \Carbon\Carbon::parse(configs()->zonasi->start)->locale('id')->translatedFormat('j F Y') . '</b> s.d. <b>' . \Carbon\Carbon::parse(configs()->zonasi->end)->locale('id')->translatedFormat('j F Y') . '</b>' ?></span></em></p>
                <?php endif; ?>
                <div class="iq-advance-course ">
                    <?php if (level_user() == 'superadmin' || level_user() == 'admin' || (level_user() == 'sekolah' && configs()->zonasi->start <= date('Y-m-d') && configs()->zonasi->end >= date('Y-m-d'))): ?>
                        <a href="<?= base_url() ?>sekolah/zonasi/add" class="btn btn-primary  pull-right btn-datatb " style="z-index: 1000"> <i class="ri-add-circle-line "></i> Tambah </a>
                    <?php endif; ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="table">
                            <thead class="text-center iq-bg-primary">
                                <tr>
                                    <th style="width:2%">No.</th>
                                    <th>Sekolah</th>
                                    <th>Daerah Domisili </th>
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
    let save_method; //for save method string
    let table;


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
                "url": "<?php echo site_url('sekolah/zonasi/ajax_list') ?>",
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
                url: "<?php echo site_url('sekolah/zonasi/ajax_delete') ?>/" + id,
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