<?php

header("Access-Control-Allow-Origin: *");
ini_set('display_errors', 1);

require_once('TwitterAPIExchange.php');
//
//$settings = array(
//    'oauth_access_token' => "183704754-4haXnrHppI6FwETgyYoPG6Ja8yVLV6ZtpgzgQVM",
//    'oauth_access_token_secret' => "9IXRlbLmFW27VeTbQInIVjPmDUz4rBQsxYe94SRW9Ac",
//    'consumer_key' => "LJrslT7mzx7zZjc5dRlOX6zi1",
//    'consumer_secret' => "LBHpcjK7LfyhNMokAPikoUHmjZiHDDg1HdrsWCJyGNoMDWWxZJ"
//);

if (file_exists('secrets.ini')) {
    $settings = parse_ini_file("secrets.ini");
} else {
    $settings = array(
        'oauth_access_token' => getenv('oauth_access_token'),
        'oauth_access_token_secret' => getenv('oauth_access_token_secret'),
        'consumer_key' => getenv('consumer_key'),
        'consumer_secret' => getenv('consumer_secret')
    );
}

$url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
$url = 'https://api.twitter.com/1.1/search/tweets.json';
$getfield = '?q=' . urlencode($_GET['q'] ? : '') . '&lang=en&result_type=mixed&count=50';
$requestMethod = 'GET';

$twitter = new TwitterAPIExchange($settings);
$response = $twitter->setGetfield($getfield)
        ->buildOauth($url, $requestMethod)
        ->performRequest();

header('Content-Type: application/json');
echo($response);
?>

