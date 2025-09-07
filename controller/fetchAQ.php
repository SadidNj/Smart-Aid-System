<?php
require_once __DIR__ . '/../model/PollutionModel.php';
require_once __DIR__ . '/../config/api.php';

if (!defined('OPENWEATHER_API_KEY') || OPENWEATHER_API_KEY === 'YOUR_OPENWEATHER_API_KEY_HERE') {
    http_response_code(500);
    echo json_encode(['error' => 'API key not set. Edit config/api.php and put your OpenWeather API key.']);
    exit();
}

$lat = isset($_GET['lat']) ? floatval($_GET['lat']) : null;
$lon = isset($_GET['lon']) ? floatval($_GET['lon']) : null;

if ($lat === null || $lon === null) {
    http_response_code(400);
    echo json_encode(['error' => 'lat and lon are required (e.g. ?lat=23.8&lon=90.4)']);
    exit();
}

// OpenWeather Air Pollution API
$apiKey = OPENWEATHER_API_KEY;
$url = "http://api.openweathermap.org/data/2.5/air_pollution?lat={$lat}&lon={$lon}&appid={$apiKey}";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

if ($err) {
    http_response_code(500);
    echo json_encode(['error' => 'cURL error: ' . $err]);
    exit();
}

$data = json_decode($response, true);
if (!$data || !isset($data['list'][0]['main']['aqi'])) {
    http_response_code(500);
    echo json_encode(['error' => 'Unexpected API response', 'raw' => $data]);
    exit();
}

$aqi = intval($data['list'][0]['main']['aqi']);

// Save to DB
$model = new PollutionModel();
// store raw JSON as string (escape)
$raw = json_encode($data);
$model->insertAirQuality($lat, $lon, $aqi, $raw);

// Return JSON
echo json_encode(['lat'=>$lat,'lon'=>$lon,'aqi'=>$aqi,'raw'=>$data]);