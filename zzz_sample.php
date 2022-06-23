<?php


$doc = new DOMDocument();
$doc->loadXML('<root><node/></root>');
echo $doc->saveXML();

// $urlParam = "tenantCd=B096&shopCd=88888SGHIJlEW";
// $urlEncodedParam = mb_convert_encoding($urlParam, 'SJIS');
// echo md5($urlEncodedParam) . PHP_EOL;
// //=> b63135c20cc945a96698c9183667266d




// // $mbie = mb_internal_encoding();
// // var_dump($mbie);  //=> UTF-8


// $lastName = 'tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎mXCTpnoA';
// $encodedLastName = mb_convert_encoding($lastName, 'SJIS');
// // echo rawurlencode($encodedLastName) . PHP_EOL;
// // echo urlencode($encodedLastName) . PHP_EOL;

// // $urlEncodedParam = urlencode($encodedLastName);
// echo hash('md5',$urlEncodedParam) . PHP_EOL;


// // $urlEncodedParam = "tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=%91%BE%98YmXCTpnoA";

// echo $urlEncodedParam . PHP_EOL;
// // $a1 = urlencode('abc_defああああ');
// //=> %91%BE%98Y

// // $hashedParam = "";
// // $hashedParam = "";

// // echo md5('val1') . PHP_EOL;
// // echo hash('md5','val1') . PHP_EOL;

// echo md5($urlEncodedParam) . PHP_EOL;
// echo hash('md5',$urlEncodedParam) . PHP_EOL;


// // $lastName = "太郎";
// // // $str = "tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎 mXCTpnoA"
// // $lastName = mb_convert_encoding($lastName, "SJIS");


// // echo rawurlencode($lastName) . PHP_EOL;




// // // UTF-8の文字列をSJISに変換
// // $utf8Str = "太郎";
// // $sjisStr = mb_convert_encoding($utf8Str, 'SJIS', 'UTF-8');

// // var_dump($sjisStr);


// // 「%91%BE%98Y」


// // echo md5('val1') . PHP_EOL;
// // echo hash('md5','val1') . PHP_EOL;

// // echo md5('tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎 mXCTpnoA') . PHP_EOL;

// // echo md5('tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎mXCTpnoA') . PHP_EOL;
// // echo hash('md5','tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎mXCTpnoA') . PHP_EOL;

// // $utf8Str = "太郎";
// // $sjisStr = mb_convert_encoding($utf8Str, 'SJIS', 'UTF-8');
// // // $sjisStr = mb_convert_encoding($utf8Str, 'SJIS', 'SJIS');
// // echo $sjisStr;


// // echo rawurlencode('太郎');


// // //=====================================================================
// // // https://qiita.com/KaiShoya/items/d335accbd5e995d9eb23
// // echo mb_convert_encoding('太郎', 'SJIS') . PHP_EOL;
// // echo mb_convert_encoding('太郎', 'SHIFT-JIS') . PHP_EOL;
// // echo mb_convert_encoding('太郎', 'Shift_JIS') . PHP_EOL;
// // echo mb_convert_encoding('太郎', 'CP932') . PHP_EOL;
// // echo mb_convert_encoding('太郎', 'MS932') . PHP_EOL;
// // echo mb_convert_encoding('太郎', 'MS_Kanji') . PHP_EOL;
// // echo mb_convert_encoding('太郎', 'Windows-31J') . PHP_EOL;
// // echo mb_convert_encoding('太郎', 'SJIS-win') . PHP_EOL;
// // //=====================================================================


// /*

// パラメータと認証鍵の間には半角スペースは必要ございません。
// tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎mXCTpnoA
// をmd5でハッシュ化しますと「b63135c20cc945a96698c9183667266d」なることを改めて確認しております。


// */


// // $entity_array = [];

