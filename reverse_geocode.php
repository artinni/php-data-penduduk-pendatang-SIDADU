<?php
if (!isset($_GET['lat']) || !isset($_GET['lon'])) {
    echo json_encode(['error' => 'Parameter tidak lengkap']);
    exit;
}

$lat = $_GET['lat'];
$lon = $_GET['lon'];

$url = "https://nominatim.openstreetmap.org/reverse?format=json&lat={$lat}&lon={$lon}";

// Nominatim butuh User-Agent
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'SIDADU/1.0'); // Wajib
$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $response;
