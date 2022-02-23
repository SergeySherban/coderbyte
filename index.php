<?php
//No external libraries allowed! All code must be hand-written.
//Used vanilla PHP 7.4
require_once __DIR__ . '/autoload.php';

use App\Api\ApiRequest;
use App\Api\ApiAuth;

//The endpoint requires Bearer HTTP authentication.
$url = 'https://corednacom.corewebdna.com/assessment-endpoint.php';
$auth = new ApiAuth($url);
$token = $auth->getToken();

//Send JSON payloads
$data = '{
    "name": "Sergey Shcherban",
    "email": "sv.sherban@gmail.com",
    "url": "https://github.com/SergeySherban/coderbyte"
}';

//Send custom HTTP headers
$header = [
    'Accept: application/x-www-form-urlencoded',
    'Authorization: Bearer ' . $token,
    'Content-Type: application/json'
];

$requestHTTP = new ApiRequest();

//Send HTTP requests to the given URL using different methods, such as GET, POST, etc.
$methodPost = $requestHTTP->httpRequest($url, $header, 'POST', $data);

//All JSON payloads must be returned as associative arrays
var_dump(json_decode($methodPost, true));

