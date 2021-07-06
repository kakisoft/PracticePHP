## Amazon SQS でのキューの使用AWSSDK for PHP バージョン 3
https://docs.aws.amazon.com/ja_jp/sdk-for-php/v3/developer-guide/sqs-examples-using-queues.html


#### app\Console\Commands\Test\createSqsQueue.php
```php
namespace App\Console\Commands\Test;

use Aws\Sqs\SqsClient;
use Illuminate\Console\Command;

class createSqsQueue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:createQueue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
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
}
```
