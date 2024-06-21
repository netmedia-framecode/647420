<?php
$ip = $_SERVER['REMOTE_ADDR'];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://ipinfo.io/180.249.166.60/json?token=7ac8e9c9be73ba');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

$result = curl_exec($ch);
if (curl_errno($ch)) {
  echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$data_geolocation = json_decode($result);

echo "<pre>";
print_r($data_geolocation);
echo "</pre>";
