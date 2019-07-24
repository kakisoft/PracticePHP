
```php
<?php
use \AspectMock\Test as test;
use PHPUnit\Framework\TestCase;
class AccountTest extends TestCase
{
    public function setUp()
    {
        $this->account = new Account;
        parent::setUp();
    }

    public function tearDown()
    {
        test::clean();
    }

    public function testIsForbiddenAccount()
    {
        // 禁止アカウント
        $account = 'chk';
        $domainId = '420';

        $this->assertTrue($this->account->isForbiddenAccount($account, $domainId));
    }

    public function testIsForbiddenAccountOK()
    {
        // Not 禁止アカウント
        $account = 'chk';
        $domainId = '440'; 

        $this->assertFalse($this->account->isForbiddenAccount($account, $domainId));

        // $this->assertEquals(0, Plan::fixFileLimitByStartAt(Plan::ENTERPRIZE, 1000000));
        // $this->assertEquals(1, $this->client->getVersion());
        // $this->assertEquals(16, strlen($password));

        // // 半角英字(小文字)が含まれること
        // $this->assertRegExp('/[a-z]/', $password);

        // // 半角英字(大文字)が含まれること
        // $this->assertRegExp('/[A-Z]/', $password);

        // // 半角数字が含まれること
        // $this->assertRegExp('/[0-9]/', $password);

        // // 記号( - または _ )が含まれること
        // $this->assertRegExp('/[-_]/', $password);

        
        // $this->assertEmpty($stack);        

    }
}

```
