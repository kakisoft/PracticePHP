## Zend_db アダプタの例
```php
=================================================================
//SQL Server用アダプタ
$dbAdapter = Zend_Db::factory($configuration->database);


// DBアダプタ 
$dbAdapter = Zend_Registry::get('dbAdapter');

----------------------------------------------------------------

$configuration = new Zend_Config_Ini(APPLICATION_PATH . '/config/app.ini', APPLICATION_ENVIRONMENT);

=================================================================
```

〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓〓

## 生SQL
```php
    global $dbAdapter;

    $sql = "select * from  pb_t_case where id = 1 ";
    $result = $dbAdapter->query($sql);
    $query_data = $result->fetchAll();
```

_____________________________________________________________________________________
## select, from, where, 
```php
    global $dbAdapter;

    $select = $dbAdapter->select();
    $table = array(
        't_case'=> 'pb_t_case'
    );
    $column = array(
                't_case.id',
                't_case.name'
            );
    // $select->from($table);
    $select->from($table, $column);
    $select->where("t_case.id = ?", 1);
    // $select->where("t_case.name LIKE '%" . $value ."%' ");
    $query_data = $dbAdapter->query($select)->fetchAll();


    ////＜ こんな感じに、sql文字列化して実行することもできる ＞
    // $sql = $select->__toString();
    // $result = $dbAdapter->query($sql);
    // $query_data = $result->fetchAll();

```
_____________________________________________________________________________________
## join
joinLeft(【テーブル名】, 【JOIN条件】[, 【取得するカラム】])  
https://pentan.info/php/zend_fw/zend_db_select.html

```php
$sql = $this->db->select()
                // ユーザ
                ->from( array( 'us' => 'users' ), $col )
                    // 何かの状態
                    ->joinleft( array( 'mtp' => _TBL_MS_PATTERN ), 'us.pattern_id = mtp.id', array() )
                    // 何かの区分名称
                    ->joinleft( array( 'cdscn' => _TBL_MS_M_COMMON_DETAIL ), 'us.some_category = cdscn.category_id and cdscn.common_id="17" ', array() )


```
_____________________________________________________________________________________
## update
```php
    global $dbAdapter;

    $originalData = $this->getUniqueRecord($pb_t_news_id);
    $decodedData = json_decode($originalData['data'], true);
    $decodedData['check_user']     = $user_id;
    $decodedData['check_datetime'] = date("Y/m/d H:i");
    $encodedData = json_encode($decodedData);

    $detail = array(
        'del_flg'     => self::DEL_FLG_DELETED,
        'update_date' => date("Y/m/d H:i:s"),
        'data'        => $encodedData,
    );
    
    $where = $dbAdapter->quoteInto('id = ?' , $pb_t_news_id);
    $dbAdapter->update(self::TBL_NAME, $detail, $where);
```
_____________________________________________________________________________________



