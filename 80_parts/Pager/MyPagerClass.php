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
		$current_page = 1;
		$dispPageNumber = 5;


		// $pager = [];
		$pager["dispPageNumber"] = $dispPageNumber;
		$pager["max_page_number"] = 10;



		//---------------------------
		//       Create Chunk
		//---------------------------

		$isContainSpecialCharFirst = false;
		$isContainSpecialCharLast  = false;




		//----------< 動的コンテンツ数の設定 >----------
		$dispLoopCount = 0;
		if($pager["max_page_number"] <= $dispPageNumber){
			//最大ページ数が、表示する数よりも小さい場合、最大ページ数を採用する
			$dispLoopCount = $pager["max_page_number"];
		}else{
			//最大ページ数が、表示する数よりも大きい場合、表示するページ数を採用する
			$dispLoopCount = $pager["dispPageNumber"];
			if($isContainSpecialCharFirst == false){
				//開始位置に特殊制御が入る場合、表示する数をデクリメント
				$dispLoopCount--;
			}
			if($isContainSpecialCharLast == false){
				//終了位置に特殊制御が入る場合、表示する数をデクリメント
				$dispLoopCount--;
			}
		}

		//----------< 動的コンテンツにおける開始ページ数の設定 >----------
		$dynamicPagePoint = 1;

		
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



