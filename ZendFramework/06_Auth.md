## _
```php
//メールアドレス + パスワードでチェック
$authAdapter = new Zend_Auth_Adapter_DbTable( $dbAdapter, 'users_table', 'mail_address', 'password' );
```

## __
```php
	/**
	 *
	 * @param string ログインID
	 * @param string パスワード
	 * @param int ユーザーID
	 * @return bool
	 *
	 */
	private function authenticate( $login_id, $password, &$company_id ) {
        
        //メールアドレス + パスワードでチェック
        $authAdapter = new Zend_Auth_Adapter_DbTable( $dbAdapter, 'users_table', 'mail_address', 'password' );
		// ログインID重複許可？
		$authAdapter->setAmbiguityIdentity( true );
		//ユーザーID
		$authAdapter->setIdentity( $login_id );
		//パスワード
		$authAdapter->setCredential( $this->getHashedPassword( $password ) );
		// $authAdapter->setCredentialTreatment( " ? AND (retire_date = '1900-01-01' OR retire_date >= '".date("Y-m-d")."') AND pb_login_flg ='1' AND default_login_flg='1'" );

		$result = $authAdapter->authenticate();

		if ( $result->isValid() ) {

			$company_id = $authAdapter->getResultRowObject()->company_id;
			return true;
		}
		else {

			return false;
		}
	}
```


## library\Zend\Auth\Adapter\DbTable.php
```php
    /**
     * __construct() - Sets configuration options
     *
     * @param  Zend_Db_Adapter_Abstract $zendDb If null, default database adapter assumed
     * @param  string                   $tableName
     * @param  string                   $identityColumn
     * @param  string                   $credentialColumn
     * @param  string                   $credentialTreatment
     * @return void
     */
    public function __construct(Zend_Db_Adapter_Abstract $zendDb = null, $tableName = null, $identityColumn = null,
                                $credentialColumn = null, $credentialTreatment = null)
    {
```

