## ElasticMQelasticmq
ローカルで使える SQS 互換のキュー  
https://github.com/softwaremill/elasticmq


## elasticmq : Docker hub
https://hub.docker.com/r/softwaremill/elasticmq


```yaml
  sqs:
    image: softwaremill/elasticmq
    restart: always
    ports:
      - 9324:9324
```
_____________________________________________________________________
## キューの中身を取得

queue:work 未実行で以下コマンド実行するとキューの中身取得できます。
```
aws sqs receive-message --queue-url http://localhost:9324/000000000000/asims_queue --endpoint-url http://localhost:9324
```

ShippingInstructionService::divideUploadedCsv にメッセージ送信したときのキューの中身
```json
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

______________________________________________________________________________
______________________________________________________________________________
______________________________________________________________________________
#### custom.conf
```conf
queues {
    # http://elasticmq:9324/queue/elasticmq_queue
    elasticmq_queue {
        defaultVisibilityTimeout = 10 seconds
        delay = 5 seconds
        receiveMessageWait = 0 seconds
        deadLettersQueue {
            name = "laravel-dead-letters"
            maxReceiveCount = 3
        }
    }
    # http://elasticmq:9324/elasticmq_queue/laravel-dead-letters
    elasticmq_queue-dead-letters { }
}
```

#### docker-compose.yml
```yaml
services:
  sqs:
    image: softwaremill/elasticmq
    restart: always
    ports:
      - 9324:9324
    volumes:
      - ./docker/elasticmq/conf/custom.conf://opt/elasticmq.conf:ro
    networks:
      - default
      - my-shared-network
```

______________________________________________________________________________
______________________________________________________________________________
______________________________________________________________________________
# トラブルシュート
キューを１回実行しないと、以下のようなエラーが出る。

```
   Aws\Sqs\Exception\SqsException 

  Error executing "SendMessage" on "http://sqs:9324/queue/elasticmq_queue"; AWS HTTP error: Client error: `POST http://sqs:9324/queue/elasticmq_queue` resulted in a `400 Bad Request` response:
<ErrorResponse xmlns="http://queue.amazonaws.com/doc/2012-11-05/">
      <Error>
        <Type>Sender</Type>
        <Co (truncated...)
 AWS.SimpleQueueService.NonExistentQueue (client): AWS.SimpleQueueService.NonExistentQueue; see the SQS docs. - <ErrorResponse xmlns="http://queue.amazonaws.com/doc/2012-11-05/">
      <Error>
        <Type>Sender</Type>
        <Code>AWS.SimpleQueueService.NonExistentQueue</Code>
        <Message>AWS.SimpleQueueService.NonExistentQueue; see the SQS docs.</Message>
        <Detail/>
      </Error>
      <RequestId>00000000-0000-0000-0000-000000000000</RequestId>
    </ErrorResponse>

  at vendor/aws/aws-sdk-php/src/WrappedHttpHandler.php:195
    191▕         $parts['request'] = $request;
    192▕         $parts['connection_error'] = !empty($err['connection_error']);
    193▕         $parts['transfer_stats'] = $stats;
    194▕ 
  ➜ 195▕         return new $this->exceptionClass(
    196▕             sprintf(
    197▕                 'Error executing "%s" on "%s"; %s',
    198▕                 $command->getName(),
    199▕                 $request->getUri(),

      +27 vendor frames
  28  app/Console/Commands/Test/testPivot.php:46
      App\Jobs\AbstractJob::dispatch()

      +13 vendor frames
  42  artisan:37
      Illuminate\Foundation\Console\Kernel::handle(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
/application # php artisan command:createQueue
```
※このメッセージは、worker 起動時にも発生する


#### app\Console\Commands\createSqsQueue.php
こんな感じのコードを実行する  
php artisan command:createQueue
```php
use Aws\Sqs\SqsClient;

class createSqsQueue extends Command
{
//中略
    public function handle()
    {
        $client = new SqsClient([
            'endpoint'    => config('aws.sqs_endpoint'),
            'region'      => config('aws.region'),
            'version' => "2012-11-05",
            'credentials' => [
                'key'    => config('aws.key'),
                'secret' => config('aws.secret'),
            ]
        ]);

        $queue = $client->createQueue([
            'QueueName' =>config('aws.sqs_queue'),
        ]);
        return 0;
    }
```

#### 解決策（公式）
コンフィグで何とかできる。  

#### elasticmq : readme
https://github.com/softwaremill/elasticmq#automatically-creating-queues-on-startup

#### LaravelをElasticMQ（Amazon SQS互換）と連携してみる
https://qiita.com/nia_tn1012/items/1bd60b1a3900a2b52939


#### ElasticMQのDockerコンテナ起動時にキューを自動作成する
https://tomcky.hatenadiary.jp/entry/20180413/1523616565


|  id   |  queue    |  payload                            |  attempts  |  reserved_at  |  available_at  |  created_at  |
|:------|:----------|:------------------------------------|:-----------|:--------------|:---------------|:-------------|
|  1    |  default  |  {"uuid":"05004a83-c6f5", （以下略） |  0         |  « NULL »     |  1625302485    |  1625302485  |
|  2    |  default  |  {"uuid":"ec278c58-3cef", （以下略） |  0         |  « NULL »     |  1625523028    |  1625523028  |
|  3    |  emails   |  {"uuid":"c8fdb0e8-5985", （以下略） |  0         |  « NULL »     |  1625534698    |  1625534698  |


