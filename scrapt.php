<?php
set_time_limit(10);

$nama = isset($_POST['selectedSchool']) ? $_POST['selectedSchool'] : '';
if (empty($nama)) die("Parameter 'selectedSchool' tidak ditemukan.");

$searchUrl = "https://sekolah.data.kemdikbud.go.id/index.php/Chome/pagingpencarian";
$postData = "page=1&nama=" . urlencode($nama) . "&kode_kabupaten=&kode_kecamatan=&bentuk_pendidikan=&status_sekolah=";

$ch = curl_init();
curl_setopt_array($ch, [
    CURLOPT_URL => $searchUrl,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 4,
    CURLOPT_CONNECTTIMEOUT => 1,
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_HTTPHEADER => ["X-Requested-With: XMLHttpRequest", "Content-Type: application/x-www-form-urlencoded"]
]);

$response = curl_exec($ch);
if (!$response || curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
    die("Search failed");
}
curl_close($ch);

if (!preg_match('/href="(https:\/\/sekolah\.data\.kemdikbud\.go\.id[^"]+profil[^"]+)"/', $response, $matches)) {
    die("No school found");
}

$ch2 = curl_init($matches[1]);
curl_setopt_array($ch2, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 6,
    CURLOPT_CONNECTTIMEOUT => 1,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_SSL_VERIFYPEER => false
]);

$result = curl_exec($ch2);
curl_close($ch2);

$mapHtml = '';

if (preg_match('/<head[^>]*>(.*?)<\/head>/s', $result, $headMatches)) {
    $head = $headMatches[1];
    
    preg_match_all('/<link[^>]*leaflet[^>]*>/i', $head, $leafletLinks);
    preg_match_all('/<script[^>]*leaflet[^>]*><\/script>/i', $head, $leafletScripts);
    preg_match_all('/<meta[^>]*(?:charset|viewport)[^>]*>/i', $head, $metaTags);
    
    $headContent = implode("\n\t", $metaTags[0]) . "\n\t" .
                  implode("\n\t", $leafletLinks[0]) . "\n\t" .
                  implode("\n\t", $leafletScripts[0]);
} else {
    $headContent = '<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">';
}

$styleContent = '';
if (preg_match('/<style[^>]*>(.*?)<\/style>/s', $result, $styleMatches)) {
    $styleContent = $styleMatches[1];
}

$mapDiv = '';
$mapScript = '';

if (preg_match('/<div[^>]*id=["\']map["\'][^>]*>.*?<\/div>/s', $result, $mapDivMatches)) {
    $mapDiv = $mapDivMatches[0];
}

if (preg_match('/<script[^>]*language=["\']javascript["\'][^>]*>(.*?)<\/script>/s', $result, $scriptMatches)) {
    $mapScript = $scriptMatches[1];
}

$mapHtml = '<!DOCTYPE html>
<html lang="en">
<head>
    ' . $headContent . '
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.css" />
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/MarkerCluster.css" />
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.fullscreen.css" />
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.markercluster-src.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/lib/Leaflet.zoomslider/src/L.Control.Zoomslider.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/L.TileLayer.Multi.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.fullscreen.min.js"></script>
    <style>
        ' . $styleContent . '
    </style>
</head>
<body>
    ' . $mapDiv . '
    <script language="javascript">
        ' . $mapScript . '
    </script>
</body>
</html>';

if (empty($mapDiv) || empty($mapScript)) {
    $mapPattern = '/(<div[^>]*id=["\']map["\'][^>]*>.*?<\/div>.*?<script[^>]*language=["\']javascript["\'][^>]*>.*?<\/script>)/s';
    if (preg_match($mapPattern, $result, $mapMatches)) {
        $mapHtml = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.css" />
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/MarkerCluster.css" />
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/MarkerCluster.Default.css" />
    <link rel="stylesheet" href="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.fullscreen.css" />
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.markercluster-src.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/lib/Leaflet.zoomslider/src/L.Control.Zoomslider.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/L.TileLayer.Multi.js"></script>
    <script src="https://sekolah.data.kemdikbud.go.id/assets/leaflet/leaflet.fullscreen.min.js"></script>
    <style>
        .info {
            padding: 6px 8px;
            font: 14px/16px Arial, Helvetica, sans-serif;
            background: white;
            background: rgba(255, 255, 255, 0.8);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }
        .legend {
            text-align: left;
            line-height: 18px;
            color: #555;
        }
        .legend i {
            width: 18px;
            height: 18px;
            float: left;
            margin-right: 8px;
            opacity: 0.7;
        }
    </style>
</head>
<body>
    ' . $mapMatches[1] . '
</body>
</html>';
    }
}

echo $mapHtml;
file_put_contents('response.php', $mapHtml);
?>