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


class User {
  //======( 省略可 )=====
  // public $id;
  // public $name;
  // public $score;

  public function show() {
      echo "<pre>";
      echo "$this->name ($this->score)";
      echo "</pre>";
  }
}

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

    $name = "a";    $score = 1;    $stmt->execute();
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
    //     query （select） 条件付き
    //=================================
    echo "<br>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    $sql =<<<SQL
select
    *
from
    users
where  1=1
  and  name like :target_name
  and  score >   :min_score
order by
    score desc limit :disp_recored
SQL;

    $target_name  = "%k%";
    $min_score    = 70;
    $disp_recored = 5;

    $stmt = $db->prepare($sql);
    $stmt->bindValue(':target_name' , $target_name  );
    $stmt->bindValue(':min_score'   , $min_score    );
    $stmt->bindValue(':disp_recored', $disp_recored , PDO::PARAM_INT);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($users as $user) {
      echo "<pre>";
      var_dump($user);
      echo "</pre>";      
    }
    echo $stmt->rowCount() . " records found.";



    //=================================
    //   FETCH_CLASS  フェッチクラス
    //=================================
    echo "<br>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    $stmt = $db->query("select * from users limit 3");
    $users = $stmt->fetchAll(PDO::FETCH_CLASS, 'User');
    foreach ($users as $user) {
        $user->show();
    }


    //=================================
    //             UPDATE
    //=================================
    echo "<br>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    // update
    $stmt = $db->prepare("update users set score = :score where name = :name");
    $stmt->execute([
        ':score' => 100,
        ':name' => 'taguchi'
    ]);
    echo 'row updated: ' . $stmt->rowCount();


    //=================================
    //             DELETE
    //=================================
    echo "<br>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━<br>";
    // delete
    $stmt = $db->prepare("delete from users where name = :name");
    $stmt->execute([
        ':name' => 'bb'
    ]);
    echo 'row deleted: ' . $stmt->rowCount();



    //=================================
    //          disconnect
    //=================================
    // disconnect
    $db = null;

} catch (PDOException $e) {
  echo $e->getMessage();
  exit;
}