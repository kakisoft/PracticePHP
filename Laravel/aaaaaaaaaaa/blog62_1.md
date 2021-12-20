# インデックス_ロックの怖い話1

[身に憶えのないDeadlock found when trying to get lock](https://yoku0825.blogspot.com/2012/07/deadlock-found-when-trying-to-get-lock.html  )  

<https://bugs.mysql.com/bug.php?id=69835>  
<https://bugs.mysql.com/bug.php?id=43210>  
<https://bugs.mysql.com/bug.php?id=43591>  


```sql
Next Illuminate\Database\QueryException: SQLSTATE[40001]: Serialization failure: 1213 Deadlock found when trying to get lock; try restarting transaction (SQL:                     update  items
                        set  error_message = concat(ifNull(items.error_message, &quot;&quot;),
{&quot;type&quot;:&quot;2&quot;,&quot;key&quot;:&quot;&quot;,&quot;replacement&quot;:[]})
```
____________________________________

## update 時のロック
（特定レコードへの処理）  
Aの処理  
Bの処理  
Cの処理  

　　↓  

A：処理中  
B：待機  
C：待機  

　　↓  

A：完了  
B：処理中  
C：エラー（デッドロックエラー）  

こんな感じで、ウェイトが２つ以上ある場合、２つ目以降は全てエラーとして扱われるらしい。  
「デッドロック」と銘打っているものの、ロック扱いとなっていない？  


## insert 時のロック
同時に insert が走ると、デッドロックが走る事がある。  
（id を予約して insert するため）  

A：insert 処理１  
B：insert 処理２  
C：insert 処理３  

　　↓  

A：処理中  
B：待機  
C：待機  

　　↓  

A：完了  
B：処理中  
C：エラー（デッドロックエラー）  

## ＜対策＞
リトライする  
直列にする  
repeatable read の設定を変える  

Exception で検知はできる  

（トランザクションの分離レベルが「repeatable read」）　※デフォルト  

## トランザクション分離レベル
<https://qiita.com/song_ss/items/38e514b05e9dabae3bdb>    

<https://techracho.bpsinc.jp/kotetsu75/2018_12_14/66410>  

<http://bashalog.c-brains.jp/18/04/17-130000.php>  

データベースでは以上のような問題を防ぐための設定が用意されています。  
トランザクションの独立性と処理速度はトレードオフになるので、 そのバランスをどうするかを、トランザクションの分離レベルで設定できる。  

トランザクション分離レベルにはREAD UNCOMMITED, READ COMMITED, REPEATABLE READ, SERIALIZABLEの4つの段階があります。 READ UNCOMMITEDが最も分離レベルが低く、SERIALIZABLEが一番高い。  

<http://highscalability.com/blog/2011/2/10/database-isolation-levels-and-their-effects-on-performance-a.html>  

