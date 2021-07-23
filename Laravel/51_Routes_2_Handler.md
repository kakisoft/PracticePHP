api コール時、ルーティング設定していないURLにて、特定のメッセージを表示。

## app\Exceptions\Handler.php
```php
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if( $request->is('api/*') ){
            if($exception->getStatusCode() == 404) {
                echo '{"message":"No No. Not this way"}';
                return;
            }

            // 許可されていないメソッド
            if($exception->getStatusCode() == 405) {
                $message = Question01RegistrationInformation::MESSAGE___405_ERROR;  // 405 Method Not Allowed
                echo "{\"message\":\"{$message}\"}";
                return;
            }
        }

        return parent::render($request, $exception);
    }
```

