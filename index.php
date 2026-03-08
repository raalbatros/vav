<?php
$id = $_GET['id'] ?? '2346924541149e465206c7';
$url = "https://vavoo.to/vavoo-iptv/play/{$id}";

echo "DEBUG: VAVOO URL: " . $url . "<br>";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_USERAGENT, 'VAVOO/2.6 Android');
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$html = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: " . $httpCode . "<br>";
echo "HTML uzunluk: " . strlen($html) . "<br>";

// M3U8 ara
preg_match('/src="([^"]+\.m3u8[^"]*)"/', $html, $matches);
$m3u8 = $matches[1] ?? '';

if($m3u8) {
    echo "✅ M3U8 BULUNDU: " . $m3u8 . "<br>";
    header('Content-Type: application/vnd.apple.mpegurl');
    readfile($m3u8);
} else {
    echo "❌ M3U8 BULUNAMADI<br>";
    echo "İlk 2000 karakter HTML:<br><pre>" . htmlentities(substr($html, 0, 2000)) . "</pre>";
}
?>
