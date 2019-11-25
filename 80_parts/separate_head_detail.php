<?php

$response_data = getRecordData();
$result = getFormattedRecordData($response_data);

print_r($result);



//=================================
//
//=================================
function getFormattedRecordData($response_data)
{
    $formattedResponseData = array();


    $header_array = array();
    $break_key = "";
    foreach ($response_data as $el) {
        // カテゴリ
        if( $break_key != $el['category_id'] ){

            $header_array = array(
                'category_id'    => $el['category_id'],
                'category_name'                => $el['category_name'],
                'detail_array'                 => array()
              );

            array_push($formattedResponseData, $header_array);
        }
        $break_key = $el['category_id'];

        // 明細
        $detail_array_contents = array();
        $detail_array_contents['detail_id']      = $el['detail_id'];
        $detail_array_contents['detail_name']    = $el['detail_name'];
        $detail_array_contents['selected_value'] = $el['selected_value'];

        // $formattedResponseData[count($formattedResponseData)-1]['detail_array'][] = $detail_array_contents;
        $formattedResponseData[array_key_last($formattedResponseData)]['detail_array'][] = $detail_array_contents;

        var_dump(array_key_last($formattedResponseData));
    }


    return $formattedResponseData;
}


//=================================
//
//=================================
function getRecordData()
{
    $return_array = [];

    $content01 = array();
    $content01['category_id']   = "1";
    $content01['category_name'] = "大分類１";
    $content01['detail_id']      = "1001";
    $content01['detail_name']    = "大分類１の項目１";
    $content01['selected_value'] = "a1";
    array_push($return_array, $content01);

    $content02 = array();
    $content02['category_id']   = "1";
    $content02['category_name'] = "大分類１";
    $content02['detail_id']      = "1002";
    $content02['detail_name']    = "大分類１の項目２";
    $content02['selected_value'] = "a2";
    array_push($return_array, $content02);

    $content03 = array();
    $content03['category_id']   = "1";
    $content03['category_name'] = "大分類１";
    $content03['detail_id']      = "1003";
    $content03['detail_name']    = "大分類１の項目３";
    $content03['selected_value'] = "a3";
    array_push($return_array, $content03);

    $content04 = array();
    $content04['category_id']   = "2";
    $content04['category_name'] = "大分類２";
    $content04['detail_id']      = "2001";
    $content04['detail_name']    = "大分類２の項目１";
    $content04['selected_value'] = "b1";
    array_push($return_array, $content04);

    $content05 = array();
    $content05['category_id']   = "2";
    $content05['category_name'] = "大分類２";
    $content05['detail_id']      = "2002";
    $content05['detail_name']    = "大分類２の項目２";
    $content05['selected_value'] = "b2";
    array_push($return_array, $content05);

    $content06 = array();
    $content06['category_id']   = "3";
    $content06['category_name'] = "大分類３";
    $content06['detail_id']      = "3001";
    $content06['detail_name']    = "大分類３の項目１";
    $content06['selected_value'] = "c1";
    array_push($return_array, $content06);

    return $return_array;
}


//=========================================================================================
//=========================================================================================
//=========================================================================================

/*

Array
(
    [0] => Array
        (
            [category_id] => 1
            [category_name] => 大分類１
            [detail_array] => Array
                (
                    [0] => Array
                        (
                            [detail_id] => 1001
                            [detail_name] => 大分類１の項目１
                            [selected_value] => a1
                        )

                    [1] => Array
                        (
                            [detail_id] => 1002
                            [detail_name] => 大分類１の項目２
                            [selected_value] => a2
                        )

                    [2] => Array
                        (
                            [detail_id] => 1003
                            [detail_name] => 大分類１の項目３
                            [selected_value] => a3
                        )

                )

        )

    [1] => Array
        (
            [category_id] => 2
            [category_name] => 大分類２
            [detail_array] => Array
                (
                    [0] => Array
                        (
                            [detail_id] => 2001
                            [detail_name] => 大分類２の項目１
                            [selected_value] => b1
                        )

                    [1] => Array
                        (
                            [detail_id] => 2002
                            [detail_name] => 大分類２の項目２
                            [selected_value] => b2
                        )

                )

        )

    [2] => Array
        (
            [category_id] => 3
            [category_name] => 大分類３
            [detail_array] => Array
                (
                    [0] => Array
                        (
                            [detail_id] => 3001
                            [detail_name] => 大分類３の項目１
                            [selected_value] => c1
                        )

                )

        )

)


*/