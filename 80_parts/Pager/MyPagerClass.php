<?php
class MyPagerClass {

	/**
	 * 検索処理：SQL生成（ where 条件を追加 ）
	 *
	 * @param string  $sql
	 * @param array   $parameters  POST等
	 * @param boolean $connectType  true - SQLを AND で接続。　　false - SQL を ORで接続
	 * 
	 */	
	const SEARCH_VALUE_HEADER = "search_value_";
	const SEARCH_CONDITION_HEADER = "search_condition_";
	const SEARCH_CONDITION_PARAM_INCLUDING = "1";
	const SEARCH_CONDITION_PARAM_MATCH     = "2";


	public static function getPager() {
		$currentPage = 2;
		$dispPageNumber = 5;


		// $pager = [];
		$pager["current_page"] = $currentPage;
		$pager["disp_page_number"] = $dispPageNumber;
		$pager["max_page_number"] = 10;



		//---------------------------
		//       Create Chunk
		//---------------------------
		$middlePoint = ceil($pager["disp_page_number"] / 2);

		//----------< 制御が必要かどうかの判定 >----------
		$isContainSpecialCharFirst = false;
		$isContainSpecialCharLast  = false;

		if($pager["current_page"]> $middlePoint){
			$isContainSpecialCharFirst = true;	
		}



		$isContainSpecialCharLast  = false;




		//----------< 動的コンテンツ数の設定 >----------
		$dispLoopCount = 0;
		if($pager["max_page_number"] <= $dispPageNumber){
			//最大ページ数が、表示する数よりも小さい場合、最大ページ数を採用する
			$dispLoopCount = $pager["max_page_number"];
		}else{
			//最大ページ数が、表示する数よりも大きい場合、表示するページ数を採用する
			$dispLoopCount = $pager["disp_page_number"];
			if($isContainSpecialCharFirst == true){
				//開始位置に特殊制御が入る場合、表示する数をデクリメント
				$dispLoopCount--;
			}
			if($isContainSpecialCharLast == true){
				//終了位置に特殊制御が入る場合、表示する数をデクリメント
				$dispLoopCount--;
			}
		}

		//----------< 動的コンテンツにおける開始ページ数の設定 >----------
		$dynamicPagePoint = 1;

		if($pager["current_page"] <= $middlePoint){
			//現在のページが、表示数の中間よりも小さい場合、動的コンテンツ開始位置は、1ページ目から
			$dynamicPagePoint = 1;
		}
		
		//----------< 動的コンテンツの格納 >----------
		$dynamicContentArray = [];
		for ($i = 0; $i < $dispLoopCount; $i++) {
			array_push($dynamicContentArray, strval($dynamicPagePoint));
			$dynamicPagePoint = $dynamicPagePoint + 1;
		}

		//----------< 出力コンテンツの作成 >----------
		$pager["chunk"] = [];
		if($isContainSpecialCharFirst == true){
			array_push($pager["chunk"], "1");
			array_push($pager["chunk"], "");
		}
		$pager["chunk"] = array_merge($pager["chunk"], $dynamicContentArray);
		if($isContainSpecialCharLast == true){
			array_push($pager["chunk"], "");
			array_push($pager["chunk"], strval($pager["max_page_number"]));
		}


		// $pager["chunk"] = [];

		// array_push($pager["chunk"], "1");
		// array_push($pager["chunk"], "");
		// array_push($pager["chunk"], "3");
		// array_push($pager["chunk"], "4");


		return $pager;
	}

}



