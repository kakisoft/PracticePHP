findCustomers
findxxxxxxxxx


```php
------------------------------------------------------
findCustomers
    
マジックメソッド
------------------------------------------------------
$account = new Account();

$customer = $account->findCustomers()->current();
------------------------------------------------------
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
------------------------------------------------------
```

