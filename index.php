<?php
$id = $_GET['id'] ?? '2346924541149e465206c7';
$url = "https://vavoo.to/vavoo-iptv/play/{$id}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERAGENT, 'VAVOO/2.6 Android');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ch);
curl_close($ch);

preg_match('/src="([^"]+\.m3u8[^"]*)"/', $html, $matches);
$m3u8 = $matches[1] ?? '';

if($m3u8) {
    header('Content-Type: application/vnd.apple.mpegurl');
    readfile($m3u8);
} else {
    http_response_code(404);
    echo "Kanal bulunamadı";
}
?>
