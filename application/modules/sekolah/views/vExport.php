<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Kuota Pendaftar.xls");
?>
<style>
    tr th {
        border: 1px solid black;
    }

    table tr td {
        border: 1px solid black;
    }
</style>
<h2>Macca SPMB - Kabupaten Sinjai</h2>

<table>
    <tr>
        <td><b>TANGGAL DOWNLOAD</b></td>
        <td><b><?= tgl_indo(date('Y-m-d')) ?> Pukul : <?= date('H:i:s'); ?></b></td>
    </tr>
    <?php if (!empty($kecamatan)): ?>
    <tr>
        <td><b>KECAMATAN</b></td>
        <td><b><?= $kecamatan ?></b></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td><b>STATUS DTKS</b></td>
        <td><b>
       <?php if ($this->input->get('sts_dtks') == "1") {
							echo "Data Terdaftar di DTKS";
						} elseif ($this->input->get('sts_dtks') == "0") {
							echo "Data Tidak Terdaftar di DTKS";
						} elseif ($this->input->get('sts_dtks') == "3") {
							echo "Proses Verifikasi Data DTKS";
						} elseif ($this->input->get('sts_dtks') == "4") {
							echo "Data Tidak Valid";
						}  elseif ($this->input->get('sts_dtks') == "2") {
							echo "Data Terdaftar di DTKS dan Memiliki SKTM";
						}  elseif ($this->input->get('sts_dtks') == "5") {
							echo "Pemadanan Data";
						}  else {
							echo "Data Campuran";
						}
						?> 
        </b></td>
    </tr>
</table>
<br>
<div class="table-responsive">
    <table class="table table-hover" id="table" style="border:1px solid black;">
        <tr>
            <th style="border:1px solid black;">No.</th>
            <th style="border:1px solid black;">NPSN</th>
            <th style="border:1px solid black;">Nama Sekolah</th>
            <th style="border:1px solid black;">Kecamatan</th>
            <th style="border:1px solid black;">Desa/Kelurahan</th>
            <th style="border:1px solid black;">Kuota</th>
            <th style="border:1px solid black;">Pendaftar</th>
            <th style="border:1px solid black;">Jumlah Lulusan</th>
        </tr>

        <?php
        $no = 1;
        $total_kuota = 0;
        $total_pendaftar = 0;
        foreach ($sekolah->result() as $row) {
            $kuota = $row->kuota ?? 0;
            $pendaftar = $row->pendaftar ?? 0;
            $total_kuota += $kuota;
            $total_pendaftar += $pendaftar;
        ?>
            <tr>
                <td style="border:1px solid black;"><?= $no++ ?></td>
                <td style="border:1px solid black;"><?= $row->npsn ?></td>
                <td style="border:1px solid black;"><?= $row->nama ?></td>
                <td style="border:1px solid black;"><?= strtoupper($row->kec) ?></td>
                <td style="border:1px solid black;"><?= strtoupper($row->kel) ?></td>
                <td style="border:1px solid black;"><?= $kuota ?></td>
                <td style="border:1px solid black;"><?= $pendaftar ?></td>
                <td style="border:1px solid black;"><?= $row->lulusan ?></td>
        <?php } ?>
        <tr>
            <td colspan="5" style="border:1px solid black;text-align:right;"><strong>Total</strong></td>
            <td style="border:1px solid black;"><strong><?= $total_kuota ?></strong></td>
            <td style="border:1px solid black;"><strong><?= $total_pendaftar ?></strong></td>
        </tr>
    </table>
</div>