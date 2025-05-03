<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data_Lulusan_Siswa.xls");
header("Pragma: no-cache");
header("Expires: 0");

// Buffer output
ob_start();
echo "<h3>Data Lulusan Siswa</h3>";
echo "<p>Exported on: " . date('d-m-Y H:i:s') . "</p>";

if(!empty($siswas)) {
    // Start table output

    echo "<table border='1'>\n";
    
    // Header row
    echo "<tr>\n";
    echo "<th>No</th>\n";
    echo "<th>No. Pendaftaran</th>\n";
    echo "<th>Nama Siswa</th>\n";
    echo "<th>JK</th>\n";  
    echo "<th>Tempat, Tgl Lahir</th>\n";
    echo "<th>Asal Sekolah</th>\n";
    echo "<th>Sekolah Tujuan</th>\n";
    //echo "<th>Tgl Daftar</th>\n";
    echo "</tr>\n";
    
    // Data rows
    $no = 1; 
    foreach($siswas as $siswa) {
        $sekolah = $this->db->get_where('tbl_sekolah', ['npsn' => $siswa->pilihan_sekolah_1])->row();
        
        echo "<tr>\n";
        echo "<td>".$no++."</td>\n";
        echo "<td>".$siswa->no_pendaftaran."</td>\n";
        echo "<td>".$siswa->nama_siswa."</td>\n";
        echo "<td>".$siswa->jk."</td>\n";
        echo "<td>".$siswa->tempat_lahir.", ".date('d-m-Y', strtotime($siswa->tgl_lahir))."</td>\n";
        echo "<td>".$siswa->asal_sekolah."</td>\n";
        echo "<td>".($sekolah ? $sekolah->nama : '-')."</td>\n";
       // echo "<td>".date('d-m-Y', strtotime($siswa->tgl_daftar))."</td>\n";
        echo "</tr>\n";
    }
    
    echo "</table>";
    
} else {
    echo "Tidak ada data lulusan yang ditemukan.";
}

// Flush the output buffer and disable any further output
ob_end_flush();
exit();
?>