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

## トランザクション
```php
$dbAdapter->beginTransaction();

$dbAdapter->commit();

$dbAdapter->rollback();
```
```php
public function registDetail($value_list) {

	try{
		global $dbAdapter;

		$dbAdapter->beginTransaction();
		foreach ($value_list as $value) {
			$sql = $this->getForRegistQuery($value);
			$dbAdapter->query($sql);
		}
		$dbAdapter->rollback();

		return true;

	} catch( Exception $ex ){
		//あとで書く
		// throw new Exception("SQL実行エラー",$ex->getCode(),$ex);

		return false;
	}

}
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


## SELECTでIN()を使う場合
http://nohohox.hateblo.jp/entry/20091226/1261850642  
tableオブジェクトに対してWhereの指定を行う
```php
// テーブルオブジェクト
// Zend_Db_Table_Abstractクラスを継承
$table=new ItemTable($con);

// 取得したいIDを配列で
$idList=array(1,5,9,11,3);

// Where句で渡すだけ
$rowset=$table->fetchAll($table->select()->where("item_id IN(?)",$idList));

var_dump($rowset);
```

## UPDATEでIN()を使う場合
tableオブジェクトに対してではなく、アダプタを使用して、Whereの条件文字列を生成する  
生成した条件文字列に対して、tableオブジェクトからupdate()メソッドを使用する
```php
// テーブルオブジェクト
// Zend_Db_Table_Abstractクラスを継承
$table=new ItemTable($con);

// 取得したいIDを配列で
$idList=array(1,5,9,11,3);

// カラム名 => 値 の連想配列で
// たとえば、在庫を0にする場合
$data=array("stock"=>0);
```


## select
```php
// SELECT
$select=$table->getAdapter()->quoteInto("order_number IN (?)",$idList);

// var_dump($select);
// string(*) "order_number IN ('1', '5', '9',......)" のような文字列が生成されている
		
// クエリー実行
$table->update($data, $select);
```


## select（メソッドチェーン）
```php
	//-----( 契約データを取得 )-----
	$select_contract = $this->getDb()->select()
										->from( array( TABLE_NA<E, _TABLE_NA<E ) )
										->where( "contract_id = ?", $contract_id );

	$contract_data = $this->getDb()->query( $select_contract )->fetch();
```


## orWhere
https://framework.zend.com/manual/1.12/ja/zend.db.select.html
```php
$select = $db->select()
             ->from('products',
                    array('product_id', 'product_name', 'price'))
             ->where('price < ?', $minimumPrice)
             ->orWhere('price > ?', $maximumPrice);
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

```php
//-----< 更新内容を取得 >-----
$value_of_update = array(
                      'company_id'       => $original_petition_record['transfer_target_company_id']
                    , 'office_id'        => $original_petition_record['transfer_target_office_id']
                    , 'update_user_id'   => $this->_userData['company_user_id']
                    , 'update_datetime'  => date( "Y-m-d H:i:s", time() )
                );

$value_of_where = array(
                    $this->db->quoteInto( 'client_id = ?' , $original_petition_record['client_id'] )
                );

//-----< 更新処理 >-----
$this->db->update('clients', $value_of_update, $value_of_where );
```
_____________________________________________________________________________________
## insert
```php
    global $dbAdapter;
    $data = array();
    $data = array(
          'client_id'       => $original_record['client_id']
        , 'estimate_id'     => "0"
        , 'regist_user_id'  => $this->_userData['company_user_id']
        , 'regist_datetime' => date( "Y-m-d H:i:s", time() )
    );
    $dbAdapter->insert("clients", $data);
```

## insert後の last inserted id 
```php
$this->db->insert( self::TBL_NAME, $target_data );

// last inserted id
$target_data[self::PK] = $this->db->lastInsertId();
```
_____________________________________________________________________________________
## merge(upsert)
```php
	global $dbAdapter;

	$select = $dbAdapter->select();
	$select->from( array('MY_TABLE_01' => 'MY_TABLE_01'));
	$where = $dbAdapter->quoteInto('id = ?' , $value['id']);
	$select->where($where);
	$query_data = $dbAdapter->query($select)->fetchAll();
	if(count($query_data) > 0){
		$data = array();
		$data['remarks'] = $value['remarks'];
		$dbAdapter->update('MY_TABLE_01', $data, $where);

	}
	else{
		$data = array();
		$data['repor_id'] = 22;
		$data['part_id']  = 33;
		$data['remarks']  = "new";

		$dbAdapter->insert('MY_TABLE_01', $data);
	}
```

_____________________________________________________________________________________
## where : in への引数
```php
global $dbAdapter;

    $select = $dbAdapter->select();
    $table = array(
        MY_TABLE_01 => MY_TABLE_01
    );
    $column = array(
                'item_id',
                'item_quantity'
            );
    $select->from($table, $column);
    $select->where("report_id  = ?", $report_id);
    $select->where("checked_item_id in (?)", $checked_item_id_list);  // 配列を引数に渡す
    $query_data = $dbAdapter->query($select)->fetchAll();
```

_____________________________________________________________________________________
## select : join, where, order by
```php
$select = $this->dbAdapter->select()
                                ->from( array( 'my_table_01' => 'my_table_01' ), $column )
                                ->joinleft( array( 'buildings' => 'buildings' ),'my_table_01.building_id = buildings.building_id', '*' )
                                ->joinleft( array( 'clients' => 'clients' )    ,'my_table_01.client_id   = clients.client_id'    , '*' )
                                ->where( 'my_table_01.client_id  > ?', 0 )
                                ->where( 'my_table_01.service_id = ?', 1 )
                                ->where( 'my_table_01.del_flag   = ?', 0 )
                                ->where( 'my_table_01.building_detail_id IN(?)', $idList )
                                ->where( 'buildings.id is null', '' )
                                ->order( 'buildings.building_detail_id' )
                                ->order( 'buildings.service_id  DESC' )

    $select->order(array(
        "category_id DESC",
        "chart_id",
    ));
```

_____________________________________________________________________________________
## bindValue
```php
## bindValue
//$db = Zend_Db::factory('PDO_SQLITE', $params);

    // $dbAdapter = Zend_Db::factory($configuration->database);
    global $dbAdapter;


	$params = array();
    $params['case_id'] = $case_id;
    $params['category_id'] = $category_id;
    if( !empty($direction_id) ){
        $params['direction_id'] = $direction_id;
    }


    $result = $dbAdapter->query(
        $sql,
        $params
    );
    $fetchedData = $result->fetchAll();


```

_____________________________________________________________________________________

