<?php
namespace kakisoft_utils_02;

/**
 *
 */
class MyFileGetContentsUtil
{
    // ↓みたいな書き方だど、スコープを publicにしないと __set でアクセスできないみたいだぞ。すっごいイケてない。時期バージョンで修正されてくんないかな。とりあえずこのままにしとく。
    public $timeout = 3;
    public function __get($name){}
    public function __set($name, $value){}

    public function __construct()
    {
    }

    //--------------------------------------------------------------
    //
    //--------------------------------------------------------------
    private $response_status_code;
    public function getStatusCode()
    {
        return $this->response_status_code;
    }


    /**
     * Create and send an HTTP request.
     *
     * @param string  $method      HTTP method
     * @param string  $target_url  URI object or string.
     * @param array   $params
     * 
     */
    public function request( $method, $target_url, $params=array() )
    {
        $this->response_status_code = null;

        // URLエンコードされたクエリ文字列を生成する
        $query_string = http_build_query($params);

        // HTTP設定
        $options = array (
        'http' => array (
            'method'           => $method,
            'timeout'          => $this->timeout,  // タイムアウト時間
            'header'           => 'Content-type: application/x-www-form-urlencoded',
            'content'          => $query_string,
            'ignore_errors'    => true,    // false にすると、400/500 が返ってくるとエラーが発生する
            'protocol_version' => '1.1'
            ),
        'ssl' => array (
            'verify_peer'      => false,
            'verify_peer_name' => false
            )
        );
        $getted_contents = file_get_contents($target_url, false, stream_context_create($options));
        $this->setPropResponseStatusCode($http_response_header);

        return $getted_contents;
    }

    /**
     * Array( [0]=> HTTP/1.1 200 OK ) ・・・という感じのイケてない HTTPレスポンスステータスから、数値部分のみを抽出
     *
     * @param string  $http_response_header
     */
    private function setPropResponseStatusCode($http_response_header)
    {
        // $http_response_header は、ローカルスコープで作成されるみたい。（そのため、引数として受け取っている）
        $response_status_status = $http_response_header[0];
        $separated_params = explode(' ', $response_status_status);
        $response_status_code = $separated_params[1];
        $this->response_status_code = $response_status_code;

        return true;
    }

}
