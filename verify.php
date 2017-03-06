<?php
$access_token = 'eYrUwuYVBvWMCWaMOgVVpJ+340T6phdQcs/McASQpkttbwakaPsGBuKDiYA5atIRqY559W+yUFkMxeOCtzg4PIf4JFlN+1o7VbSJyj3MwP+SImCrPvSGg59PDz2JTeOx6K+aQvH2Cz3A40CHsbf+hgdB04t89/1O/w1cDnyilFU=';

$url = 'https://api.line.me/v1/oauth/verify';

$headers = array('Authorization: Bearer ' . $access_token);

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
$result = curl_exec($ch);
curl_close($ch);

echo $result;
