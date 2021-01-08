<?php
namespace kakisoft_utils_03;

/**
 *
 */
class MyStaticMiscUtil
{

    /**
     * 全角Trim
     *
     * @param String  $str  target string
     */
    public static function mb_trim($str) {
        // $str = preg_replace('#^[ 　]+#u', '', $str);     // 「/」 でなく 「#」で代用可
        // $str = preg_replace('#[ 　]+$#u', '', $str);
        $str = preg_replace('/^[ 　]+/u', '', $str);
        $str = preg_replace('/[ 　]+$/u', '', $str);
        return $str;
    }


    /**
     * 以下を削除
     * 　・左右の半角空白および全角空白
     * 　・タブ
     * 　・改行
     *
     * @param String  $str  target string
     */
    public static function sharpen($str) {
        // htmlspecialchars($str, ENT_QUOTES);
        $str = preg_replace('/\r?\n/u', ' ', $str);
        $str = preg_replace('/\t+/u', ' ', $str);
        $str = preg_replace('/^[ 　]+/u', '', $str);
        $str = preg_replace('/[ 　]+$/u', '', $str);
        return $str;
    }


     /**
     *  第１引数にて指定した連想配列から、「第２引数のキー、第３引数の値」に対応する、第４引数のキーの値を取得する。
     *  
     *＜例＞
     *第１引数（$target_array） : 
     * Array
     * (
     *     [0] => Array
     *         (
     *             [detail_id] => 1
     *             [category_id] => 10
     *             [category_name] => '缶'
     *         )
     *     [1] => Array
     *         (
     *             [detail_id] => 2
     *             [category_id] => 11
     *             [category_name] => 'ビン'
     *         )
     * )
     * 
     *  第２引数（$target_keys_name） : "detail_id"
     *  第３引数（$target_keys_val）    : 2 
     *  第３引数（$value_of_you_want_keys_name） : "category_name"
     * 
     * 
     *  戻り値：'ビン'
     * 
     * */
    public static function getRelativeValueFromTargetList($target_array, $target_keys_name, $target_keys_val, $value_of_you_want_keys_name) {

        foreach($target_array as $value){
            if($value[$target_keys_name] === $target_keys_val) {
                return $value[$value_of_you_want_keys_name];
            }
        }

        return null;
    }

}