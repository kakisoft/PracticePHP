<?php

//文字列の切り出し
if (strpos($class, $prefix) === 0) {
}

//URL:
$requestUri = parse_url($_SERVER["REQUEST_URI"]);
$requestQuery = $requestUri["query"];
$this->requestQuery = preg_replace('/\?dnumber=[0-9]*&sort=[0-9]*&_page=[0-9]/', "", $requestQuery);

