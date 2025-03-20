<?php
$conn = mysqli_connect('localhost', 'root', 'root', 'ppdb');
$query = mysqli_query($conn, "SELECT * FROM jenis");


$kode = $_GET['kode'];
$level = $_GET['level'];
$id = $_GET['id'];
$context = stream_context_create(
	array(
		"http" => array(
			"header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
		)
	)
);
include('simplehtmldom/simple_html_dom.php');
?>


<?php

	// echo $kode_data;

	if($kode == "191201") {
		$kecamatan = "730701"; //sinjai barat 

	}elseif ($kode == "191202") {
		$kecamatan = "730707"; //sinjai borong  

	}elseif($kode == "191203") {
		$kecamatan = "730702"; // sinjai selatan 

	}elseif ($kode == "191204") {
		$kecamatan = "730708"; // tellulimpoe

	}elseif ($kode == "191205" ) {
		$kecamatan = "730703"; // sinjai timur 

	}elseif ($kode == "191206") {
		$kecamatan = "730704"; // sinjai tengah 

	}elseif ($kode == "191207" ) {
		$kecamatan = "730705"; //sinjai utara 

	}elseif ($kode == "191208") {
		$kecamatan = "730706"; // bulupoddo

	}elseif ($kode == "191209") {
		$kecamatan = "730709"; // pulau sembilan 
	}


	if($id == "5" || $id == "6") {

			$url = 'https://referensi.data.kemdikbud.go.id/index11.php?kode=' . $kode . '&level=' . $level . '&id=' . $id . '';
			$html = file_get_html($url, FALSE, $context);
			
			$get = $html->find('table#example tr');
			echo "<br><br><br>";
			foreach ($get as $post) {
				$npsn = str_replace('&nbsp;','', $post->children('1')->plaintext);
				$nama = strip_tags($post->children('2')->plaintext);
				$alamat =strip_tags($post->children('3')->plaintext);
				$kel = strip_tags($post->children('4')->plaintext);
				$kec = $kecamatan;
				$kab = "7307";
				$status_sekolah = strip_tags($post->children('5')->plaintext);
				?>
				<table>
					<tr>
						<td><?= $post->children('0')->plaintext //no  ?> </td>
						<td><?= str_replace('&nbsp;','', $post->children('1')->plaintext); //npsn  ?> </td>
						<td><?= $post->children('2')->plaintext //nama  ?> </td>
						<td><?= $post->children('3')->plaintext //alamat  ?> </td>
						<td><?= $post->children('4')->plaintext //kelurahan  ?> </td>
						<td><?= $status_sekolah //status  ?> </td>
					</tr>
				</table>
				<?php
				$cek = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tbl_sekolah WHERE npsn = '$npsn' "));
				if($cek == "0") {
					$insert = mysqli_query($conn, "INSERT INTO tbl_sekolah (npsn,nama,alamat,kel,kec,kab,status,level_sekolah,email,no_hp,username,password)
									VALUES ('$npsn','$nama','$alamat','$kel','$kec','$kab','$status_sekolah','$id','','','$npsn',sha1(md5($npsn))) ") or die(mysqli_error($conn));
					if ($insert) {
						echo "mantak";
					} else {
						echo "gagal";
					}
				}
				
				
			}

	}



	if($id == "4") {

			$url = 'https://referensi.data.kemdikbud.go.id/index21.php?kode=' . $kode . '&level=' . $level . '';
			$html = file_get_html($url, FALSE, $context);
			
			$get = $html->find('table#example tr');
			echo "<br><br><br>";
			foreach ($get as $post) {
				$npsn = str_replace('&nbsp;','', $post->children('1')->plaintext);
				$nama = strip_tags($post->children('2')->plaintext);
				$alamat =strip_tags($post->children('3')->plaintext);
				$kel = strip_tags($post->children('4')->plaintext);
				$kec = $kecamatan;
				$kab = "7307";
				$status_sekolah = strip_tags($post->children('5')->plaintext);
				?>
				<table>
					<tr>
						<td><?= $post->children('0')->plaintext //no  ?> </td>
						<td><?= str_replace('&nbsp;','', $post->children('1')->plaintext); //npsn  ?> </td>
						<td><?= $post->children('2')->plaintext //nama  ?> </td>
						<td><?= $post->children('3')->plaintext //alamat  ?> </td>
						<td><?= $post->children('4')->plaintext //kelurahan  ?> </td>
						<td><?= $status_sekolah //status  ?> </td>
					</tr>
				</table>
				<?php
				$cek = mysqli_num_rows(mysqli_query($conn,"SELECT * FROM tbl_sekolah WHERE npsn = '$npsn' "));
				if($cek == "0") {
					$insert = mysqli_query($conn, "INSERT INTO tbl_sekolah (npsn,nama,alamat,kel,kec,kab,status,level_sekolah,email,no_hp,username,password)
									VALUES ('$npsn','$nama','$alamat','$kel','$kec','$kab','$status_sekolah','4','','','$npsn',sha1(md5($npsn))) ") or die(mysqli_error($conn));
					if ($insert) {
						echo "mantak";
					} else {
						echo "gagal";
					}
				}
			}
	}
?>