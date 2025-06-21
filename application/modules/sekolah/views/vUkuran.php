<style>
    tr th {
        border: 1px solid black;
    }

    table tr td {
        border: 1px solid black;
    }
</style>
<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Ukuran Baju.xls");
?>
<h2> Macca SPMB - Kabupaten Sinjai </h2>

<table>
    <tr>
        <td><b> TANGGAL DOWNLOAD </b> </td>
        <td><b><?= tgl_indo(date('Y-m-d'))  ?> Pukul : <?= date('H:i:s'); ?> </b> </td>
    </tr>
    <tr>
        <td><b>STATUS DTKS</b></td>
        <td><b>
        <?php if ($this->input->get('sts_dtks') == "1") {
							echo "Data Terdaftar di DTKS";
						} elseif ($this->input->get('sts_dtks') == "0") {
							echo "Data Tidak Terdaftar di DTKS";
						} elseif ($this->input->get('sts_dtks') == "3") {
							echo "Proses Verivikasi DTKS";
						} elseif ($this->input->get('sts_dtks') == "4") {
							echo "Data Tidak Valid";
						} elseif ($this->input->get('sts_dtks') == "5") {
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
            <th rowspan="2" style="border:1px solid black;">No.</th>
            <th rowspan="2" style="border:1px solid black;">NPSN</th>
            <th rowspan="2" style="border:1px solid black;">Nama Sekolah</th>
            <th rowspan="2" style="border:1px solid black;">Kecamatan</th>
            <th rowspan="2" style="border:1px solid black;">Desa/Kelurahan</th>
            <th colspan="<?= count($ukuran) ?>" style="border:1px solid black;">Laki - laki</th>
            <th rowspan="2" style="border:1px solid black;">Jumlah</th>
            <th colspan="<?= count($ukuran) ?>" style="border:1px solid black;">Perempuan</th>
            <th rowspan="2" style="border:1px solid black;">Jumlah</th>
            <th rowspan="2" style="border:1px solid black;">Total</th>
        </tr>
        <tr>
            <?php foreach ($ukuran as $val) { ?>
                <th style="border:1px solid black;"><?= $val ?></th>
            <?php } ?>
            <?php foreach ($ukuran as $val) { ?>
                <th style="border:1px solid black;"><?= $val ?></th>
            <?php } ?>
        </tr>
        <?php
        $no = 1;
        foreach ($record as $row) {

        ?>
            <tr align="center">
                <td style="border:1px solid black;"><?= $no++ ?> </td>
                <td style="border:1px solid black;"><?= $row['npsn'] ?> </td>
                <td style="border:1px solid black;"><?= $row['nama'] ?> </td>
                <td style="border:1px solid black;"><?= strtoupper($row['kec']) ?> </td>
                <td style="border:1px solid black;"><?= strtoupper($row['kel']) ?> </td>
                <?php foreach ($row['ukuran_l'] as $val) { ?>
                    <td style="border:1px solid black;"><?= $val ?> </td>
                <?php } ?>
                <td style="border:1px solid black;"><?= array_sum($row['ukuran_l']) ?></td>
                <?php foreach ($row['ukuran_p'] as $val) { ?>
                    <td style="border:1px solid black;"><?= $val ?> </td>
                <?php } ?>
                <td style="border:1px solid black;"><?= array_sum($row['ukuran_p']) ?></td>
                <td style="border:1px solid black;"><?= (array_sum($row['ukuran_l']) + array_sum($row['ukuran_p'])) ?></td>
            </tr>
        <?php } ?>
    </table>
</div>