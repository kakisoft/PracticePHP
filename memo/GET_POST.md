```
GET と POST を同時に送信。

<form name="form_func01" id="form_func01" method="POST" action="{$thisAlias}?mm=aaaa">


```
```php

$this->sortId = MY_UTIL::escHtml($_GET['sort_id']) ?? "0";
$this->page   = is_numeric(MY_UTIL::escHtml($_GET['page']))  ? MSM_Utils_Text::escHtml($_GET['page'])  : "1";
```
