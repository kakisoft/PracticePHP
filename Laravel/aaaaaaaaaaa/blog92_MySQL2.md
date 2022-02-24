https://medium.com/aerial-partners-engeneering/mysql-gaplock-5a194f31ec1f

> トランザクション分離レベルをREAD COMMITTEDに変更する
> READ COMMITTEDにするとファントムリードを許容するため、ギャップロックは取得されず、デッドロックも発生しません。
> ファントムリード、ファジーリードが問題とならない場合はこの方法もありですね。

## ファントムリード
一つのデータベースで複数のトランザクションを並列に実行する際に起きる問題で、あるトランザクションが同じテーブルから何度も読み込みを実施するような場合に、並行して実行されている別のトランザクションによるレコードの追加が反映され、同一トランザクション中なのに対象レコードや件数が増加してしまう。


## ギャップロック


## トランザクション分離レベル
https://www.matsubarasystems.com/mysql/insert-into-select-deadlock

MySQLのデフォルトトランザクション分離レベルは「REPEATABLE READ」

MySQLのデフォルトトランザクション分離レベルは「REPEATABLE READ」です。トランザクション分離レベルをざっくり説明すると、あるセッションのトランザクションで更新されたデータが、他セッションからのどう見えるかを設定するパラメータ値です。


「REPEATABLE READ」の場合、更新とは別のセッションで一度SELECTしたクエリを再度SELECTすると、そのデータが別なセッションで更新されていたとしても初回にSELECTした値と同じ値を返します。
「READ COMMITTED」の場合、最初のSELECTから次のSELECTの間に別なトランザクションが更新・削除を行いコミットされていれば更新後のデータを読み込みます。




トランザクション分離レベルの変更
トランザクション分離レベルを「READ COMMITTED」にすることで対応します。
また、トランザクション分離レベルが「READ COMMITTED」の場合、バイナリログの設定(binlog format)がSTATEMENTで運用不可の為、バイナリログの保存形式を「MIXED」に変更します。

my.cnf

[mysqld]
transaction-isolation=READ-COMMITTED
binlog_format=0

RDS なら
「 tx_isolation 」




## トランザクション分離レベルの変更
https://gihyo.jp/dev/serial/01/mysql-road-construction-news/0047



transaction-isolation



https://marock.tokyo/2021/07/13/mysql-%E3%83%88%E3%83%A9%E3%83%B3%E3%82%B6%E3%82%AF%E3%82%B7%E3%83%A7%E3%83%B3%E5%88%86%E9%9B%A2%E3%83%AC%E3%83%99%E3%83%AB%E3%82%92%E7%A2%BA%E8%AA%8D%E3%81%99%E3%82%8B%E6%96%B9%E6%B3%95/
### 確認用　バージョン5.X用
```sql
-- トランザクション分離レベル確認用SQL
SELECT @@GLOBAL.tx_isolation, @@tx_isolation;
```
@@GLOBAL.tx_isolationはグローバルに設定されているトランザクション分離レベルです。  
@@tx_isolationは現在のセッションで設定されているトランザクション分離レベルです。  


### 確認用　バージョン8用
```sql
-- トランザクション分離レベル確認用SQL
SELECT @@GLOBAL.transaction_isolation, @@transaction_isolation;
```
@@GLOBAL.transaction_isolationはグローバルに設定されているトランザクション分離レベルです。  
@@transaction_isolationは現在のセッションで設定されているトランザクション分離レベルです。  

______________________________________________________
## インテンションロック
http://tech.voyagegroup.com/archives/8085782.html



insert デッドロックの原因は、他のチケットで解決した内容の他にも起こりうる。
ログにて「lock_mode」というメッセージから、どんな種類のロックがかかったのかを特定できるケースもあるが、今回は「lock_mode」にて特定が出来ないケースとなる。


https://tech.mti.co.jp/entry/2017/12/27/190733

