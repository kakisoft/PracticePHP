<?php

$entity_array = [];

//// ヘッダ
$estimateHeader["流機住所"] = "〒108-0073 東京都港区三田３丁目４－２ いちご聖坂ビル";
$estimateHeader["流機連絡先"] = "TEL：03-3452-7400（代表） FAX：03-3452-5370";
$estimateHeader["得意先名称"] = "株式会社サンプルカンパニー　御中";
$estimateHeader["見積No"] = "202203110001";
$estimateHeader["見積日"] = "2022/03/11";
$estimateHeader["案件名"] = "受注した案件の名称001";
$estimateHeader["営業担当"] = "流機　太郎e";
$estimateHeader["合計金額"] = "55250";
$estimateHeader["納入場所"] = "御社玄関前";
$estimateHeader["納入期限"] = "ご下命後三カ月";
$estimateHeader["支払条件"] = "御社規定支払い";
$estimateHeader["有効期限"] = "2022/03/31";
$estimateHeader["見積種別"] = "販売";
$estimateHeader["明細"] = [];
// 明細1
$estimateDetail["品名および仕様"] = "Test1";
$estimateDetail["数量"] = "2車";
$estimateDetail["単位"] = "140ヶ月";
$estimateDetail["単価（税抜）"] = 40000;
$estimateDetail["金額（税込）"] = 2800000;
$estimateDetail["備考"] = "備考1";
array_push($estimateHeader["明細"], $estimateDetail);
// 明細2
$estimateDetail["品名および仕様"] = "Test2";
$estimateDetail["数量"] = "1式";
$estimateDetail["単位"] = "-";
$estimateDetail["単価（税抜）"] = 20000;
$estimateDetail["金額（税込）"] = 22000;
$estimateDetail["備考"] = "備考2";
array_push($estimateHeader["明細"], $estimateDetail);
// 明細3
$estimateDetail["品名および仕様"] = "Test3";
$estimateDetail["数量"] = "3個";
$estimateDetail["単位"] = "10ヶ月";
$estimateDetail["単価（税抜）"] = 10000;
$estimateDetail["金額（税込）"] = 33000;
$estimateDetail["備考"] = "備考3";
array_push($estimateHeader["明細"], $estimateDetail);

$entity_array["見積書"] = [];
array_push($entity_array["見積書"], $estimateHeader);




/*

$entity_array["見積書"][0]["流機住所"] = "〒108-0073 東京都港区三田３丁目４－２ いちご聖坂ビル";
$entity_array["見積書"][0]["流機連絡先"] = "TEL：03-3452-7400（代表） FAX：03-3452-5370";
$entity_array["見積書"][0]["得意先名称"] = "株式会社サンプルカンパニー　御中";
$entity_array["見積書"][0]["見積No"] = "202203110001";
$entity_array["見積書"][0]["見積日"] = "2022/03/11";
$entity_array["見積書"][0]["案件名"] = "受注した案件の名称001";
$entity_array["見積書"][0]["営業担当"] = "流機　太郎e";
$entity_array["見積書"][0]["合計金額"] = "55250";
$entity_array["見積書"][0]["納入場所"] = "御社玄関前";
$entity_array["見積書"][0]["納入期限"] = "ご下命後三カ月";
$entity_array["見積書"][0]["支払条件"] = "御社規定支払い";
$entity_array["見積書"][0]["有効期限"] = "2022/03/31";
$entity_array["見積書"][0]["見積種別"] = "販売";
$entity_array["見積書"][0]["明細"][0]["品名および仕様"] = "Test1";
$entity_array["見積書"][0]["明細"][0]["数量"] = "2車";
$entity_array["見積書"][0]["明細"][0]["単位"] = "140ヶ月";
$entity_array["見積書"][0]["明細"][0]["単価（税抜）"] = 40000;
$entity_array["見積書"][0]["明細"][0]["金額（税込）"] = 2800000;
$entity_array["見積書"][0]["明細"][0]["備考"] = "備考1";
$entity_array["見積書"][0]["明細"][1]["品名および仕様"] = "Test2";
$entity_array["見積書"][0]["明細"][1]["数量"] = "1式";
$entity_array["見積書"][0]["明細"][1]["単位"] = "-";
$entity_array["見積書"][0]["明細"][1]["単価（税抜）"] = 20000;
$entity_array["見積書"][0]["明細"][1]["金額（税込）"] = 22000;
$entity_array["見積書"][0]["明細"][1]["備考"] = "備考2";
$entity_array["見積書"][0]["明細"][2]["品名および仕様"] = "Test3";
$entity_array["見積書"][0]["明細"][2]["数量"] = "3個";
$entity_array["見積書"][0]["明細"][2]["単位"] = "10ヶ月";
$entity_array["見積書"][0]["明細"][2]["単価（税抜）"] = 10000;
$entity_array["見積書"][0]["明細"][2]["金額（税込）"] = 33000;
$entity_array["見積書"][0]["明細"][2]["備考"] = "備考3";

*/


$entity_json = json_encode($entity_array);

// var_dump($entity_array);
print_r($entity_array);
// print_r($entity_json);


