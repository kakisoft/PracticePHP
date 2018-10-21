<?php
class MyPagerClass {
	const NUMBER_OF_BOX = 5;
	const DISP_RECORD_COUNT = 20;

	/**
	 * ページャー作成： 【1】【...】【3】【4】【5】【...】【10】
	 *
	 * @param string  $currentPage     - 現在のページ
	 * @param string  $dispRecordCount - 1ページに表示するレコードの件数
	 * @param string  $allRecordCount  - トータルのレコード数
	 * @param string  $numberOfBox     - 画面上に表示する、選択可能ページ数
	 * 
	 * @return array  
	 */	
	public static function getPager() {
		$currentPage = 1;
		$numberOfBox = self::NUMBER_OF_BOX;

		//
		$maxPageNumber = 10;


		//---------------------------
		$pager["current_page"] = $currentPage;
		$pager["number_of_box"] = $numberOfBox;
		$pager["max_page_number"] = $maxPageNumber;
		$pager["chunk"] = [];

		if($pager["current_page"] > $pager["max_page_number"]){
			return null;
		}


		//---------------------------
		//       
		//---------------------------


		//---------------------------
		//       Create Chunk
		//---------------------------
		$middlePoint = ceil($pager["number_of_box"] / 2);  //ページャー中間地点（ 2で割って切り上げ）
		$middleOffset = floor($middlePoint /2);               //ページャー中間地点からのオフセット（ 2で割って切り捨て）
		$maxPageStartPoint = $pager["max_page_number"] - ($pager["number_of_box"]-1) + 1;

		//----------< 動的コンテンツにおける開始ページ数の設定 >----------
		$dynamicStartPagePoint = 1;
		if($pager["current_page"] <= $middlePoint){
			//現在のページが、表示数の中間よりも小さい場合、動的コンテンツ開始位置は、1ページ目から
			$dynamicStartPagePoint = 1;
		}else{
			$dynamicStartPagePoint = $pager["current_page"] - $middleOffset;
			if($dynamicStartPagePoint > $maxPageStartPoint){
				$dynamicStartPagePoint = $maxPageStartPoint;
				//（例）max  10
				// page  6  ⇒  1  ... 5  6  7  ... 10
				// page  7  ⇒  1  ... 6  7  8  ... 10
				// page  8  ⇒  1  ... 7  8  9  10
				// page  9  ⇒  1  ... 7  8  9  10
				// page 10  ⇒  1  ... 7  8  9  10

				//開始位置のページが、max_page_number(10) - (disp_page_number(5) -1) + 1
				//よりも大きい場合、↑の規定値を使用。 
			}
		}

		//----------< 特殊制御が必要かどうかの判定 >----------
		$isContainSpecialCharFirst = false;
		$isContainSpecialCharLast  = false;

		if($pager["max_page_number"] > $pager["number_of_box"]){
			if($pager["current_page"] > $middlePoint){
				$isContainSpecialCharFirst = true;	
			}
			if($dynamicStartPagePoint < $maxPageStartPoint){
				$isContainSpecialCharLast = true;	
			}
		}

		//----------< 動的コンテンツ数の設定 >----------
		$dispLoopCount = 0;
		if($pager["max_page_number"] <= $pager["number_of_box"]){
			//最大ページ数が、表示する数よりも小さい場合、最大ページ数を採用する
			$dispLoopCount = $pager["max_page_number"];
		}else{
			//最大ページ数が、表示する数よりも大きい場合、表示するページ数を採用する
			$dispLoopCount = $pager["number_of_box"];
			if($isContainSpecialCharFirst == true){
				//開始位置に特殊制御が入る場合、表示する数をデクリメント
				$dispLoopCount--;
			}
			if($isContainSpecialCharLast == true){
				//終了位置に特殊制御が入る場合、表示する数をデクリメント
				$dispLoopCount--;
			}
		}
		
		//----------< 動的コンテンツの格納 >----------
		$dynamicContentArray = [];
		for ($i = $dynamicStartPagePoint; $i < ($dynamicStartPagePoint + $dispLoopCount); $i++) {
			array_push($dynamicContentArray, strval($i));
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


		return $pager;
	}

}



