<?php

$date = new DateTime();
$date->setTimestamp(1666482043341 / 1000);  
$variable = $date->format('Y/m/d H:i:s');
echo "$variable" . PHP_EOL;  //=> 2022/10/22 23:40:43

// $dateArray = [];

1673728504040
1673727005473
1673726954457
1673710257316
1673200942925
1673200877930
1673200244732
1673200230774
1673195500936
1673195113366
1673182688642
1673182670366
1673181355197
1673181338504
1673181294673
1672973914919
1672406270774
1671384200163
1667221071680
1666482043341



// //=============================
// //          base64
// //=============================
// $str = 'AefeGgueum57bp7tAyfYEOJ01udhnawSnCgGar0VsgPVXN/60Jc51TdVZ0gExlfRHp22EwXGfE2vqPenHnVNHciHv7Zd1sScn9OwQA==';
//       //QWVmZUdndWV1bTU3YnA3dEF5ZllFT0owMXVkaG5hd1NuQ2dHYXIwVnNnUFZYTi82MEpjNTFUZFZaMGdFeGxmUkhwMjJFd1hHZkUydnFQZW5IblZOSGNpSHY3WmQxc1NjbjlPd1FBPT0=AefeGgueum57bp7tAyfYEOJ01udhnawSnCgGar0VsgPVXN/60Jc51TdVZ0gExlfRHp22EwXGfE2vqPenHnVNHciHv7Zd1sScn9OwQA==
// $encoded_str = base64_encode($str);
// $decoded_str = base64_decode($encoded_str);
// echo $encoded_str;    //=> VGhpcyBpcyBhbiBlbmNvZGVkIHN0cmluZw==
// echo $decoded_str;    //=> This is an encoded string

// $decoded_str = base64_decode("AefeGgueum57bp7tAyfYEOJ01udhnawSnCgGar0VsgPVXN/60Jc51TdVZ0gExlfRHp22EwXGfE2vqPenHnVNHciHv7Zd1sScn9OwQA==");


// // $a1 = "  ";
// // // $a1 = "";

// // if(empty($a1) === true){
// //     echo "true";
// // }else{
// //     echo "false";
// // }


// // // var_dump(0.1 + 0.2);  //-> float(0.30000000000000004)


// // // try {
// // //     // $startTime = Carbon::now();
// // //     // $request = $this->setRequest();
// // //     // if (isset($request['order'])) {
// // //     //     $request['storeId'] = $this->convertOrderToStoreIds((int) $request['order']);
// // //     // }
// // //     // $googleBusinessApi = new GoogleBusinessApi();
// // //     // $apiTypes = GmbApiKeyType::values();
// // //     // foreach ($apiTypes as $apiType) {
// // //     //     $googleBusinessApi->setApiKey($apiType);
// // //     //     $gmbAccountsQuery = $this->getQueryByApiKeyType($request, $apiType);
// // //     //     $this->executeFetchingInsights($gmbAccountsQuery, $request, $googleBusinessApi);
// // //     // }
// // //     // $endTime = Carbon::now();
// // //     // $this->log->info('Execute time: ' . $endTime->diff($startTime)->format('%H:%I:%S'));
// // //     $apiTypes = ['MAIN', 'SUB'];
// // //     foreach ($apiTypes as $apiType) {
// // //         echo $apiType . PHP_EOL;
// // //         break;
// // //     }


// // //     echo "return" . PHP_EOL;
// // // } catch (Throwable $e) {
// // //     echo "catch" . PHP_EOL;
// // // } finally {
// // //     echo "finally" . PHP_EOL;
// // // }


// // // // $dates = [1, 2, 3, 4, 5];
// // // // foreach ($dates as $date) {
// // // //     echo "aaa" . PHP_EOL;
// // // //     exit;
// // // // }


// // // // // function bananaCheck($str){
// // // // //     if($str !== 'バナナ'){
// // // // //         return true;
// // // // //     }else{
// // // // //         return false;
// // // // //     }
// // // // // }

