<?php
// File: vLulusan.php
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5>Data Pendaftar Lulusan <?= isset($nama_sekolah) ? $nama_sekolah : 'Semua Sekolah' ?></h5>
                </div>
                <div class="pull-right">
                    <a href="<?= base_url() ?>sekolah/exlulusan?jalur=all&nama=<?= $nama_sekolah ?>" target="blank" class="btn btn-success btn-sm mt-4 mx-4 "> <i class="ri-file-excel-2-fill"></i> Export to Excel  </a>
                </div>
                <div class="card-body">
                    <?php if(empty($siswas)): ?>
                        <div class="alert alert-info">
                            <i class="fa fa-info-circle"></i> Tidak ada data lulusan yang ditemukan.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-striped" id="tabel-lulusan">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>No. Pendaftaran</th>
                                        <th>Nama Siswa</th>
                                        <th>JK</th>
                                        <th>Tempat, Tgl Lahir</th>
                                        <th>Asal Sekolah</th>
                                        <th>Sekolah Tujuan</th>
                                        <th>Tgl Daftar</th>
                                        <th>Kartu Pendaftaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $no = 1; foreach($siswas as $siswa): ?>
                                <?php
                                $sekolah = $this->db->get_where('tbl_sekolah', ['npsn' => $siswa->pilihan_sekolah_1])->row();
                                ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $siswa->no_pendaftaran ?></td>
                                    <td><?= $siswa->nama_siswa ?></td>
                                    <td><?= $siswa->jk ?></td>
                                    <td><?= $siswa->tempat_lahir ?>, <?= date('d-m-Y', strtotime($siswa->tgl_lahir)) ?></td>
                                    <td><?= $siswa->asal_sekolah ?></td>
                                    <td>
                                        <?= $sekolah ? $sekolah->nama : '-' ?>
                                    </td>
                                    <td><?= date('d-m-Y', strtotime($siswa->tgl_daftar)) ?></td>
                                    <td>
                                        <a href="<?= base_url('siswa/cetak/'.$siswa->id_siswa) ?>" class="btn btn-sm btn-warning" title="Cetak" target="_blank">
                                            <i class="fa fa-print"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                                </tbody>

                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('#tabel-lulusan').DataTable({
        responsive: true,
        "language": {
            "lengthMenu": "Tampilkan _MENU_ data per halaman",
            "zeroRecords": "Data tidak ditemukan",
            "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
            "infoEmpty": "Tidak ada data yang tersedia",
            "infoFiltered": "(difilter dari _MAX_ total data)",
            "search": "Cari:",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        }
    });
});
</script>