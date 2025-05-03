<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>School Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .profile-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
            margin-bottom: 25px;
        }
        
        .profile-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        
        .school-logo {
            padding: 20px;
            text-align: center;
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
        }
        
        .school-info {
            padding: 25px;
        }
        
        .btn-action {
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 8px;
            padding: 8px 15px;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .btn-action i {
            margin-right: 8px;
            font-size: 1.1rem;
        }
        
        .btn-action:hover {
            transform: translateX(5px);
        }
        
        .stat-card {
            border: none;
            border-radius: 12px;
            padding: 18px;
            height: 100%;
            transition: transform 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            color: white;
            margin-bottom: 15px;
        }
        
        .stat-primary {
            background: linear-gradient(45deg, #4a89dc, #5d9cec);
        }
        
        .stat-success {
            background: linear-gradient(45deg, #37bc9b, #48cfad);
        }
        
        .stat-info {
            background: linear-gradient(45deg, #3bafda, #4fc1e9);
        }
        
        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 8px;
        }
        
        .stat-label {
            color: #6c757d;
            font-size: 1rem;
            font-weight: 500;
        }
        
        .area-card {
            border: none;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }
        
        .area-title {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: #333;
            border-bottom: 2px solid #eee;
            padding-bottom: 10px;
        }
        
        .area-list {
            padding-left: 20px;
        }
        
        .area-list li {
            padding: 8px 0;
        }
        
        .school-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
        }
        
        .school-npsn {
            color: #6c757d;
            font-size: 1.1rem;
            margin-bottom: 15px;
        }
        
        .contact-info {
            margin-bottom: 20px;
        }
        
        .contact-info i {
            width: 25px;
            color: #4a89dc;
        }
        
        .contact-link {
            color: #4a89dc;
            text-decoration: none;
        }
        
        .contact-link:hover {
            text-decoration: underline;
        }
        
        .progress {
            height: 10px;
            border-radius: 10px;
            margin-top: 10px;
        }
        
        .progress-bar-primary {
            background-color: #4a89dc;
        }
        
        .progress-bar-success {
            background-color: #37bc9b;
        }
        
        .progress-bar-info {
            background-color: #3bafda;
        }
        
        .progress-text {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="profile-card">
                    <div class="school-logo">
                        <img src="<?= base_url() ?>assets/images/<?= $get->logo ?>" alt="School Logo" class="img-fluid" style="max-width: 180px;">
                    </div>
                    
                    <div class="px-4 py-3">
                        <?php if (level_user() == "sekolah") { ?>
                            <a href="#" data-toggle="modal" data-target="#edit" class="btn btn-action btn-warning w-100">
                                <i class='bx bxs-edit'></i> Edit Profil
                            </a>
                            
                            <?php
                            $tanggal_hari_ini = date('Y-m-d');
                            $tanggal_mulai    = configs()->kuota->start;
                            $is_disabled      = $tanggal_hari_ini > configs()->kuota->end;
                            ?>
                            
                            <a href="#" class="btn btn-action btn-success w-100 <?= $is_disabled ? 'disabled' : '' ?>"
                               <?= $is_disabled ? 'onclick="return false;"' : 'data-toggle="modal" data-target="#kuota"' ?>>
                                <i class='bx bxs-edit-alt'></i> Edit Kuota Diterima
                            </a>
                            
                            <a href="#" data-toggle="modal" data-target="#ubahPassword" class="btn btn-action btn-primary w-100">
                                <i class='bx bxs-lock-alt'></i> Ubah Password
                            </a>
                        <?php } ?>
                        
                        <?php if (level_user() == "admin") { ?>
                            <a href="#" data-toggle="modal" data-target="#edit" class="btn btn-action btn-warning w-100">
                                <i class='bx bxs-edit'></i> Edit Profil
                            </a>
                            
                            <?php
                            $tanggal_hari_ini = date('Y-m-d');
                            $tanggal_mulai    = configs()->kuota->start;
                            $is_disabled      = $tanggal_hari_ini > configs()->kuota->end;
                            ?>
                            
                            <a href="#" class="btn btn-action btn-success w-100 <?= $is_disabled ? 'disabled' : '' ?>"
                               <?= $is_disabled ? 'onclick="return false;"' : 'data-toggle="modal" data-target="#kuota"' ?>>
                                <i class='bx bxs-edit-alt'></i> Edit Kuota Diterima
                            </a>
                            
                            <a href="#" data-toggle="modal" data-target="#reset" class="btn btn-action btn-outline-primary w-100">
                                <i class='bx bx-refresh'></i> Reset Password
                            </a>
                            
                            <div class="modal fade" id="reset" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reset Password</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Anda yakin ingin melakukan reset password?</p>
                                            <hr>
                                            Jika klik reset maka password akun pada sekolah <b><?= $get->nama ?></b> akan berubah menjadi nomor NPSN nya <b class="text-primary">(<?= $get->npsn ?>)</b>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="<?= base_url() ?>sekolah/resetpassword/<?= $get->id_sekolah ?>/<?= $get->npsn ?>" class="btn btn-primary">Reset Sekarang</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        
                        <?php if (level_user() == "superadmin") { ?>
                            <a href="#" data-toggle="modal" data-target="#edit" class="btn btn-action btn-warning w-100">
                                <i class='bx bxs-edit'></i> Edit Profil
                            </a>
                            
                            <a href="#" data-toggle="modal" data-target="#kuota" class="btn btn-action btn-success w-100">
                                <i class='bx bxs-edit-alt'></i> Edit Kuota Diterima
                            </a>
                            
                            <a href="#" data-toggle="modal" data-target="#ubahPassword" class="btn btn-action btn-primary w-100">
                                <i class='bx bxs-lock-alt'></i> Ubah Password
                            </a>
                            
                            <a href="#" data-toggle="modal" data-target="#reset" class="btn btn-action btn-outline-primary w-100">
                                <i class='bx bx-refresh'></i> Reset Password
                            </a>
                            
                            <a href="#" data-toggle="modal" data-target="#hapus" class="btn btn-action btn-danger w-100">
                                <i class='bx bx-trash'></i> Hapus Sekolah
                            </a>
                            
                            <div class="modal fade" id="hapus" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Hapus Sekolah</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Anda yakin ingin menghapus data sekolah?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="<?= base_url() ?>sekolah/delete/<?= $get->id_sekolah ?>" class="btn btn-danger">Hapus Sekolah</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="modal fade" id="reset" tabindex="-1" role="dialog">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Reset Password</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Anda yakin ingin melakukan reset password?</p>
                                            <hr>
                                            Jika klik reset maka password akun pada sekolah <b><?= $get->nama ?></b> akan berubah menjadi nomor NPSN nya <b class="text-primary">(<?= $get->npsn ?>)</b>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="<?= base_url() ?>sekolah/resetpassword/<?= $get->id_sekolah ?>/<?= $get->npsn ?>" class="btn btn-primary">Reset Sekarang</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-8">
                <div class="profile-card mb-4">
                    <div class="school-info">
                        <div class="school-npsn"><?= $get->npsn ?></div>
                        <h2 class="school-name"><?= $get->nama ?></h2>
                        
                        <div class="contact-info">
                            <p>
                                <i class='bx bxs-map'></i> <?= capital($get->alamat) ?>, 
                                Kelurahan <?= capital($get->kel) ?>, Kecamatan <?= capital($get->nama_kec) ?>, 
                                <?= capital($get->nama_kab) ?>
                            </p>
                            <p>
                                <i class='bx bxs-envelope'></i> 
                                <a href="mailto:<?= $get->email ?>" class="contact-link"><?= $get->email ?></a>
                            </p>
                            <p>
                                <i class='bx bxs-phone'></i> 
                                <a href="tel:<?= $get->no_hp ?>" class="contact-link"><?= $get->no_hp ?></a>
                            </p>
                            <p>
                                <i class='bx bxs-phone'></i> 
                                <a href="tel:<?= $get->no_hp_kepsek ?>" class="contact-link"><?= $get->no_hp_kepsek ?></a> (Kepala Sekolah)
                            </p>
                            <p>
                                <i class='bx bxs-badge-check'></i> <?= $get->status ?>
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon stat-primary">
                                <i class='bx bxs-graduation'></i>
                            </div>
                            <div class="stat-label">Kuota Penerimaan</div>
                            <div class="stat-value"><?= $get->kuota ?></div>
                            <div class="text-muted">Orang</div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-primary" role="progressbar" 
                                     style="width: <?= ($get->kuota > 0) ? (100) : 0 ?>%" 
                                     aria-valuenow="<?= $get->kuota ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon stat-success">
                                <i class='bx bxs-user-plus'></i>
                            </div>
                            <div class="stat-label">Telah Mendaftar</div>
                            <div class="stat-value"><?= jumlahPendaftar($get->npsn) ?></div>
                            <div class="text-muted">
                                Orang
                                <?php if (level_user() == "admin" || level_user() == "superadmin") { ?>
                                    <a href="<?= base_url() ?>sekolah/laporan?jalur=all&npsn=<?= $get->npsn ?>" class="float-end text-success">
                                        <i class='bx bx-user-check'></i> Lihat
                                    </a>
                                <?php } ?>
                            </div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-success" role="progressbar" 
                                     style="width: <?= ($get->kuota > 0) ? (jumlahPendaftar($get->npsn) / $get->kuota * 100) : 0 ?>%" 
                                     aria-valuenow="<?= jumlahPendaftar($get->npsn) ?>" aria-valuemin="0" aria-valuemax="<?= $get->kuota ?>"></div>
                            </div>
                            <div class="progress-text">
                                <span><?= jumlahPendaftar($get->npsn) ?> Pendaftar</span>
                                <span>Kuota: <?= $get->kuota ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="stat-card">
                            <div class="stat-icon stat-info">
                                <i class='bx bxs-user-check'></i>
                            </div>
                            <div class="stat-label">Sisa Kuota</div>
                            <div class="stat-value"><?= $get->kuota - jumlahPendaftar($get->npsn) ?></div>
                            <div class="text-muted">Orang</div>
                            <div class="progress">
                                <div class="progress-bar progress-bar-info" role="progressbar" 
                                     style="width: <?= ($get->kuota > 0) ? (($get->kuota - jumlahPendaftar($get->npsn)) / $get->kuota * 100) : 0 ?>%" 
                                     aria-valuenow="<?= $get->kuota - jumlahPendaftar($get->npsn) ?>" aria-valuemin="0" aria-valuemax="<?= $get->kuota ?>"></div>
                            </div>
                            <div class="progress-text">
                                <span><?= $get->kuota - jumlahPendaftar($get->npsn) ?> Tersisa</span>
                                <span><?= round((($get->kuota - jumlahPendaftar($get->npsn)) / $get->kuota * 100), 1) ?>%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="area-card mt-4">
                    <h3 class="area-title">
                        <i class='bx bxs-map-pin me-2'></i>Area Zonasi
                    </h3>
                    <ol class="area-list">
                        <?php
                        $this->load->model('zonasi_model', 'zonasi');
                        $areaZonasis = $this->zonasi->get_daerah_sekolah($get->npsn);
                        foreach ($areaZonasis as $value) {
                            $dkec = $this->db->query("select * from kecamatan where id_kec='$value->kecamatan' limit 1")->row();
                        ?>
                            <li><?= $value->daerah_zonasi . ' - ' . strtoupper($dkec->nama_kec) ?></li>
                        <?php
                        }
                        ?>
                    </ol>

                    <?php if ($this->session->userdata('isLogin') != TRUE) { ?>
                        <div class="mt-4">
                            <a href="<?= base_url() ?>sekolah?level=<?= $get->id ?>" class="btn btn-warning">
                                Cari Sekolah Lain <i class='bx bx-right-arrow-circle'></i>
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Update Password -->
    <form action="<?= base_url() ?>sekolah/updatePassword" method="POST">
        <input type="hidden" name="npsn" value="<?= $get->npsn ?>">
        <div class="modal fade" id="ubahPassword" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ubah Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>Password Lama</label>
                            <input type="password" class="form-control" name="pwdLama" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label>Password Baru</label>
                            <input type="password" class="form-control" name="pwdBaru" autocomplete="off">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-refresh'></i> Update Password
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal Edit Sekolah -->
    <form action="<?= base_url() ?>sekolah/update" method="POST">
        <input type="hidden" name="id" value="<?= $get->id_sekolah ?>">
        <div class="modal fade" id="edit" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Profil Sekolah</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>NPSN</label>
                                    <input type="text" value="<?= $get->npsn ?>" class="form-control" name="npsn" autocomplete="off" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Nama Sekolah</label>
                                    <input type="text" value="<?= $get->nama ?>" class="form-control" name="nama" autocomplete="off" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Alamat</label>
                                    <input type="text" value="<?= $get->alamat ?>" class="form-control" name="alamat" autocomplete="off" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Kelurahan</label>
                                    <input type="text" class="form-control" name="kel" autocomplete="off" value="<?= $get->kel ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Kecamatan</label>
                                    <select name="kec" class="form-control select2" style="width:100%" required>
                                        <option value="">Pilih</option>
                                        <?php foreach ($kecamatans as $value): $selected = ($value->id_kec == $get->kec) ? "selected" : ""; ?>
                                            <option value="<?= $value->id_kec ?>" <?= $selected ?>><?= $value->nama_kec ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Status</label>
                                    <select name="status" class="form-control" required>
                                        <option value="">Pilih</option>
                                        <option value="NEGERI" <?php echo ($get->status == "NEGERI") ? "selected" : ""; ?>>NEGERI</option>
                                        <option value="SWASTA" <?php echo ($get->status == "SWASTA") ? "selected" : ""; ?>>SWASTA</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Email Sekolah</label>
                                    <input type="email" class="form-control" name="email" autocomplete="off" value="<?= $get->email ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Nomor Handphone Kepala Sekolah</label>
                                    <input type="text" class="form-control" name="no_hp_kepsek" autocomplete="off" value="<?= $get->no_hp_kepsek ?>">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Nomor Handphone Operator</label>
                                    <input type="text" class="form-control" name="no_hp" autocomplete="off" value="<?= $get->no_hp ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-refresh'></i> Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal Update Kuota -->
    <form action="<?= base_url() ?>sekolah/updateKuota" method="POST">
        <input type="hidden" name="npsn" value="<?= $get->npsn ?>">
        <div class="modal fade" id="kuota" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Kuota</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Jumlah Kuota</label>
                            <input type="number" class="form-control" name="kuota" autocomplete="off" value="<?= $get->kuota; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class='bx bx-refresh'></i> Update Kuota
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
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
</body>
</html>