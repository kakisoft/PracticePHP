<?php
  /*
  (1) exec(): 結果を返さない、安全なSQL
  (2) query(): 結果を返す、安全、何回も実行されないSQL
  (3) prepare(): 結果を返す、安全対策が必要、複数回実行されるSQL
  */

define('DB_DATABASE', 'kakidb01');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);  //Data Source Name

try {
    // connect
    $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // insert
    $db->exec("insert into users (name, score) values ('taguchi', 55)");
    //// execは、結果を返す必要が無いクエリを実行する時に使う。

    $stmt = $db->prepare("insert into users (name, score) values (?, ?)");
    $stmt->execute(['taguchi', 44]);
    echo "inserted: " . $db->lastInsertId();

    // disconnect
    $db = null;

} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}