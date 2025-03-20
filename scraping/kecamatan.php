<?php

$context = stream_context_create(
	array(
		"http" => array(
			"header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
		)
	)
);
include('simplehtmldom/simple_html_dom.php');
?>
<table>
	
	<?php
	$url = 'https://referensi.data.kemdikbud.go.id/index11.php?kode=191200&level=2';
	$html = file_get_html($url,false, $context);
	
	$get = $html->find('table#box-table-a tr');
	
	
	$i = 1;
	foreach($get as $post) {
		echo "<tr>";
		echo "<td>". $post->children('0')->innertext."</td>";
		echo "<td>". $post->children('1')->innertext."</td>";
		echo "<td>". $post->children('17')->innertext."</td>";
		echo "</tr>";
		$i++;
	}
	
	?>
	</tbody>
</table>