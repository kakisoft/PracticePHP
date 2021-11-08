```php
        $this->assertTrue($this->account->isForbiddenAccount($account, $domainId));
        $this->assertFalse($this->account->isForbiddenAccount($account, $domainId));
        $this->assertEmpty($stack);
        $this->assertSame('foo', $this->stack[count($this->stack)-1]);

        $this->assertEquals(true, $appVersion->isValidVersion($version));
```

