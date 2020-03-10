```php
	/**
	 *  プライマリキーを基に、一意のレコードを抽出
	 * @param int Unique id
	 * @return array getted db data
	 */
	public function getUniqueRecord($id)
	{
		global $dbAdapter;

		$select = $dbAdapter->select()
								->from( array( self:TABLE_NAME, self::TABLE_NAME ) )
								->where( "id = ?", $id )
		;

		$result = $dbAdapter->query( $select )->fetch();

		return $result;
	}
```

