# インデックス_ロックの怖い話2

どの順番で効くか不明。  
レコードを登録して試してみも、今一つ。  

オプティマイザの気分次第？
```sql
  KEY `items_index_1` (`parent_job_id`,`deleted_at`),
  KEY `items_index_2` (`parent_job_id`,`child_job_sequence_no`,`deleted_at`),
  KEY `items_index_3` (`extends_relation_key`)
```

インデックスが設定されていても、ある程度の量のレコードが無いと、インデックスが効かない？  

parent_job_id と deleted_at のみを where 句に含めると、items_index_1 が効きそうだけど、そうでもないみたい。  
そのため、どのインデックスが有効となるか、判定が難しい。  

また、インデックスを一度効かせると、その内容を保持し、以降はその情報を参照する（と思われる）。  
そのため、現象の再現は難しい。  

## 複数カラムを使用したインデックス
順番が重要みたい。  

Good : parent_job_id, deleted_at  
Bad  : deleted_at   , parent_job_id  

[MySQLで複合インデックスを貼る時、貼り方（貼る順番）を気をつけないとほとんど効果がない件](https://hiroslog.com/post/260)  


## UPDATE時のインデックス
update 文を発行する時もインデックスを使用する。  

→ id による select 句の絞り込みをして、その値にて update 文を発行。  

__________________________________________________________________________________________
# 暫定対応
デッドロックのタイムアウト時間を伸ばす。  
（デッドロックは、一定時間経過後（一定時間ウェイトした後）に発生する）  

## ロックのタイムアウト時間
```
-- SET innodb_lock_wait_timeout=300
-- SET innodb_lock_wait_timeout=50
 SHOW VARIABLES LIKE 'innodb_lock_wait_timeout'
```

## RDS：パラメータグループ
innodb_lock_wait_timeout  
lock_wait_timeout  


__________________________________________________________________________________________

## InnoDB のロック機構について
<https://medium.com/@terako.studio/innodb-%E3%81%AE%E3%83%AD%E3%83%83%E3%82%AF%E6%A9%9F%E6%A7%8B%E3%81%AB%E3%81%A4%E3%81%84%E3%81%A6-626a1c423185>


__________________________________________________________________________________________
## ヒント句
<https://dev.mysql.com/doc/refman/5.6/ja/index-hints.html>  


use は、フルスキャンが早ければ、フルスキャン  


```sql
-- explain
SELECT
 * 
FROM
    items  force INDEX (items_index_1)
WHERE  1=1
--    AND items.parent_shipper_job_id = 9999
--    AND items.parent_shipper_job_id = 6347 
--    AND items.child_shipper_job_sequence_no = 2
--    AND items.shipper_id = 57 
--    AND items.sales_channel_id = 113 
--    AND items.is_allocatable_regardless_inventory not in (1,0)
--    AND  items.deleted_at IS NULL
```

```sql
-- explain
UPDATE items force INDEX (items_index_1)
   set error_message = 'test'
      ,is_enabled_importing = 0
WHERE  1=1
--    AND items.parent_shipper_job_id = 9999
    AND items.parent_shipper_job_id = 6347 
--    AND items.child_shipper_job_sequence_no = 2
--    AND items.shipper_id = 57 
--    AND items.sales_channel_id = 113 
--    AND items.is_allocatable_regardless_inventory not in (1,0)
    AND  items.deleted_at IS NULL
```


___________________
___________________
___________________
```sql
select
     table_name
    ,index_name
    ,column_name
from
    information_schema.statistics
where  1=1
  and  table_schema = database()
  and  table_name   = 'items'
--  and  index_name   = 'PRIMARY'
```

