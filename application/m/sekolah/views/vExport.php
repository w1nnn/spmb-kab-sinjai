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
header("Content-Disposition: attachment; filename=Data Sekolah.xls");
?>
<h2> Macca PPDB - Kabupaten Sinjai </h2>

<table>
    <tr>
        <td><b> TANGGAL DOWNLOAD </b> </td>
        <td><b><?= tgl_indo(date('Y-m-d'))  ?> Pukul : <?= date('H:i:s'); ?> </b> </td>
    </tr>
</table>
<br>
<div class="table-responsive">
    <table class="table table-hover" id="table" style="border:1px solid black;">
        <tr>
            <th style="border:1px solid black;">No.</th>
            <th style="border:1px solid black;">NPSN</th>
            <th style="border:1px solid black;">Nama</th>
            <th style="border:1px solid black;">Kuota</th>
            <th style="border:1px solid black;">Pendaftar</th>
        </tr>

        <?php
        $no = 1;
        foreach ($sekolah->result() as $row) {
        ?>
            <tr>
                <td style="border:1px solid black;"><?= $no++ ?> </td>
                <td style="border:1px solid black;"><?= $row->npsn ?> </td>
                <td style="border:1px solid black;"><?= $row->nama ?> </td>
                <td style="border:1px solid black;"><?= $row->kuota ?? 0 ?> </td>
                <td style="border:1px solid black;"><?= $row->pendaftar ?? 0 ?> </td>
            </tr>
        <?php } ?>

    </table>
</div>