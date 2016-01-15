<?php

function loadPlayerList() {
	$players = array();
	$sql = "select id_player, tx_perfil from tb_player where cs_ativo = 1";

	$rs = queryDB($sql);

	while($row = mysql_fetch_assoc($rs)) {
		//$GLOBALS['players'][] = new Player($row['id_player'],$row['tx_perfil']);
		$players[] = new Player($row['id_player'],$row['tx_perfil']);
	}
	
	return $players;

}


function getToday() {
	return date("Y-m-d");

}

function cleanDay() {
	$sql = "delete from tb_data where dt_stamp = '". getToday()."'";

	queryDB($sql);

}

function cleanCategories() {
	$sql = "truncate table tb_categories";
	
	queryDB($sql);
}


function getAtualSeason() {
	$date = date("Y-m-d");
	
	$sql    = "select id_season from tb_season
	where '$date' between dt_start and dt_end";

	$rs = queryDB($sql);
	$row = mysql_fetch_assoc($rs);

	return $row['id_season'];

}

function getJSonError($last) {
	
	if ($last==JSON_ERROR_NONE) {
		return false;
	} else {
		switch ($last) {
			case JSON_ERROR_DEPTH: $erro= 'Maximum stack depth exceeded'; break;
			case JSON_ERROR_STATE_MISMATCH: $erro= 'Underflow or the modes mismatch'; break;
			case JSON_ERROR_CTRL_CHAR: $erro= 'Unexpected control character found'; break;
			case JSON_ERROR_SYNTAX: $erro= 'Syntax error, malformed JSON'; break;
			case JSON_ERROR_UTF8: $erro= 'Malformed UTF-8 characters, possibly incorrectly encoded'; break;
			default: $erro= 'Unknown error'; break;
			return true;
		}		
	}
	
}

function loga($str){
	//$dir = "/home/alqteam/job_sc2stats/";
	
//	if(file_exists($dir))
		$ddf = fopen('/home/alqteam/job_sc2stats/sc2stats_'.date("Ymd").'.log','a');
	//else
	//	$ddf = fopen('sc2stats_'.date("Ymd").'.log','a');
	
	fwrite($ddf,"[".date("Y/m/d G:i:s")."] $str".PHP_EOL);
	fclose($ddf);
	
	
	
}

?>
