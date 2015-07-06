<?php


header("Access-Control-Allow-Origin: *");
ini_set('display_errors', 1);

require_once('TwitterAPIExchange.php');

$settings = array(
    'oauth_access_token' => "183704754-4haXnrHppI6FwETgyYoPG6Ja8yVLV6ZtpgzgQVM",
    'oauth_access_token_secret' => "9IXRlbLmFW27VeTbQInIVjPmDUz4rBQsxYe94SRW9Ac",
    'consumer_key' => "LJrslT7mzx7zZjc5dRlOX6zi1",
    'consumer_secret' => "LBHpcjK7LfyhNMokAPikoUHmjZiHDDg1HdrsWCJyGNoMDWWxZJ"
);


$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q='. $_GET['q'] . '&lang=en-gb&result_type=mixed&count=50';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
    ->buildOauth($url, $requestMethod)
    ->performRequest();

  header('Content-Type: application/json');
echo($response);

//echo($response);


/*
  function buildBaseString($baseURI, $method, $params) {
  $r = array();
  ksort($params);
  foreach($params as $key=>$value){
  $r[] = "$key=" . rawurlencode($value);
  }
  return $method."&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
  }

  function buildAuthorizationHeader($oauth) {
  $r = 'Authorization: OAuth ';
  $values = array();
  foreach($oauth as $key=>$value)
  $values[] = "$key=\"" . rawurlencode($value) . "\"";
  $r .= implode(', ', $values);
  return $r;
  }

  $url = "https://api.twitter.com/1.1/search/tweets.json?q=test";
  //$url = "https://api.twitter.com/1.1/statuses/user_timeline.json";

  $oauth_access_token = $settings['oauth_access_token'];
  $oauth_access_token_secret = $settings['oauth_access_token_secret'];
  $consumer_key = $settings['consumer_key'];
  $consumer_secret = $settings['consumer_secret'];

  $oauth = array( 'oauth_consumer_key' => $consumer_key,
  'oauth_nonce' => time(),
  'oauth_signature_method' => 'HMAC-SHA1',
  'oauth_token' => $oauth_access_token,
  'oauth_timestamp' => time(),
  'oauth_version' => '1.0');

  $base_info = buildBaseString($url, 'GET', $oauth);
  $composite_key = rawurlencode($consumer_secret) . '&' . rawurlencode($oauth_access_token_secret);
  $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, true));
  $oauth['oauth_signature'] = $oauth_signature;

  // Make requests
  $header = array(buildAuthorizationHeader($oauth), 'Expect:');
  $options = array( CURLOPT_HTTPHEADER => $header,
  //CURLOPT_POSTFIELDS => $postfields,
  CURLOPT_HEADER => false,
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_SSL_VERIFYPEER => false);

  $feed = curl_init();
  curl_setopt_array($feed, $options);
  $json = curl_exec($feed);
  curl_close($feed);

  $twitter_data = json_decode($json);

  //print_r($twitter_data);

  header('Content-Type: application/json');
  echo json_encode($twitter_data);
 */
?>

