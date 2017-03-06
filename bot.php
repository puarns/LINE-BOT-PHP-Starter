<?php
$access_token = 'eYrUwuYVBvWMCWaMOgVVpJ+340T6phdQcs/McASQpkttbwakaPsGBuKDiYA5atIRqY559W+yUFkMxeOCtzg4PIf4JFlN+1o7VbSJyj3MwP+SImCrPvSGg59PDz2JTeOx6K+aQvH2Cz3A40CHsbf+hgdB04t89/1O/w1cDnyilFU=';

// Get POST body content
$content = file_get_contents('php://input');
//$xx = @file_get_contents('https://'.$_SERVER['SERVER_NAME'].'/LINE/' . json_encode($content));
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			// Get replyToken
			$replyToken = $event['replyToken'];
			
			//$header = array('Content-Type: application/json');
			$url = 'http://linebot.linetor.com/api.php';
			$data = array('mid' => '123', 'message' => $text);
			$content = json_encode($data);
			$curl = curl_init($url);
			curl_setopt($curl, CURLOPT_URL, $url);
			//curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
			//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 20);
			$result = curl_exec($curl);
			$response = json_decode($result, true);
			$returnMessage = $response['msg'];
			//$returnMessage = 'ddda';

			//$returnMessage = $xx;
			// Build message to reply back
			$messages = [
				'type' => 'text',
				'text' => $returnMessage
			];

			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
			$post = json_encode($data);
			$headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			$result = curl_exec($ch);
			curl_close($ch);

			echo $result . "\r\n";
		}
	}
}
echo "OK";
