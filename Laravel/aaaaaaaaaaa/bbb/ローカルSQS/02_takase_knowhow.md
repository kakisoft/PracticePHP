https://www.chatwork.com/#!rid201197718-1460159946032173056

queue:work 未実行で以下コマンド実行するとキューの中身取得できます。
```
aws sqs receive-message --queue-url http://localhost:9324/000000000000/asims_queue --endpoint-url http://localhost:9324
```

ShippingInstructionService::divideUploadedCsvにメッセージ送信したときのキューの中身
```
{
    "Messages": [
        {
            "MessageId": "911b0e63-c84f-45ab-a745-3ee747426c7a",
            "ReceiptHandle": "911b0e63-c84f-45ab-a745-3ee747426c7a#a42986c1-f01a-4a32-a60a-bb2f13593a4f",
            "MD5OfBody": "efbe462f1396f95587435fb1a81c16e8",
            "Body": "{\"uuid\":\"582414a9-b608-4dcf-b803-14eaa7e2ef50\",\"displayName\":\"App\\\\Jobs\\\\ShippingInstruction\\\\ShippingInstructionCsvImportJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":3,\"backoff\":\"30\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\ShippingInstruction\\\\ShippingInstructionCsvImportJob\",\"command\":\"O:60:\\\"App\\\\Jobs\\\\ShippingInstruction\\\\ShippingInstructionCsvImportJob\\\":14:{s:12:\\\"\\u0000*\\u0000receiptNo\\\";i:7;s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";i:3;s:7:\\\"backoff\\\";i:30;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}"
        }
    ]
}
```

____________________________________________________________________________________________________________________________________
____________________________________________________________________________________________________________________________________
____________________________________________________________________________________________________________________________________
## コンテナの外で実行

```
aws sqs receive-message --queue-url http://localhost:9324/000000000000/asims_queue --endpoint-url http://localhost:9324
```

You must specify a region. You can also configure your region by running "aws configure".


