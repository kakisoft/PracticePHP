## PDO(PHP Data Object)
```

```


## トランザクション
```
$db = MY_DB_UTIL::master();
$db->query('BEGIN TRANSACTION');

if ( $db->query('COMMIT') != false ) {
	// 登録/更新成功時ここでreturn
	return 0;
}
```