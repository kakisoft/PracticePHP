
```php
use App\Facades\GlobalParams;
use App\Facades\SysLogger;


// デバッグ
SysLogger::apiDebugOutput('0100300001', GlobalParams::getAuthorId(), [get_class($this), __FUNCTION__]);

// info
SysLogger::backendInfoOutput('0300300002', GlobalParams::getAuthorId(), [$targetCommandName]);

// Error
SysLogger::backendErrorOutput('0300300004', GlobalParams::getAuthorId(), [$targetCommandName]);

// Exception
SysLogger::backendErrorOutput('0300300106', GlobalParams::getAuthorId(), [$e->getMessage()]);
```

________________________________________________________________________________________________________________________
## backlog
まずはこれを。
https://bwave.backlog.com/wiki/BBP/%E6%88%90%E6%9E%9C%E7%89%A9%2F%E9%96%8B%E7%99%BA%2F%E9%96%8B%E7%99%BA%E3%83%AB%E3%83%BC%E3%83%AB


=====================================================================================================================
Debug       分岐の確認ができる内容
---------------------------------------------------------------------------------------------------------
Info        定時処理の開始/終了
---------------------------------------------------------------------------------------------------------
Notice      廃止
---------------------------------------------------------------------------------------------------------
Warning	    n分以内にn回以上発生した時点で対応が必要になる場合	営業時間内のみ対応
            処理は完了するが問題があるもの    例：バッチ処理の経過時間がしきい値超過・取込処理で取込自体は完了するがエラーがあるなど
---------------------------------------------------------------------------------------------------------
Error       1回発生した時点で対応が必要になる場合    営業時間内のみ対応
            処理が止まってしまうようなエラー    例：出荷指示取込時に指定された商品が存在せず取り込めなかった
---------------------------------------------------------------------------------------------------------
Critical    n分以内にn回以上発生した時点で対応が必要になる場合	即時対応
---------------------------------------------------------------------------------------------------------
Alert       廃止

=====================================================================================================================


### (1)スプレッドシートにメッセージを追記
メッセージを追記するなら、必ずソース編集前にここを使う。

■ASIMS
https://docs.google.com/spreadsheets/d/1CoP8DdTBzQLhqYgO0lYYseb6g2c6oJVwJiQgJle6iSU/edit#gid=1958456751

■はぴロジ
https://docs.google.com/spreadsheets/d/1nMrCOxxmt8blTVY6WoCGZ5AG4456dQu-qj0PLFyzgGE/edit#gid=555882575

メッセージ一覧シートに追記してください。


大項目ID、中項目ID、小項目ID があるので、それを確認。


## config/logmessage.php
```php
<?php
/**
 * [sample]
 * 'info' => [
 *      '00001' => 'test message',
 *  ],
 * 'notice' => [],
 */
return [
    'info' => [
        '0499900001' => 'An error has occurred on the front side. :?',
    ],
    'notice' => [],
    'warning' => [
        '0200300001' => 'Failed to send to fluentd.',
        '0499900001' => 'An error has occurred on the front side. :?',
    ],
    'error' => [
        '0100300001' => 'Inbound record service accept import now stock taking.',
        '0100300002' => 'Inbound record service accept import invalid payload.',
        '0100300003' => 'Inbound record service accept import payload is not array.',
        '0100300004' => 'Inbound record service accept import exceed header limit. receipt_no:?',
        '0100300005' => 'Inbound record service capture status inquiry receiptNo not found. receipt_no:?',
        '0100300006' => 'Shipment record service accept import now stock taking.',
        '0100300007' => 'UnShipment record service accept import invalid payload.',
        '0100300008' => 'UnShipment record service accept import payload is not array.',
        '0100300009' => 'UnShipment record service accept import exceed header limit. recei
```


## app\Facades\Logger.php
Info 用、warning 用、各メソッドが用意されているので、それを使う。
```php
    public function webInfoOutput(
        string $messageKey,
        int $userId = 0,
        array $replace = [],
        string $replaceKey = '?'
    ) {
        return $this->outputLog(self::LOG_LEVEL_INFO, $messageKey, $this->systemTypeWeb, $userId, $replace, $replaceKey);
    }

    /**
     * Web処理上でのnoticeログを出力する
     *
     * @param string $messageKey
     * @param int    $userId
     * @param array  $replace
     * @param string $replaceKey
     *
     * @return bool
     */
    public function webNoticeOutput(
        string $messageKey,
        int $userId = 0,
        array $replace = [],
        string $replaceKey = '?'
    ) {
        return $this->outputLog(self::LOG_LEVEL_NOTICE, $messageKey, $this->systemTypeWeb, $userId, $replace, $replaceKey);
    }
```

