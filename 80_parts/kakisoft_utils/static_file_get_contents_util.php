<?php
namespace kakisoft_utils_01;

/**
 *
 */
class MyStaticFileGetContentsUtil
{
    static private $response_status_code;
    static public function getResponseHttpStatusCode()
    {
        return self::$response_status_code;
    }

    //--------------------------------------------------------------
    //
    //--------------------------------------------------------------
    public static function requestByPost( $target_url, $params=array() )
    {
        self::$response_status_code = null;

        // URLエンコードされたクエリ文字列を生成する
        $query_string = http_build_query($params);

        // HTTP設定
        $options = array (
        'http' => array (
            'method' => 'POST',
            'timeout' => 3, // タイムアウト時間
            // 'header' => 'Content-type: application/x-www-form-urlencoded',
            // 'content' => $query_string,
            'ignore_errors' => true,     // false にすると、400/500 が返ってくるとエラーが発生する
            // 'protocol_version' => '1.1'
            ),
        'ssl' => array (
            'verify_peer' => false,
            'verify_peer_name' => false
            )
        );
        $getted_contents = file_get_contents($target_url, false, stream_context_create($options));
        self::setResponseHttpStatusCode($http_response_header);

        return $getted_contents;
    }


    //--------------------------------------------------------------
    //
    //--------------------------------------------------------------
    // Array( [0]=> HTTP/1.1 200 OK ) ・・・という感じのイケてない HTTPレスポンスステータスから、数値部分のみを抽出
    private static function setResponseHttpStatusCode($http_response_header)
    {
        // $http_response_header は、ローカルスコープで作成されるみたい。（そのため、引数として受け取っている）
        $response_status_status = $http_response_header[0];
        $separated_params = explode(' ', $response_status_status);
        $response_status_code = $separated_params[1];
        self::$response_status_code = $response_status_code;

        return true;
    }

}