// // //// ヘッダ
// // $estimateHeader["流機住所"] = "〒108-0073 東京都港区三田３丁目４－２ いちご聖坂ビル";
// // $estimateHeader["流機連絡先"] = "TEL：03-3452-7400（代表） FAX：03-3452-5370";
// // $estimateHeader["得意先名称"] = "株式会社サンプルカンパニー　御中";
// // $estimateHeader["見積No"] = "202203110001";
// // $estimateHeader["見積日"] = "2022/03/11";
// // $estimateHeader["案件名"] = "受注した案件の名称001";
// // $estimateHeader["営業担当"] = "流機　太郎e";
// // $estimateHeader["合計金額"] = "55250";
// // $estimateHeader["納入場所"] = "御社玄関前";
// // $estimateHeader["納入期限"] = "ご下命後三カ月";
// // $estimateHeader["支払条件"] = "御社規定支払い";
// // $estimateHeader["有効期限"] = "2022/03/31";
// // $estimateHeader["見積種別"] = "販売";
// // $estimateHeader["明細"] = [];
// // // 明細1
// // $estimateDetail["品名および仕様"] = "Test1";
// // $estimateDetail["数量"] = "2車";
// // $estimateDetail["単位"] = "140ヶ月";
// // $estimateDetail["単価（税抜）"] = 40000;
// // $estimateDetail["金額（税込）"] = 2800000;
// // $estimateDetail["備考"] = "備考1";
// // array_push($estimateHeader["明細"], $estimateDetail);
// // // 明細2
// // $estimateDetail["品名および仕様"] = "Test2";
// // $estimateDetail["数量"] = "1式";
// // $estimateDetail["単位"] = "-";
// // $estimateDetail["単価（税抜）"] = 20000;
// // $estimateDetail["金額（税込）"] = 22000;
// // $estimateDetail["備考"] = "備考2";
// // array_push($estimateHeader["明細"], $estimateDetail);
// // // 明細3
// // $estimateDetail["品名および仕様"] = "Test3";
// // $estimateDetail["数量"] = "3個";
// // $estimateDetail["単位"] = "10ヶ月";
// // $estimateDetail["単価（税抜）"] = 10000;
// // $estimateDetail["金額（税込）"] = 33000;
// // $estimateDetail["備考"] = "備考3";
// // array_push($estimateHeader["明細"], $estimateDetail);

// // $entity_array["見積書"] = [];
// // array_push($entity_array["見積書"], $estimateHeader);




// // /*

// // $entity_array["見積書"][0]["流機住所"] = "〒108-0073 東京都港区三田３丁目４－２ いちご聖坂ビル";
// // $entity_array["見積書"][0]["流機連絡先"] = "TEL：03-3452-7400（代表） FAX：03-3452-5370";
// // $entity_array["見積書"][0]["得意先名称"] = "株式会社サンプルカンパニー　御中";
// // $entity_array["見積書"][0]["見積No"] = "202203110001";
// // $entity_array["見積書"][0]["見積日"] = "2022/03/11";
// // $entity_array["見積書"][0]["案件名"] = "受注した案件の名称001";
// // $entity_array["見積書"][0]["営業担当"] = "流機　太郎e";
// // $entity_array["見積書"][0]["合計金額"] = "55250";
// // $entity_array["見積書"][0]["納入場所"] = "御社玄関前";
// // $entity_array["見積書"][0]["納入期限"] = "ご下命後三カ月";
// // $entity_array["見積書"][0]["支払条件"] = "御社規定支払い";
// // $entity_array["見積書"][0]["有効期限"] = "2022/03/31";
// // $entity_array["見積書"][0]["見積種別"] = "販売";
// // $entity_array["見積書"][0]["明細"][0]["品名および仕様"] = "Test1";
// // $entity_array["見積書"][0]["明細"][0]["数量"] = "2車";
// // $entity_array["見積書"][0]["明細"][0]["単位"] = "140ヶ月";
// // $entity_array["見積書"][0]["明細"][0]["単価（税抜）"] = 40000;
// // $entity_array["見積書"][0]["明細"][0]["金額（税込）"] = 2800000;
// // $entity_array["見積書"][0]["明細"][0]["備考"] = "備考1";
// // $entity_array["見積書"][0]["明細"][1]["品名および仕様"] = "Test2";
// // $entity_array["見積書"][0]["明細"][1]["数量"] = "1式";
// // $entity_array["見積書"][0]["明細"][1]["単位"] = "-";
// // $entity_array["見積書"][0]["明細"][1]["単価（税抜）"] = 20000;
// // $entity_array["見積書"][0]["明細"][1]["金額（税込）"] = 22000;
// // $entity_array["見積書"][0]["明細"][1]["備考"] = "備考2";
// // $entity_array["見積書"][0]["明細"][2]["品名および仕様"] = "Test3";
// // $entity_array["見積書"][0]["明細"][2]["数量"] = "3個";
// // $entity_array["見積書"][0]["明細"][2]["単位"] = "10ヶ月";
// // $entity_array["見積書"][0]["明細"][2]["単価（税抜）"] = 10000;
// // $entity_array["見積書"][0]["明細"][2]["金額（税込）"] = 33000;
// // $entity_array["見積書"][0]["明細"][2]["備考"] = "備考3";

// // */


// // $entity_json = json_encode($entity_array);

// // // var_dump($entity_array);
// // print_r($entity_array);
// // // print_r($entity_json);


