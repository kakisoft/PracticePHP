<?php

$a1 = 'https://eikaiwa.dmm.com/list/?data%5Btab1%5D%5Bstart_time%5D=02%3A00&data%5Btab1%5D%5Bend_time%5D=25%3A30&data%5Btab1%5D%5Bover_3years_experience%5D=0&data%5Btab1%5D%5Bcountry%5D=40%2C104%2C78%2C64%2C65%2C112%2C118%2C177%2C5%2C91%2C139%2C102%2C72%2C175%2C173%2C49%2C56%2C13%2C43%2C41%2C39%2C28%2C35%2C211%2C70%2C24%2C16%2C21%2C53%2C4%2C22%2C32%2C27%2C85%2C97%2C52%2C42%2C3%2C14%2C31%2C12%2C93%2C109%2C103%2C94%2C101%2C86%2C38%2C214%2C99%2C36%2C83%2C79%2C84%2C124%2C132%2C88%2C29%2C10%2C106%2C98%2C77%2C158%2C140%2C37%2C183%2C133%2C204%2C18%2C209%2C120%2C137%2C63%2C134%2C123%2C100%2C44%2C131%2C47%2C62%2C157%2C6%2C117%2C57%2C81%2C197%2C192%2C128%2C23%2C17%2C60%2C129%2C59%2C166%2C111%2C174%2C115%2C116%2C113%2C121&data%5Btab1%5D%5Bgender%5D=0&data%5Btab1%5D%5Bage%5D=%E5%B9%B4%E9%BD%A2&data%5Btab1%5D%5Bfree_word%5D=&data%5Btab1%5D%5Bnew%5D=0&data%5Btab1%5D%5Blesson_language%5D=en&date=2022-09-28&page=1';
echo urldecode($a1);





// //==========================
// //      URLデコード
// //==========================
// $userinput = "北斗神拳";
// $encoded_user_input = rawurlencode($userinput);        //=>  %E5%8C%97%E6%96%97%E7%A5%9E%E6%8B%B3
// $decoded_user_input = urldecode($encoded_user_input);  //=>  北斗神拳


// $userinput = "南斗聖拳";
// $encoded_user_input = rawurlencode($userinput);            //=>  %E5%8D%97%E6%96%97%E8%81%96%E6%8B%B3
// $decoded_user_input = rawurldecode ($encoded_user_input);  //=>  南斗聖拳

// $a1 = '"\u8a31\u53ef\u3055\u308c\u3066\u3044\u306a\u3044\u65b9\u6cd5';
// echo urldecode($a1);










// // $params = [
// //     'netShopMemberId' => 1,
// //     'lastName'        => '織田',
// //     'firstName'       => '信長',
// // ];

// // //==========< URLパラメータを設定(エンコードした値) >==========
// // $encodedUrlParamList = [];
// // foreach ($params as $key => $value) {
// //     array_push($encodedUrlParamList, $key . '=' . rawurlencode(mb_convert_encoding((string)$value, 'SJIS')));
// // }

// // print_r($encodedUrlParamList);
// // // Array
// // // (
// // //     [0] => netShopMemberId=1
// // //     [1] => lastName=%90D%93c
// // //     [2] => firstName=%90M%92%B7
// // // )

// // /*
// //  mb_convert_encoding(): Argument #1 ($string) must be of type array|string, int given
// // */


// // // //==============================================================
// // // // $a1 = "lastName=田";
// // // $a1 = "lastName=田";
// // // $a2 = mb_convert_encoding($a1, "SJIS");
// // // $a3 = rawurlencode($a2);
// // // echo $a1 . PHP_EOL;
// // // echo $a2 . PHP_EOL;
// // // echo $a3 . PHP_EOL;
// // // //==============================================================



// // // // OK 
// // // // $a1 = mb_convert_encoding("田", "sjis", "utf-8");
// // // $a1 = mb_convert_encoding("田", "SJIS");
// // // $a2 = rawurlencode($a1);
// // // echo $a2 . PHP_EOL;


// // // $dataA1 = "田";
// // // $dataA2= mb_convert_encoding("田", "sjis", "utf-8");
// // // $dataA3= mb_convert_encoding($dataA2, "utf-8", "sjis");
// // // echo $dataA1 . PHP_EOL;
// // // echo $dataA2 . PHP_EOL;
// // // echo $dataA3 . PHP_EOL;

// // // $dataA4 = mb_convert_encoding($dataA1, "SJIS-win", "UTF-8");
// // // echo $dataA4 . PHP_EOL;


// // // $str = mb_convert_encoding($data,"utf-8","sjis"); // シフトJISからUTF-8に変換

// // //// NG
// // // $strA1 = "田";
// // // $strA2 = mb_convert_encoding($strA1, "SJIS");
// // // // $strA2 = mb_convert_encoding($strA1, "SJIS", "UTF8");
// // // echo $strA2 . PHP_EOL;

// // // var_dump($strA2);



// // // $urlParam = "lastName=田";
// // // $urlEncodedParam = mb_convert_encoding($urlParam, 'SJIS');
// // // echo $urlEncodedParam . PHP_EOL;
// // // echo md5($urlEncodedParam) . PHP_EOL;
// // // //=> b63135c20cc945a96698c9183667266d


