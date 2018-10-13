<?php
class MyUtils {

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

	public static function addQueryFromUserParams(&$sql, $parameters, $connectType=true) {
		if(count($parameters) <= 0){
			return;
		}

		foreach ($parameters as $key => $value) {
			if(trim($value) == ""){
				continue;
			}

			if(strpos($key, self::SEARCH_VALUE_HEADER) === 0){
				$parameter_name = substr($key, strlen(self::SEARCH_VALUE_HEADER));
				$condition_name = self::SEARCH_CONDITION_HEADER . $parameter_name;

				$piecesParam = explode(" ", preg_replace('/\s+/', ' ', trim($parameters[$key])));
				$tmpArray =[];
				for ($i = 0; $i < count($piecesParam); $i++) {
					if($parameters[$condition_name] == self::SEARCH_CONDITION_PARAM_MATCH){
						array_push($tmpArray, " " . $parameter_name . " = :" . $parameter_name . $i );
					}else{
						array_push($tmpArray, " " . $parameter_name . " like :" . $parameter_name . $i );
					}
				}
				if($connectType){
					$innerSql = implode(" AND ", $tmpArray);
				}else{
					$innerSql = implode(" OR ", $tmpArray);
				}
				$sql .= "AND ( " . $innerSql  . " )";
			}
		}		
	}

	/**
	 * 検索処理：バインド設定を追加
	 *
	 * @param object $stmt 
	 * @param array $parameters  POST等
	 * 
	 */	
	public static function setBindValueFromUserParams(&$stmt, $parameters) {
		if(count($parameters) <= 0){
			return;
		}

		foreach ($parameters as $key => $value) {
			if($value == ""){
				continue;
			}

			$parameter_name = "";
			if(strpos($key, self::SEARCH_VALUE_HEADER) === 0){
				$parameter_name = substr($key, strlen(self::SEARCH_VALUE_HEADER));
				$condition_name = self::SEARCH_CONDITION_HEADER . $parameter_name;

				$piecesParam = explode(" ", preg_replace('/\s+/', ' ', trim($parameters[$key])));
				for ($i = 0; $i < count($piecesParam); $i++) {
					if($parameters[$condition_name] == self::SEARCH_CONDITION_PARAM_MATCH){
						$stmt->bindValue(':' . $parameter_name . $i, $piecesParam[$i]);
					}else{
						$stmt->bindValue(':' . $parameter_name . $i, self::getForQueryLikeSearchCaractorBothSide($piecesParam[$i]));
					}
				}
			}
		}
	}
}

//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

	//ユーザ自由入力項目による検索
	Jetro_Jmesse_Utils::addQueryFromUserParams($sql , $_GET);
	$sql .= " ORDER BY id DESC ";
	$stmt = $db->prepare($sql);

	//バインド設定
	Jetro_Jmesse_Utils::setBindValueFromUserParams($stmt, $_GET);

	$stmt->execute();
	$recordCount = $stmt->rowCount(MSM_DB_CONST::FETCH_ASSOC);
	$recordSet = $stmt->fetchAll(MSM_DB_CONST::FETCH_ASSOC);
	$recordSetArray = (array)$recordSet;

//===============
	//権限での検索
	if(htmlspecialchars($_GET['search_admin']) === "0"){
		$sql .= " AND admin in ('0') ";
	}elseif(htmlspecialchars($_GET['search_admin']) === "1"){
		$sql .= " AND admin in ('1') ";
	}

//━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━

/*
	<tr>
		<th>
			<label for="search_value_email">メールアドレス</label>
		</th>
		<td>
			<div>
				<input type="text" id="search_value_email" name="search_value_email" value="{$parameters['search_value_email']}">
			</div>
			<div>
				<ul>
					<li>
						<label><input type="radio" value="1" name="search_condition_email" id="search_condition_email_1" {if $parameters['search_condition_email'] != "2"}checked{/if}><span>含む</span></label>
					</li>
					<li>
						<label><input type="radio" value="2" name="search_condition_email" id="search_condition_email_2" {if $parameters['search_condition_email'] == "2"}checked{/if}><span>一致</span></label>
					</li>
				</ul>
			</div>
		</td>
	</tr>
*/


