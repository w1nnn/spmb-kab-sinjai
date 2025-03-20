<div class="row">
    <div class="col-sm-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="iq-advance-course d-flex align-items-center justify-content-between">
                    <input type="text" id="search_text" class="form-control" placeholder="Cari Sekolah atau Kecamatan Disini... " autofocus>
                    <div class="pl-4">
                        <a href="<?= base_url() ?>sekolah/export?level=<?= $level ?>" target="blank" class="btn btn-success btn-sm"><i class="ri-file-excel-2-fill"></i><span style="font-size: 12px;">Export Kuota Pendaftar</span></a>
                    </div>
                    <?php if ($this->session->userdata('level') === 'superadmin') { ?>
                        <div class="pl-4">
                            <a href="<?= base_url() ?>sekolah/ukuran?level=<?= $level ?>" target="blank" class="btn btn-success btn-sm"><i class="ri-file-excel-2-fill"></i><span style="font-size: 12px;">Export Ukuran Baju</span></a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="result" class="row"></div>


<script>
    $(document).ready(function() {
        load_data();

        function load_data(query) {
            $.ajax({
                url: "<?php echo base_url(); ?>sekolah/cari",
                method: "POST",
                data: {
                    query: query,
                    level: '<?= $level ?>'
                },
                success: function(data) {
                    $('#result').html(data);
                }
            })
        }
        var st;
        $('#search_text').keyup(function() {
            $('#result').html('<em class="col-12 h6 text-center text-primary">Memuat data ...</em>');
            clearTimeout(st);
            const search = $(this).val();
            st = setTimeout(() => {
                if (search !== '') {
                    load_data(search);
                } else {
                    load_data();
                }
            }, 300);
        });
    });
</script>