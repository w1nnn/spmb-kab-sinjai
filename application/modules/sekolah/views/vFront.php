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
                        <select name="kec" id="kecamatan_select" class="form-control select2" style="width:100%" required>
                            <option value="">Pilih</option>
                            <?php foreach ($kecamatans as $value): $selected = ($value->id_kec == $get->kec) ? "selected" : ""; ?>
                                <option value="<?= $value->id_kec ?>" <?= $selected ?>><?= $value->nama_kec ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <!-- Desa/Kelurahan -->
                    <div class="col-md-4 mb-2">
                         <label for=""> Desa / Dusun / Kelurahan <span class="text-danger">*</span>
                        </label>
                       <select name="dusun" class="form-control select2" id="zonasi" required data-tags="true" style="width:100%"> 
                        <option value="<?= $get->dusun ?>"><?= $get->dusun ?></option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label for="sts_dtks">Status DTKS</label>
                        <select id="sts_dtks" name="sts_dtks" class="form-control">
                            <option value="">Semua Pendaftar</option>
                            <option value="1">Terdaftar DTKS</option>
                            <option value="0">Tidak Terdaftar DTKS</option>
                            <option value="3">Proses Verivikasi DTKS</option>
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
        $('#zonasi').select2({
		    tags: true,
            placeholder: 'Pilih',
            allowClear: true
        });
    });
    </script>
 <script>
   $(document).ready(function() {  
    $("#kecamatan_select").change(function() {
        const kecamatanValue = $('#kecamatan_select').val();

        // Reset dusun select ketika kecamatan berubah
        if (kecamatanValue === '') {
            // Jika tidak ada kecamatan dipilih, reset ke nilai default
            $("#zonasi").empty().append('<option value="<?= $get->dusun ?>"><?= $get->dusun ?></option>');
            return;
        }

        $.ajax({
            type: "POST",
            url: "<?php echo base_url("sekolah/zonasi/getDaerahKecamatan"); ?>",
            data: {
                kecamatan: kecamatanValue,
            },
            dataType: "JSON",
            beforeSend: function(e) {
                if (e && e.overrideMimeType) {
                    e.overrideMimeType("application/json;charset=UTF-8");
                }
                // Tampilkan loading atau disable select
                $("#zonasi").prop('disabled', true);
            },
            success: function(response) {
                // RESET/CLEAR semua option terlebih dahulu
                $("#zonasi").empty();
                
                // Tambahkan option default/placeholder
                $("#zonasi").append('<option value="">Pilih Dusun</option>');
                
                // Parse response dan tambahkan option baru
                const tempContainer = document.createElement('div');
                tempContainer.innerHTML = "<select>" + response.list_daerah + "</select>";
                const options = tempContainer.querySelectorAll('option');

                options.forEach(option => {
                    const name = option.textContent.trim();
                    const value = option.value || name; // gunakan value jika ada, jika tidak gunakan name
                    if (name !== "") {
                        $("#zonasi").append(`<option value="${value}">${name}</option>`);
                    }
                });

                // Re-enable select dan trigger change untuk select2
                $("#zonasi").prop('disabled', false).trigger('change');
            },
            error: function(xhr, ajaxOptions, thrownError) {
                alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                // Re-enable select jika terjadi error
                $("#zonasi").prop('disabled', false);
            }
        });
    });
});
    </script>
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
            const kecamatan = $('#kecamatan_select option:selected').text();
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
   // Event handler untuk pencarian berdasarkan dusun
$('#zonasi').change(function() {
    const dusunValue = $(this).val(); // Gunakan val() untuk mendapatkan value
    const dusunText = $('#zonasi option:selected').text();
    const kecamatan = $('#kecamatan_select option:selected').text();
    console.log('Dusun Value:', dusunValue);
    console.log('Dusun Text:', dusunText);
    console.log('Kecamatan:', kecamatan);
    
    // Hanya lakukan request jika ada value yang dipilih dan bukan placeholder
    if (dusunValue && dusunValue !== '' && dusunText !== 'Pilih Dusun' && dusunText !== 'Pilih') {
        $("#loading_indicator").show();
        $('#result').html('');
        
        $.ajax({
            url: "<?php echo base_url(); ?>sekolah/cari_dusun",
            method: "POST",
            data: {
                dusun: dusunText, 
                level: '<?= $level ?>',
                kecamatan: kecamatan // Sertakan kecamatan jika diperlukan
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
        
        // Reset pilihan lain
        $('#search_text').val('');
        $('#kecamatan_select').val('');
    } else {
        // Jika tidak ada pilihan atau pilihan kosong, load data default
        if (dusunValue === '' || !dusunValue) {
            load_data();
        }
    }
});
    

   // Script JavaScript yang sudah diperbaiki untuk mengirim parameter dusun pada export
$('#export_ukuran').click(function() {
    var kecamatan = $('#kecamatan_select option:selected').text();
    var dusun = $('#zonasi option:selected').text();
    var status_dtks = $('select[name="sts_dtks"]').val();
    var url = '<?= base_url() ?>sekolah/ukuran?level=<?= $level ?>';

    // Tambahkan parameter kecamatan jika ada
    if (kecamatan && kecamatan !== 'Pilih') {
        url += '&kecamatan=' + encodeURIComponent(kecamatan);
    }

    // Tambahkan parameter dusun jika ada dan bukan placeholder
    if (dusun && dusun !== 'Pilih Dusun' && dusun !== 'Pilih' && dusun !== '<?= $get->dusun ?>') {
        url += '&dusun=' + encodeURIComponent(dusun);
    }
    
    // Tambahkan parameter status DTKS jika ada
    if (status_dtks) {
        url += '&sts_dtks=' + encodeURIComponent(status_dtks);
    }

    console.log('Export Ukuran URL:', url); // Untuk debugging
    window.open(url, '_blank');
});

$('#export_kuota').click(function() {
    var kecamatan = $('#kecamatan_select option:selected').text();
    var dusun = $('#zonasi option:selected').text();
    var status_dtks = $('select[name="sts_dtks"]').val();
    var url = '<?= base_url() ?>sekolah/export?level=<?= $level ?>';

    // Tambahkan parameter kecamatan jika ada
    if (kecamatan && kecamatan !== 'Pilih') {
        url += '&kecamatan=' + encodeURIComponent(kecamatan);
    }
    
    // Tambahkan parameter dusun jika ada dan bukan placeholder
    if (dusun && dusun !== 'Pilih Dusun' && dusun !== 'Pilih' && dusun !== '<?= $get->dusun ?>') {
        url += '&dusun=' + encodeURIComponent(dusun);
    }
    
    // Tambahkan parameter status DTKS jika ada
    if (status_dtks) {
        url += '&sts_dtks=' + encodeURIComponent(status_dtks);
    }

    console.log('Export Kuota URL:', url); // Untuk debugging
    window.open(url, '_blank');
});
</script>