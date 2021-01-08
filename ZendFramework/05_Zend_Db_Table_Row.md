
```php
public function sendSuspendMail()
{
    $account = Phake::mock('Account');
    $customer = new Zend_Db_Table_Row(array(
                'data' => array(
                'backend_type' => '1',
                'account_state' => '1',
                'account' => 'foo',
                'test_period_date' => '2019-08-31',
                'family_name' => 'foo',
            )
        ));
    $account->setRow($customer);
    $customer = new Customer();
    $customer->family_name = 'YAMADA';
    $customer->first_name  = 'TARO';
    $customer->mail        = 'testmail01@pepabo.com';
          
    return parent::sendSuspendMail($account, '', $customer);
}
```


```php
$account = new Zend_Db_Table_Row(
                                    array(    'data' => array( 'account' => 'test_account'
                                            , 'sub_domain_name' => 'test_domain_name', ) 
                                          )
                                 );
```



```php
class Accounts extends Zend_Db_Table_Abstract
{
    protected $_name    = 't_account';
    protected $_primary = 'account_id';

    protected $_dependentTables = array(
        'Conts',
        'Moves',
        'Domains',
        'Mls',
        'Mms',
        'Procmails',
        'Osaipos',
        'Customers',
        'FtpSubaccounts',
        'Databases',
        'FmsLogs',
        'CfLogs',
        'Inquiries',
        'Maillogs',
        'Affiliates',
        'Crons',
        'Services',
        'Warnings',
        'AdwordsCoupon',
        'CampaignPresentDomains',
    );

    protected $_referenceMap = array(
        'Users' => array(
            'columns'       => 'user_server_id',
            'refTableClass' => 'Servers',
            'refColumns'    => 'server_id'
        )
    );
}
```