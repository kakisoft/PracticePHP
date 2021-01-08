<?php


    public static function createPager($currentPage, $allRecordCount, $NumberOfRecordsToDisplay, $list_limit) {
        $data = array();
        $data["current_page"] = $currentPage ? $currentPage : 1 ;
        $data["all_record_count"] = $allRecordCount;
        $data["number_of_records_to_display"] = intval($NumberOfRecordsToDisplay);

		//ページャー開始位置と終了位置
		if($data["currentPage"] > $data["max_page"] - $data["list_limit"] + 1){
			if($data["max_page"] <= $data["list_limit"]){
				$data["start_position"] = $data["currentPage"];
			}else{
				$data["start_position"] = $data["max_page"] - $data["list_limit"] + 1;
			}
		}else{
			$data["start_position"] = $data["currentPage"];
		}

		if($data["max_page"] <= $data["list_limit"]){
			$data["end_position"] = $data["max_page"];
		}else{
			$data["end_position"] = $data["start_position"] + $data["list_limit"] - 1;
		}
   }


//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━






