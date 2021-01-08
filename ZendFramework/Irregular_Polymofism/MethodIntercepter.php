<?php
require_once(APPLICATION_PATH."/common/define.inc.php");
require_once(APPLICATION_PATH."/models/log.php");

/**
 *
 *
 */
class MethodIntercepter {

    private $_instance;
    private static $_className;
    private $_logger;

    public function __construct($instance) {
        $this->_instance = $instance;
        $ref = new ReflectionClass($instance);
        self::$_className = $ref->getName();
    }

    /**
     * 
     * @param unknown $method
     * @param unknown $arguments
     * @return mixed
     */
    public function __call($method, $arguments) {
    	$result = null;

        return $result;
    }

    /**
     * 
     * @param unknown $method
     * @param unknown $arguments
     * @return mixed
     */
    public static function __callStatic($method, $arguments) {
        $result = null;

        return $result;
    }

    public function __get($key) {

        return $this->_instance->$key;
    }

    public function __set($key, $value) {

        $this->_instance->$key = $value;
    }

    /**
     *
     * 共通ログ書き込みクラス
     *
     * @param type $logger_memo ログメッセージ
     * @param type $operation_type
     * @return void
     *
     */
    private static function _logger($logger_memo="",$operation_type = ""){

    }
}
?>