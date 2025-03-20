<style>
    .iq-card-body .relative-background p {
        color: grey;
    }
</style>
<div class="row ">
    <div class="col-sm-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="iq-advance-course d-flex align-items-center justify-content-between">
                    <div class="left-block">
                        <div class="d-flex align-items-center">
                            <img src="<?= base_url() ?>assets/images/page-img/29.png" class="img-fluid">
                            <div class=" ml-3">
                                <h4 class="">Selamat Datang di Sistem Penerimaan Peserta Didik Baru</h4>
                                <p class="mb-0">Dinas Pendidikan Kabupaten Sinjai .</p>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <input type="text" class="form-control" id="search_text" placeholder="Cari Sekolah Tujuan Disini... " autocomplete="off">
                <br>
                <div id="result" class="row"></div>
                <div class="row">
                    <div class="col">
                        <a href="<?= base_url() ?>siswa/register" class="btn-block btn-lg btn btn-warning"><i class="ri-user-add-line"></i> Buat Akun </a>
                    </div>
                    <div class="col">
                        <a href="<?= base_url() ?>siswa/login" class="btn-block btn btn-lg btn-primary"> Masuk <i class="ri-login-box-line"></i> </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-sm-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height">
            <div class="iq-card-body">
                <div class="iq-advance-course d-flex align-items-center justify-content-between">
                    <div class="col-md-8">
                        <div class="d-flex align-items-center">
                            <div class="ml-3">
                                <h5 class=""> Dokumen yang perlu dipersiapkan sebelum mendaftar </h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class=" align-items-center">
                            <center>
                                <a href="#" data-toggle="modal" data-target="#dok" class="btn btn-block btn-lg btn-outline-primary"> <i class="ri-search-2-line"></i> Cek Disini. </a>
                            </center>
                        </div>
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
                            <a href="<?= base_url() ?>jalur">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle iq-card-icon iq-bg-<?= $value->color ?> mr-3"><i class="<?= $value->icon ?>"></i></div>
                                    <div class="text-left">
                                        <h4 class="text-<?= $value->color ?>"> <?= substr($value->nama, 6, 100); ?></h4>
                                    </div>
                                </div>
                                <div class="background-image">
                                    <img src="<?= base_url() ?>assets/images/page-img/38.png" class="img-fluid" style="opacity: 0.5;">
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="col-md-6">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height ">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h5 class="card-title"> Alur Pendaftaran </h5>
                </div>
            </div>
            <div class="iq-card-body">
                <ul class="iq-timeline">
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Buat Akun </h6>
                        <div class="d-inline-block w-100">
                            <p>Buat akun , masukan nomor handphone orang tua dan password</p>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Pilih Tingkatan Sekolah Dan Jalur Pendaftaran </h6>
                        <div class="d-inline-block w-100">
                            <p>Pilih tingkatan sekolah dan pilih jalur sesuai minat anda , klik <a href="<?= base_url() ?>jalur"> disini </a> untuk penjelasan jalur pendaftaram </p>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Lengkapi Data Diri </h6>
                        <div class="d-inline-block w-100">
                            <p>Lengkapi data diri, pilih sekolah tujuan dan upload berkas persyaratan. </p>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Review dan Selesaikan data pendaftaran</h6>
                        <div class="d-inline-block w-100">
                            <p>Review data sebelum menyelesaikan pendaftaran</p>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Klik Selesai dan menunggu pengumuman dari sekolah </h6>
                        <div class="d-inline-block w-100">
                            <p>Setelah selesai melengkapi data pendaftaran, Calon siswa menunggu hasil pengumuman dari sekolah masing - masing </p>
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </div>


    <div class="col-md-6">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height  ">
            <div class="iq-card-header d-flex justify-content-between">
                <div class="iq-header-title">
                    <h4 class="card-title"> <i class="ri-calendar-line text-primary"></i> Jadwal Pelaksanaan </h5>
                </div>
            </div>
            <div class="iq-card-body">
                <ul class="iq-timeline">
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Pengumuman Pendaftaran Secara Terbuka </h6>
                        <div class="d-inline-block w-100">
                            <p> <b> <i class="ri-calendar-line text-primary"></i> 22 Juni 2024 </b> </p>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Pendaftaran Online dan Offline </h6>
                        <div class="d-inline-block w-100">
                            <p> <b> <i class="ri-calendar-line text-primary"></i> 15 Mei - 5 Juni 2024 </b> </p>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Seleksi Sesuai Jalur </h6>
                        <div class="d-inline-block w-100">
                            <p> <b> <i class="ri-calendar-line text-primary"></i> 13 Juni - 15 Juni 2024 </b> </p>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Penetapan Pengumuman Hasil Seleksi </h6>
                        <div class="d-inline-block w-100">
                            <p> <b> <i class="ri-calendar-line text-primary"></i> 13 Juni - 15 Juni 2024 </b> </p>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Masa Sanggah </h6>
                        <div class="d-inline-block w-100">
                            <p> <b> <i class="ri-calendar-line text-primary"></i> 16 Juni - 19 Juni 2024 </b> </p>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Pengumuman Penetapan Peserta Didik Baru </h6>
                        <div class="d-inline-block w-100">
                            <p> <b> <i class="ri-calendar-line text-primary"></i> 22 Juni 2024 </b> </p>
                        </div>
                    </li>
                    <li>
                        <div class="timeline-dots"></div>
                        <h6 class="float-left mb-1">Pendaftaran Ulang </h6>
                        <div class="d-inline-block w-100">
                            <p> <b> <i class="ri-calendar-line text-primary"></i> 22 Juni - 8 Juli 2024 </b> </p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="iq-card iq-card-block iq-card-stretch iq-card-height  ">

            <div class="iq-card-body">
                <div class="row">
                    <div class="col-md-4">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="ri-calendar-line text-primary"></i> Kontak </h5>
                        </div>

                        <ul style="padding-left:1px;">
                            <li> <i class="ri-map-pin-user-fill"></i> <?= $profil->alamat ?> </li>
                            <li> <i class="ri-phone-fill"></i> <?= $profil->hp ?> </li>
                            <li> <i class="ri-whatsapp-fill"></i> <?= $profil->wa ?> </li>
                        </ul>

                    </div>
                    <div class="col-md-4">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="ri-external-link-line  text-primary"></i> Link Terkait </h5>
                        </div>

                        <ul style="padding-left:1px;">
                            <li> <a href="#"> <i class="ri-external-link-line"></i> www.disdik.sinjaikab.go.id </a> </li>
                            <li> <a href="#"> <i class="ri-external-link-line"></i> www.sinjaikab.go.id </a> </li>
                            <li> <a href="#"> <i class="ri-external-link-line"></i> www.sulselprov.go.id </a> </li>
                            <li> <a href="#"> <i class="ri-external-link-line"></i> www.kemdikbud.go.id </a> </li>
                        </ul>

                    </div>
                    <div class="col-md-4">
                        <div class="iq-header-title">
                            <h4 class="card-title"> <i class="ri-external-link-line  text-primary"></i> Media Sosial </h5>
                        </div>
                        <ul style="padding-left:1px;">
                            <li> <i class="ri-facebook-box-fill"></i>&nbsp;Dinas Pendidikan</li>
                            <li> <i class="ri-instagram-fill"></i>&nbsp;disdik_sinjai</li>
                            <li> <i class="ri-youtube-fill"></i>&nbsp;Dinas Pendidikan Sinjai</li>
                            <li> <i class="ri-tiktok-fill"></i>&nbsp;Disdiksinjai</li>
                            <li> <i class="ri-edge-fill"></i>&nbsp;disdik.sinjaikab.co.id</li>
                            <li> <i class="ri-mail-send-fill"></i>&nbsp;dinaspendidikan.sinjaikab@gmail.com</li>
                        </ul>
                    </div>


                </div>
            </div>
        </div>
    </div>

