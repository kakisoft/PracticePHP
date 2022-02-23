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


## トランザクション分離レベル
https://ja.wikipedia.org/wiki/%E3%83%88%E3%83%A9%E3%83%B3%E3%82%B6%E3%82%AF%E3%82%B7%E3%83%A7%E3%83%B3%E5%88%86%E9%9B%A2%E3%83%AC%E3%83%99%E3%83%AB


ANSI/ISO SQL標準で定められている分離レベルは、下記の4種類で定義されている。

### SERIALIZABLE（直列化可能）
複数の並行に動作するトランザクションそれぞれの結果が、いかなる場合でも、それらのトランザクションを時間的重なりなく逐次実行した場合と同じ結果となる。このような性質を直列化可能性（Serializability）と呼ぶ.SERIALIZABLEは最も強い分離レベルであり、最も安全にデータを操作できるが、相対的に性能は低い。ただし同じ結果とされる逐次実行の順はトランザクション処理のレベルでは保証されない。

### REPEATABLE READ（読み取り対象のデータを常に読み取る）　※MySQL デフォルト
ひとつのトランザクションが実行中の間、読み取り対象のデータが途中で他のトランザクションによって変更される心配はない。同じトランザクション中では同じデータは何度読み取りしても毎回同じ値を読むことができる。
ただし ファントム・リード(Phantom Read) と呼ばれる現象が発生する可能性がある。ファントム・リードでは、並行して動作する他のトランザクションが追加したり削除したデータが途中で見えてしまうため、処理の結果が変わってしまう。

### READ COMMITTED（確定した最新データを常に読み取る）
他のトランザクションによる更新については、常にコミット済みのデータのみを読み取る。 MVCC はREAD COMMITTEDを実現する実装の一つである。
ファントム・リード に加え、非再現リード(Non-Repeatable Read)と呼ばれる、同じトランザクション中でも同じデータを読み込むたびに値が変わってしまう現象が発生する可能性がある。

### READ UNCOMMITTED（確定していないデータまで読み取る）
他の処理によって行われている、書きかけのデータまで読み取る。
PHANTOM 、 NON-REPEATABLE READ 、さらに ダーティ・リード(Dirty Read) と呼ばれる現象（不完全なデータや、計算途中のデータを読み取ってしまう動作）が発生する。トランザクションの並行動作によってデータを破壊する可能性は高いが、その分性能は高い。


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