// // // $urlParam = "太郎";
// // // $urlEncodedParam = mb_convert_encoding($urlParam, 'SJIS');
// // // echo $urlEncodedParam . PHP_EOL;
// // // echo md5($urlEncodedParam) . PHP_EOL;
// // // //=> b63135c20cc945a96698c9183667266d



// // // $urlParam = "tenantCd=B096&shopCd=88888SGHIJlEW";
// // // $urlEncodedParam = mb_convert_encoding($urlParam, 'SJIS');
// // // echo md5($urlEncodedParam) . PHP_EOL;
// // // //=> b63135c20cc945a96698c9183667266d




// // // // $mbie = mb_internal_encoding();
// // // // var_dump($mbie);  //=> UTF-8


// // // $lastName = 'tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎mXCTpnoA';
// // // $encodedLastName = mb_convert_encoding($lastName, 'SJIS');
// // // // echo rawurlencode($encodedLastName) . PHP_EOL;
// // // // echo urlencode($encodedLastName) . PHP_EOL;

// // // // $urlEncodedParam = urlencode($encodedLastName);
// // // echo hash('md5',$urlEncodedParam) . PHP_EOL;


// // // // $urlEncodedParam = "tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=%91%BE%98YmXCTpnoA";

// // // echo $urlEncodedParam . PHP_EOL;
// // // // $a1 = urlencode('abc_defああああ');
// // // //=> %91%BE%98Y

// // // // $hashedParam = "";
// // // // $hashedParam = "";

// // // // echo md5('val1') . PHP_EOL;
// // // // echo hash('md5','val1') . PHP_EOL;

// // // echo md5($urlEncodedParam) . PHP_EOL;
// // // echo hash('md5',$urlEncodedParam) . PHP_EOL;


// // // // $lastName = "太郎";
// // // // // $str = "tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎 mXCTpnoA"
// // // // $lastName = mb_convert_encoding($lastName, "SJIS");


// // // // echo rawurlencode($lastName) . PHP_EOL;




// // // // // UTF-8の文字列をSJISに変換
// // // // $utf8Str = "太郎";
// // // // $sjisStr = mb_convert_encoding($utf8Str, 'SJIS', 'UTF-8');

// // // // var_dump($sjisStr);


// // // // 「%91%BE%98Y」


// // // // echo md5('val1') . PHP_EOL;
// // // // echo hash('md5','val1') . PHP_EOL;

// // // // echo md5('tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎 mXCTpnoA') . PHP_EOL;

// // // // echo md5('tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎mXCTpnoA') . PHP_EOL;
// // // // echo hash('md5','tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎mXCTpnoA') . PHP_EOL;

// // // // $utf8Str = "太郎";
// // // // $sjisStr = mb_convert_encoding($utf8Str, 'SJIS', 'UTF-8');
// // // // // $sjisStr = mb_convert_encoding($utf8Str, 'SJIS', 'SJIS');
// // // // echo $sjisStr;


// // // // echo rawurlencode('太郎');


// // // // //=====================================================================
// // // // // https://qiita.com/KaiShoya/items/d335accbd5e995d9eb23
// // // // echo mb_convert_encoding('太郎', 'SJIS') . PHP_EOL;
// // // // echo mb_convert_encoding('太郎', 'SHIFT-JIS') . PHP_EOL;
// // // // echo mb_convert_encoding('太郎', 'Shift_JIS') . PHP_EOL;
// // // // echo mb_convert_encoding('太郎', 'CP932') . PHP_EOL;
// // // // echo mb_convert_encoding('太郎', 'MS932') . PHP_EOL;
// // // // echo mb_convert_encoding('太郎', 'MS_Kanji') . PHP_EOL;
// // // // echo mb_convert_encoding('太郎', 'Windows-31J') . PHP_EOL;
// // // // echo mb_convert_encoding('太郎', 'SJIS-win') . PHP_EOL;
// // // // //=====================================================================


// // // /*

// // // パラメータと認証鍵の間には半角スペースは必要ございません。
// // // tenantCd=XX01&shopCd=000001&netShopMemberId=012345&lastName=太郎mXCTpnoA
// // // をmd5でハッシュ化しますと「b63135c20cc945a96698c9183667266d」なることを改めて確認しております。


// // // */


// // // // $entity_array = [];

