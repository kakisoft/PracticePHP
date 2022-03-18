

PHPStan
https://qiita.com/ngmy/items/1a8ef21c76d74c1d4dfe
vendor/bin/phpstan analyse src


Guzzle クライアントを使う


use GuzzleHttp\Client;



```php
    use GuzzleHttp\Client;

    /**
     * 帳票レンダリングAPIコール
     */
    public function callApi()
    {
        $url = $this->getTargetUrl();
        $headers['Authorization'] = "token {$this->token}";
        $headers['Content-Type'] = 'application/json';
        $options = [
            'http_errors' => false,
            'headers'     => $headers,
            'body'        => $this->entityJson
        ];
        $client = new Client();
        return $client->request('POST', $url, $options);
    }
```
この状態で静的解析をかけると、以下のようになる。  

```
Method App\Docurain\DocurainBase::callApi() has no return typehint specified.
```

という事で、戻り値の型と PHP Document を追加。  


```php
    use GuzzleHttp\Client;

    /**
     * 帳票レンダリングAPIコール
     *
     * @return Psr\Http\Message\ResponseInterface;
     */
    public function callApi(): ResponseInterface
    {
        $url = $this->getTargetUrl();
        $headers['Authorization'] = "token {$this->token}";
        $headers['Content-Type'] = 'application/json';
        $options = [
            'http_errors' => false,
            'headers'     => $headers,
            'body'        => $this->entityJson
        ];
        $client = new Client();
        return $client->request('POST', $url, $options);
    }
```

戻り値は GuzzleHttp\Client の request メソッドの戻り値なので、それを適用しました。  

ちなみに、以下のようなコードでした。
```php
    /**
     * Create and send an HTTP request.
     *
     * Use an absolute path to override the base path of the client, or a
     * relative path to append to the base path of the client. The URL can
     * contain the query string as well.
     *
     * @param string              $method  HTTP method.
     * @param string|UriInterface $uri     URI object or string.
     * @param array               $options Request options to apply. See \GuzzleHttp\RequestOptions.
     *
     * @throws GuzzleException
     */
    public function request(string $method, $uri = '', array $options = []): ResponseInterface
    {
        $options[RequestOptions::SYNCHRONOUS] = true;
        return $this->requestAsync($method, $uri, $options)->wait();
    }
```
このメソッドの戻り値の型が「ResponseInterface」なので、こいつをそのまま戻り値として使っているメソッドも同様だろう。  
と考え、ResponseInterface を指定していました。  

すると今度は静的解析の時に妙なメッセージが出てきました。  

```
> ./vendor/bin/phpstan analyze --memory-limit=1024M

 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------ 
  Line   Docurain/DocurainBase.php                                                                                                                                   
 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------ 
  122    PHPDoc tag @return with type App\Docurain\Psr\Http\Message\ResponseInterface is not subtype of native type Psr\Http\Message\ResponseInterface.              
  122    Return typehint of method App\Docurain\DocurainBase::callApi() has invalid type App\Docurain\Psr\Http\Message\ResponseInterface.                            
  141    Parameter $resposeData of method App\Docurain\DocurainBase::handleResposeData() has invalid typehint type App\Docurain\Psr\Http\Message\ResponseInterface.  
  143    Call to method getStatusCode() on an unknown class App\Docurain\Psr\Http\Message\ResponseInterface.                                                         
         💡 Learn more at https://phpstan.org/user-guide/discovering-symbols                                                                                          
  144    Call to method getStatusCode() on an unknown class App\Docurain\Psr\Http\Message\ResponseInterface.                                                         
 ------ ------------------------------------------------------------------------------------------------------------------------------------------------------------ 

 ------ --------------------------------------------------------------------------------------------------------------------------------------------- 
  Line   Docurain/Estimate.php                                                                                                                        
 ------ --------------------------------------------------------------------------------------------------------------------------------------------- 
  62     Parameter #1 $resposeData of method App\Docurain\DocurainBase::handleResposeData() expects App\Docurain\Psr\Http\Message\ResponseInterface,  
         Psr\Http\Message\ResponseInterface given.                                                                                                    
 ------ --------------------------------------------------------------------------------------------------------------------------------------------- 

```
どうも、ResponseInterface が悪いみたい。  
うーん。GuzzleHttp\Client ライブラリの真似をしたのに。  

それなら、インターフェースを実装した型とかを使えばいいのだろうか。  
と言うことで、request メソッドの戻り値の型を調べてみました。  


```php
    $target = $client->request('POST', $url, $options);

    //-----( class name )-----
    $target_class = get_class($target);
    echo "class name:"        . PHP_EOL;
    echo "  {$target_class}"  . PHP_EOL . PHP_EOL;
```

```
class name:
  GuzzleHttp\Psr7\Response
```

と言うことで、クラスが「GuzzleHttp\Psr7\Response」と判明したので、それを適用。

```php
    /**
     * 帳票レンダリングAPIコール
     *
     * @return GuzzleHttp\Psr7\Response;
     */
    public function callApi(): Response
    {
        $url = $this->getTargetUrl();
        $headers['Authorization'] = "token {$this->token}";
        $headers['Content-Type'] = 'application/json';
        $options = [
            'http_errors' => false,
            'headers'     => $headers,
            'body'        => $this->entityJson
        ];
        $client = new Client();
        return $client->request('POST', $url, $options);
    }
```

