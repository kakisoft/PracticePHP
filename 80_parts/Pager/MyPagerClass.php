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
		$dispPageNumber = 5;



		// $pager = [];
		$pager["dispPageNumber"] = $dispPageNumber;
		$pager["max_page_number"] = 10;




		$pager["chunk"] = [];

		array_push($pager["chunk"], "1");
		array_push($pager["chunk"], "");
		array_push($pager["chunk"], "3");
		array_push($pager["chunk"], "4");
		
		return $pager;
	}

}



