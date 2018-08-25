<?php
  /*
  (1) exec(): 結果を返さない、安全なSQL
  (2) query(): 結果を返す、安全、何回も実行されないSQL
  (3) prepare(): 結果を返す、安全対策が必要、複数回実行されるSQL（SQLをキャッシュしてくれる）
  */

define('DB_DATABASE', 'kakidb01');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'root');
define('PDO_DSN', 'mysql:dbhost=localhost;dbname=' . DB_DATABASE);  //Data Source Name


/*
PDO::PARAM_STR
PDO::PARAM_INT
PDO::PARAM_NULL
PDO::PARAM_BOOL

*/

try {
    //=================================
    //            connect
    //=================================
    $db = new PDO(PDO_DSN, DB_USERNAME, DB_PASSWORD);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    //=================================
    //            insert
    //=================================
    $db->exec("insert into users (name, score) values ('taguchi', 55)");
    //// execは、結果を返す必要が無いクエリを実行する時に使う。


    //=================================
    //            
    //=================================
    $stmt = $db->prepare("insert into users (name, score) values (?, ?)");
    $stmt->execute(['taguchi', 44]);
    echo "inserted: " . $db->lastInsertId();
    echo "<br>";


    //=================================
    //       名前付きパラメータ
    //=================================
    $stmt = $db->prepare("insert into users (name, score) values (:name, :score)");
    $stmt->execute([':name'=>'fkoji', ':score'=>80]);
    echo "inserted: " . $db->lastInsertId();
    echo "<br>";
  

    //=================================
    //             bindValue
    //=================================
    $stmt = $db->prepare("insert into users (name, score) values (?, ?)");    
    $name = 'yamada';
    $stmt->bindValue(1, $name, PDO::PARAM_STR);
    // $stmt->bindValue(':name', $name, PDO::PARAM_STR);
    $score = 23;
    $stmt->bindValue(2, $score, PDO::PARAM_INT);
    $stmt->execute();
    $score = 44;
    $stmt->bindValue(2, $score, PDO::PARAM_INT);
    $stmt->execute();
  
    // PDO::PARAM_NULL
    // PDO::PARAM_BOOL


    //=================================
    //        bindValue  HON
    //=================================
    $name = "kaki";
    $score = "80";

    
    $sql =<<<SQL
insert into users 
 (name , score) 
values 
 (:name, :score)
SQL;

    $stmt = $db->prepare($sql);    
    $stmt->bindValue(':name' , $name);
    $stmt->bindValue(':score', $score);
    $stmt->execute();


    //=================================
    //          bindParam
    //=================================
    $stmt = $db->prepare("insert into users (name, score) values (?, ?)");

    $name = 'taguchi';
    $stmt->bindValue(1, $name , PDO::PARAM_STR);  
    $stmt->bindParam(2, $score, PDO::PARAM_INT);
    $score = 52;    $stmt->execute();
    $score = 44;    $stmt->execute();
    $score = 6;     $stmt->execute();
  

    //=================================
    //        bindParam  HON
    //=================================    
    $sql =<<<SQL
insert into users 
 (name , score) 
values 
 (:name, :score)
SQL;

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name' , $name , PDO::PARAM_STR);
    $stmt->bindParam(':score', $score, PDO::PARAM_INT);

    $name = "a";    $score = 1;   $stmt->execute();
    $name = "bb";   $score = 22;   $stmt->execute();
    $name = "ccc";  $score = 333;  $stmt->execute();


    //=================================
    //        query （select）
    //=================================
    // select all
    $stmt = $db->query("select * from users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
      echo "<pre>";
      var_dump($user);
      echo "</pre>";
    }
    echo $stmt->rowCount() . " records found.";



  //=================================
    //          disconnect
    //=================================
    // disconnect
    $db = null;

} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}