// // // // // $aryFruits = ['りんご', 'バナナ', 'ぶどう', 'バナナ', 'いちご', 'バナナ', 'メロン'];

// // // // // $aryFruits = array_filter($aryFruits, "bananaCheck");


// // // // // var_dump($aryFruits);


// // // // // // $a = [3, 4, 8];
// // // // // // $b = [4, 8, 12];
// // // // // // $merged = array_merge($a, $b);
// // // // // // $merged = [...$a, ...$b];

// // // // // // print_r($merged);

// // // // // // return;

// // // // // // // // 203 を 11 で割ると、 商は 18 で余りが 5 になります。

// // // // // // // // $remainder = 203 % 11;
// // // // // // // $remainder = 244 % 11;



// // // // // // // $checkNumber = 11 - $remainder;

// // // // // // // echo $remainder . PHP_EOL;
// // // // // // // echo $checkNumber . PHP_EOL;

// // // // // // // exit;
// // // // // // // /////////////////////////////////////////


// // // // // // $line = "4478025819";
// // // // // // // $inputData = "4864104441111";
// // // // // // // $line = "AAA";


// // // // // // $result = sample01($line);

// // // // // // var_dump($result);

// // // // // // function sample01($line)
// // // // // // {
// // // // // //     // 10桁でない場合、ISBNではないと判定する
// // // // // //     if(strlen($line) != 10){
// // // // // //         return false;
// // // // // //     }

// // // // // //     // ハイフン付のパターンも検索する場合、preg_match を使用
// // // // // //     // (入力例を見る限り、そのパターンは対応せずともよい？　試験の時間もあるので、今回はスキップ)

// // // // // //     // 数値以外の文字が含まれている場合、ISBNではないと判定する
// // // // // //     if(is_numeric($line) === false){
// // // // // //         return false;
// // // // // //     }

// // // // // //     // チェックディジットの正当性をチェック
// // // // // //     if( isCorrectCheckDigit($line) === false ){
// // // // // //         return false;
// // // // // //     }

// // // // // //     // 全てのエラーに引っかからなかった場合、ISBNであると判定する
// // // // // //     return true;
// // // // // // }


// // // // // // // 入力データのバリデーションは完了している、という前提のメソッドです
// // // // // // function isCorrectCheckDigit($imputedData){

// // // // // //     $digit1  = intval(substr($imputedData,  0, 1));
// // // // // //     $digit2  = intval(substr($imputedData,  1, 1));
// // // // // //     $digit3  = intval(substr($imputedData,  2, 1));
// // // // // //     $digit4  = intval(substr($imputedData,  3, 1));
// // // // // //     $digit5  = intval(substr($imputedData,  4, 1));
// // // // // //     $digit6  = intval(substr($imputedData,  5, 1));
// // // // // //     $digit7  = intval(substr($imputedData,  6, 1));
// // // // // //     $digit8  = intval(substr($imputedData,  7, 1));
// // // // // //     $digit9  = intval(substr($imputedData,  8, 1));
// // // // // //     $digit10 = intval(substr($imputedData,  9, 1));


// // // // // //     $resultOfAddition =   ($digit1 * 10) + ($digit2 * 9) + ($digit3 * 8) + ($digit4 * 7) + ($digit5 * 6)
// // // // // //                         + ($digit6 * 5)  + ($digit7 * 4) + ($digit8 * 3) + ($digit9 * 2);


// // // // // //     $remainder = $resultOfAddition % 11;


// // // // // //     $checkNumber = 11 - $remainder;

// // // // // //     if($checkNumber === $digit10){
// // // // // //         return true;
// // // // // //     }
// // // // // //     else{
// // // // // //         return false;
// // // // // //     }
// // // // // // }


// // // // // // // $line = "4478025819";
// // // // // // // // $inputData = "4864104441111";
// // // // // // // // $line = "AAA";


