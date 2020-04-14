https://pear.php.net/package/HTTP_Request2

<?php
/*

$url = $this->_api_url . "/template/{$key}";
$json = HttpClientUtils::getJson($url);

*/


    // SSL対応版
    static function getJson( $url ) {

        $request = new HTTP_Request2();

        try {

                $request->setUrl( $url );
                $options = array(

                                     'ssl_verify_peer' => false,
                                     'ssl_verify_host' => true,
                                     // HTTP/Request2.phpを拡張したオプション、標準では存在しない。
                                     'request_proxy'   => 'tls'
                                 );

                $request->setConfig($options);
                $request->setMethod(HTTP_Request2::METHOD_GET);

                $request->setHeader('Content-type', 'application/json');
                $request->setHeader('Accept', 'application/json');

                $res = $request->send();

                switch( $res->getStatus() ) {
                    case 200:
                        return $res->getBody();
                    case 204:
                        return null;
                    // 20*ステータス以外は全てエラー判断
                    default:
                        throw new RuntimeException('RestFull Request Error : ' . $res->getStatus() . " :: " . $url);
                }
        }
        catch( Exception $e ) {
            throw $e;
        }
    }



