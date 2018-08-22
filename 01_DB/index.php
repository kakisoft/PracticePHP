<?php

define('DB_DATABASE', 'kakidb01');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);  //Data Source Name

try {
  // connect
  $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  //
  echo "hello";

} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}