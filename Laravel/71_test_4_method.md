```php
        $this->assertEmpty($stack);
        $this->assertTrue(empty($this->stack));
        $this->assertSame('foo', $this->stack[count($this->stack)-1]);

        $this->assertEquals(true,$appVersion->isValidVersion($version));
```