// // // // // // // if(strlen($line) != 10){
// // // // // // //     // return false;
// // // // // // //     echo "false" . PHP_EOL;
// // // // // // // }

// // // // // // // if(is_numeric($line) === false){
// // // // // // //     // return false;
// // // // // // //     echo "false" . PHP_EOL;
// // // // // // // }


// // // // // // // チェックディジット




// // // // // // // var_dump( $this->saumple01($inputData) );


// // // // // // // function sample01($inputData)
// // // // // // // {
// // // // // // // }







// // // // // // // echo "PHP";

// // // // // // // // $a1 = 'https://eikaiwa.dmm.com/list/?data%5Btab1%5D%5Bstart_time%5D=02%3A00&data%5Btab1%5D%5Bend_time%5D=25%3A30&data%5Btab1%5D%5Bover_3years_experience%5D=0&data%5Btab1%5D%5Bcountry%5D=40%2C104%2C78%2C64%2C65%2C112%2C118%2C177%2C5%2C91%2C139%2C102%2C72%2C175%2C173%2C49%2C56%2C13%2C43%2C41%2C39%2C28%2C35%2C211%2C70%2C24%2C16%2C21%2C53%2C4%2C22%2C32%2C27%2C85%2C97%2C52%2C42%2C3%2C14%2C31%2C12%2C93%2C109%2C103%2C94%2C101%2C86%2C38%2C214%2C99%2C36%2C83%2C79%2C84%2C124%2C132%2C88%2C29%2C10%2C106%2C98%2C77%2C158%2C140%2C37%2C183%2C133%2C204%2C18%2C209%2C120%2C137%2C63%2C134%2C123%2C100%2C44%2C131%2C47%2C62%2C157%2C6%2C117%2C57%2C81%2C197%2C192%2C128%2C23%2C17%2C60%2C129%2C59%2C166%2C111%2C174%2C115%2C116%2C113%2C121&data%5Btab1%5D%5Bgender%5D=0&data%5Btab1%5D%5Bage%5D=%E5%B9%B4%E9%BD%A2&data%5Btab1%5D%5Bfree_word%5D=&data%5Btab1%5D%5Bnew%5D=0&data%5Btab1%5D%5Blesson_language%5D=en&date=2022-09-28&page=1';
// // // // // // // // echo urldecode($a1);



// // // // // // // // // // // $dataA1 = "田";
// // // // // // // // // // // $dataA2= mb_convert_encoding("田", "sjis", "utf-8");
// // // // // // // // // // // $dataA3= mb_convert_encoding($dataA2, "utf-8", "sjis");
// // // // // // // // // // // echo $dataA1 . PHP_EOL;
// // // // // // // // // // // echo $dataA2 . PHP_EOL;
// // // // // // // // // // // echo $dataA3 . PHP_EOL;


// // // // // // // // // // // // //=====================================================================
// // // // // // // // // // // // // https://qiita.com/KaiShoya/items/d335accbd5e995d9eb23
// // // // // // // // // // // // echo mb_convert_encoding('太郎', 'SJIS') . PHP_EOL;
// // // // // // // // // // // // echo mb_convert_encoding('太郎', 'SHIFT-JIS') . PHP_EOL;
// // // // // // // // // // // // echo mb_convert_encoding('太郎', 'Shift_JIS') . PHP_EOL;
// // // // // // // // // // // // echo mb_convert_encoding('太郎', 'CP932') . PHP_EOL;
// // // // // // // // // // // // echo mb_convert_encoding('太郎', 'MS932') . PHP_EOL;
// // // // // // // // // // // // echo mb_convert_encoding('太郎', 'MS_Kanji') . PHP_EOL;
// // // // // // // // // // // // echo mb_convert_encoding('太郎', 'Windows-31J') . PHP_EOL;
// // // // // // // // // // // // echo mb_convert_encoding('太郎', 'SJIS-win') . PHP_EOL;
// // // // // // // // // // // // //=====================================================================




// C:\Windows\System32\WindowsPowerShell\v1.0\psadmin.ps1

