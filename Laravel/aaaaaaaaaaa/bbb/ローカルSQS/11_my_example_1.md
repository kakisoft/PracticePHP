PS C:\kaki\BBP\ASIMS3\hapi_docker\application\asims\sources> aws sqs receive-message --queue-url http://localhost:9324/000000000000/asims_queue --endpoint-url http://localhost:9324

You must specify a region. You can also configure your region by running "aws configure".


_____________________________________________________________________________________________
# ログインした後
コンテナの外で実行
```
aws sqs receive-message --queue-url http://localhost:9324/000000000000/asims_queue --endpoint-url http://
```


```
{ 
    "Messages": [
        {
            "MessageId": "edb6256a-5097-425b-824d-f85020f7f46f",
            "ReceiptHandle": "edb6256a-5097-425b-824d-f85020f7f46f#442175a6-b0fd-40cf-a275-5017d8d7846a",
            "MD5OfBody": "dc0d9f32c75d1e4c3215a309aefe3462",
            "Body": "{\"uuid\":\"f773fed1-2152-48b4-960e-d9eedd4a61cc\",\"displayName\":\"App\\\\Jobs\\\\Item\\\\ItemCsvCreateJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":3,\"backoff\":\"30\",\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\Item\\\\ItemCsvCreateJob\",\"command\":\"O:30:\\\"App\\\\Jobs\\\\Item\\\\ItemCsvCreateJob\\\":13:{s:12:\\\"\\u0000*\\u0000receiptNo\\\";i:1;s:5:\\\"tries\\\";N;s:13:\\\"maxExceptions\\\";i:3;s:7:\\\"backoff\\\";i:30;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}"
        }
    ]
}
```