// // // // //// ヘッダ
// // // // $estimateHeader["流機住所"] = "〒108-0073 東京都港区三田３丁目４－２ いちご聖坂ビル";
// // // // $estimateHeader["流機連絡先"] = "TEL：03-3452-7400（代表） FAX：03-3452-5370";
// // // // $estimateHeader["得意先名称"] = "株式会社サンプルカンパニー　御中";
// // // // $estimateHeader["見積No"] = "202203110001";
// // // // $estimateHeader["見積日"] = "2022/03/11";
// // // // $estimateHeader["案件名"] = "受注した案件の名称001";
// // // // $estimateHeader["営業担当"] = "流機　太郎e";
// // // // $estimateHeader["合計金額"] = "55250";
// // // // $estimateHeader["納入場所"] = "御社玄関前";
// // // // $estimateHeader["納入期限"] = "ご下命後三カ月";
// // // // $estimateHeader["支払条件"] = "御社規定支払い";
// // // // $estimateHeader["有効期限"] = "2022/03/31";
// // // // $estimateHeader["見積種別"] = "販売";
// // // // $estimateHeader["明細"] = [];
// // // // // 明細1
// // // // $estimateDetail["品名および仕様"] = "Test1";
// // // // $estimateDetail["数量"] = "2車";
// // // // $estimateDetail["単位"] = "140ヶ月";
// // // // $estimateDetail["単価（税抜）"] = 40000;
// // // // $estimateDetail["金額（税込）"] = 2800000;
// // // // $estimateDetail["備考"] = "備考1";
// // // // array_push($estimateHeader["明細"], $estimateDetail);
// // // // // 明細2
// // // // $estimateDetail["品名および仕様"] = "Test2";
// // // // $estimateDetail["数量"] = "1式";
// // // // $estimateDetail["単位"] = "-";
// // // // $estimateDetail["単価（税抜）"] = 20000;
// // // // $estimateDetail["金額（税込）"] = 22000;
// // // // $estimateDetail["備考"] = "備考2";
// // // // array_push($estimateHeader["明細"], $estimateDetail);
// // // // // 明細3
// // // // $estimateDetail["品名および仕様"] = "Test3";
// // // // $estimateDetail["数量"] = "3個";
// // // // $estimateDetail["単位"] = "10ヶ月";
// // // // $estimateDetail["単価（税抜）"] = 10000;
// // // // $estimateDetail["金額（税込）"] = 33000;
// // // // $estimateDetail["備考"] = "備考3";
// // // // array_push($estimateHeader["明細"], $estimateDetail);

// // // // $entity_array["見積書"] = [];
// // // // array_push($entity_array["見積書"], $estimateHeader);




// // // // /*

// // // // $entity_array["見積書"][0]["流機住所"] = "〒108-0073 東京都港区三田３丁目４－２ いちご聖坂ビル";
// // // // $entity_array["見積書"][0]["流機連絡先"] = "TEL：03-3452-7400（代表） FAX：03-3452-5370";
// // // // $entity_array["見積書"][0]["得意先名称"] = "株式会社サンプルカンパニー　御中";
// // // // $entity_array["見積書"][0]["見積No"] = "202203110001";
// // // // $entity_array["見積書"][0]["見積日"] = "2022/03/11";
// // // // $entity_array["見積書"][0]["案件名"] = "受注した案件の名称001";
// // // // $entity_array["見積書"][0]["営業担当"] = "流機　太郎e";
// // // // $entity_array["見積書"][0]["合計金額"] = "55250";
// // // // $entity_array["見積書"][0]["納入場所"] = "御社玄関前";
// // // // $entity_array["見積書"][0]["納入期限"] = "ご下命後三カ月";
// // // // $entity_array["見積書"][0]["支払条件"] = "御社規定支払い";
// // // // $entity_array["見積書"][0]["有効期限"] = "2022/03/31";
// // // // $entity_array["見積書"][0]["見積種別"] = "販売";
// // // // $entity_array["見積書"][0]["明細"][0]["品名および仕様"] = "Test1";
// // // // $entity_array["見積書"][0]["明細"][0]["数量"] = "2車";
// // // // $entity_array["見積書"][0]["明細"][0]["単位"] = "140ヶ月";
// // // // $entity_array["見積書"][0]["明細"][0]["単価（税抜）"] = 40000;
// // // // $entity_array["見積書"][0]["明細"][0]["金額（税込）"] = 2800000;
// // // // $entity_array["見積書"][0]["明細"][0]["備考"] = "備考1";
// // // // $entity_array["見積書"][0]["明細"][1]["品名および仕様"] = "Test2";
// // // // $entity_array["見積書"][0]["明細"][1]["数量"] = "1式";
// // // // $entity_array["見積書"][0]["明細"][1]["単位"] = "-";
// // // // $entity_array["見積書"][0]["明細"][1]["単価（税抜）"] = 20000;
// // // // $entity_array["見積書"][0]["明細"][1]["金額（税込）"] = 22000;
// // // // $entity_array["見積書"][0]["明細"][1]["備考"] = "備考2";
// // // // $entity_array["見積書"][0]["明細"][2]["品名および仕様"] = "Test3";
// // // // $entity_array["見積書"][0]["明細"][2]["数量"] = "3個";
// // // // $entity_array["見積書"][0]["明細"][2]["単位"] = "10ヶ月";
// // // // $entity_array["見積書"][0]["明細"][2]["単価（税抜）"] = 10000;
// // // // $entity_array["見積書"][0]["明細"][2]["金額（税込）"] = 33000;
// // // // $entity_array["見積書"][0]["明細"][2]["備考"] = "備考3";

// // // // */


// // // // $entity_json = json_encode($entity_array);

// // // // // var_dump($entity_array);
// // // // print_r($entity_array);
// // // // // print_r($entity_json);


