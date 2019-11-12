## 別アクションへフォワード する ( _forward )
http://hensa40.cutegirl.jp/archives/3005

```php
$this->_forward('test'); 

    public function testAction()
    {
        // パラメータを取得
        $prm = 'param = ' . $this->_request->getParam('param');
        $this->_msg .= 'testAction:' . $prm;
 
        echo "testAction end" . $this->_msg;
    }
```






