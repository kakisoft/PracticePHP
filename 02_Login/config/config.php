<?php

ini_set('display_errors', 1);

// define('DSN', 'mysql:dbhost=localhost;dbname=dotinstall_sns_php');
// define('DB_USERNAME', 'dbuser');
// define('DB_PASSWORD', 'mu4uJsif');

// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

define('DSN', 'mysql:dbhost=localhost;dbname=kakidb02');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');

//http://127.0.0.1:8080/PracticePHP/02_Login/public_html/signup.php
// define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST'] . "PracticePHP/02_Login/public_html");


require_once(__DIR__ . '/../lib/functions.php');
require_once(__DIR__ . '/autoload.php');

session_start();