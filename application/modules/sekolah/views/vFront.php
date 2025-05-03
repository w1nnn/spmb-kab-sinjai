<div class="row">
    <div class="col-sm-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="row">
                    <!-- Kolom untuk pencarian berdasarkan nama/NPSN -->
                    <div class="col-md-4 mb-2">
                        <label for="search_text">Cari Sekolah</label>
                        <input type="text" id="search_text" class="form-control" placeholder="Nama sekolah atau NPSN..." autofocus>
                    </div>

                    <!-- Kolom untuk pilihan kecamatan -->
                    <?php if ($this->session->userdata('level') === 'superadmin') { ?>

                    <div class="col-md-4 mb-2">
                        <label for="kecamatan_select">Pilih Kecamatan</label>
                        <select id="kecamatan_select" class="form-control">
                            <option value="">-- Semua Kecamatan --</option>
                            <option value="Bulupoddo">Bulupoddo</option>
                            <option value="Pulau Sembilan">Pulau Sembilan</option>
                            <option value="Sinjai Barat">Sinjai Barat</option>
                            <option value="Sinjai Borong">Sinjai Borong</option>
                            <option value="Sinjai Selatan">Sinjai Selatan</option>
                            <option value="Sinjai Tengah">Sinjai Tengah</option>
                            <option value="Sinjai Timur">Sinjai Timur</option>
                            <option value="Sinjai Utara">Sinjai Utara</option>
                            <option value="Tellu Limpoe">Tellu Limpoe</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4 mb-2">
                        <label for="sts_dtks">Status DTKS</label>
                        <!-- Kolom untuk pilihan status DTKS -->
                        <select id="sts_dtks" name="sts_dtks" class="form-control">
                            <option value="">Semua Pendaftar</option>
                            <option value="1">Terdaftar DTKS</option>
                            <option value="0">Tidak Terdaftar DTKS</option>
                        </select>
					</div>
                    <?php } ?>

                    <!-- Kolom untuk tombol export -->
                    <div class="col-md-5 mb-2">
                        <?php if ($this->session->userdata('level') === 'superadmin') { ?>
                        <label>Export Data</label>
                        <div class="d-flex">
                            <a href="javascript:void(0)" id="export_kuota" class="btn btn-success btn-sm mr-2">
                                <i class="ri-file-excel-2-fill mr-1"></i>Kuota Pendaftar
                            </a>
                                <a href="javascript:void(0)" id="export_ukuran" class="btn btn-info btn-sm">
                                    <i class="ri-file-excel-2-fill mr-1"></i>Ukuran Baju
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Indikator Loading -->
<div id="loading_indicator" class="row mb-3" style="display:none;">
    <div class="col-12 text-center">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
        <p class="text-primary mt-2">Sedang memuat data...</p>
    </div>
</div>

<!-- Hasil Pencarian -->
<div id="result" class="row"></div>

<script>
    $(document).ready(function() {
        // Load data awal
        load_data();

        // Fungsi untuk mencari berdasarkan teks
        function load_data(query) {
            $("#loading_indicator").show();
            $.ajax({
                url: "<?php echo base_url(); ?>sekolah/cari",
                method: "POST",
                data: {
                    query: query,
                    level: '<?= $level ?>'
                },
                success: function(data) {
                    $('#result').html(data);
                    $("#loading_indicator").hide();
                },
                error: function() {
                    $('#result').html('<div class="col-12"><div class="alert alert-danger">Gagal memuat data. Silakan coba lagi.</div></div>');
                    $("#loading_indicator").hide();
                }
            });
        }

        // Fungsi untuk mencari berdasarkan kecamatan
        function load_data_by_kecamatan(kecamatan) {
            $("#loading_indicator").show();
            $.ajax({
                url: "<?php echo base_url(); ?>sekolah/cari_kecamatan",
                method: "POST",
                data: {
                    kecamatan: kecamatan,
                    level: '<?= $level ?>'
                },
                success: function(data) {
                    $('#result').html(data);
                    $("#loading_indicator").hide();
                },
                error: function() {
                    $('#result').html('<div class="col-12"><div class="alert alert-danger">Gagal memuat data. Silakan coba lagi.</div></div>');
                    $("#loading_indicator").hide();
                }
            });
        }

        // Event handler untuk pencarian berdasarkan teks
        var st;
        $('#search_text').keyup(function() {
            clearTimeout(st);
            const search = $(this).val();
            $("#loading_indicator").show();
            $('#result').html('');

            st = setTimeout(() => {
                if (search !== '') {
                    load_data(search);
                    $('#kecamatan_select').val(''); // Reset kecamatan select
                } else {
                    load_data();
                }
            }, 500);
        });

        // Event handler untuk pencarian berdasarkan kecamatan
        $('#kecamatan_select').change(function() {
            const kecamatan = $(this).val();
            $("#loading_indicator").show();
            $('#result').html('');

            if (kecamatan !== '') {
                load_data_by_kecamatan(kecamatan);
                $('#search_text').val('');
            } else {
                load_data();
            }
        });
    });

    $('#export_ukuran').click(function() {
    var kecamatan = $('#kecamatan_select').val();
    var status_dtks = $('select[name="sts_dtks"]').val();
    var url = '<?= base_url() ?>sekolah/ukuran?level=<?= $level ?>';

    if (kecamatan) {
        url += '&kecamatan=' + encodeURIComponent(kecamatan);
    }
    
    if (status_dtks) {
        url += '&sts_dtks=' + encodeURIComponent(status_dtks);
    }

    window.open(url, '_blank');
});

$('#export_kuota').click(function() {
    var kecamatan = $('#kecamatan_select').val();
    var status_dtks = $('select[name="sts_dtks"]').val();
    var url = '<?= base_url() ?>sekolah/export?level=<?= $level ?>';

    if (kecamatan) {
        url += '&kecamatan=' + encodeURIComponent(kecamatan);
    }
    
    if (status_dtks) {
        url += '&sts_dtks=' + encodeURIComponent(status_dtks);
    }

    window.open(url, '_blank');
});
</script>