</div>

<!-- Content Top Banner End -->

<script>
    $(document).ready(function() {

        function load_data(query) {
            $.ajax({
                url: "<?php echo base_url(); ?>sekolah/cari_all",
                method: "POST",
                data: {
                    query: query
                },
                success: function(data) {
                    $('#result').html(data);
                }
            })
        }

        $('#search_text').keyup(function() {
            const search = $(this).val();
            load_data(search);
        });
    });
</script>


<div class="modal fade " id="dok" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> Persyaratan Dokumen</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <h5>Dokumen Umum yang perlu dipersiapkan sebelum mendaftar : </h4>
                    <ol>
                        <li> Scan Kartu Keluarga </li>
                        <li> Scan Akta Kelahiran Calon Pendaftar </li>
                        <li> Foto 3x4 </li>
                        <li> Surat Keterangan Lulus, Khusus untuk pendaftar di TK digantikan dengan Surat Imunisasi </li>
                    </ol>

                    <h5>Dokumen khusus per jalur yang dipilih : </h4>
                        <ol>
                            <li> Jalur Afirmasi : <b> Kartu Indonesia Pintar (KIP) / Kartu Indonesia Sehat (KIS) </b> </li>
                            <li> Jalur Perpindahan Orang Tua : <b> Surat Keterangan Pindah Tugas Orang Tua </b> </li>
                            <li> Jalur Prestasi : <b> Bukti Prestasi (piagam / sertifikat / nilai raport ) </b> </li>
                        </ol>


            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-outline-primary"> Keluar </button>
            </div>
        </div>
    </div>
</div>