<?php
class Player {
	var
		$idPlayer, $bnetProfileUrl, $bnetId, $realm,
		$name,$portraitX,$portraitY, $portraitUrl, $actualLeague,
		$achievementPoints, $totalCareerGames, $gamesThisSeason,
		$winsThisSeason,$lossThisSeason, $swarmLevel,
		$terranWins, $zergWins, $protossWins, $ratio,
		$highestSolo_times, $highestSolo_league,
		$highestTeam_times, $highestTeam_league,
		$seasonId, $seasonYear, $seasonNumber,
		$iaWins, $iaLoss;

	function __construct($id, $profile) {
		$this->idPlayer = $id;
		$this->bnetProfileUrl = $profile;
		
		
		$this->getRealId();

	}

	
	private function getRealId() {
		//http://us.battle.net/sc2/en/profile/96953/2/HanzoJR/
		$param  = strstr($this->bnetProfileUrl, 'battle.net/');
	
		list ($site, $game, $lang, $method, $bnetId, $realm, $player) = explode ('/', $param);
		
		//echo "$game<br>$lang<br>$bnetId<br>$realm<br>$player";
		
		
		$this->bnetId = $bnetId;
		$this->realm = $realm;
		$this->name = $player;

	}
	
	function loadJSONData() {
		
		$apikey = "fxhpgcfu4m2m9ssecb3vvq56ws9yssfc";
		$locale = "pt_BR";
		
		//https://us.api.battle.net/sc2/profile/96953/2/HanzoJR/?locale=pt_BR&apikey=fxhpgcfu4m2m9ssecb3vvq56ws9yssfc
		
		$url = "https://us.api.battle.net/sc2/profile/$this->bnetId/$this->realm/$this->name/?locale=$locale&apikey=$apikey";
		
		//$url = "http://us.battle.net/api/sc2/profile/$this->bnetId/$this->realm/$this->name/";
		
		//$url = "http://us.battle.net/api/sc2/profile/267885/2/Dani/";
		
		//$url = "http://us.battle.net/api/sc2/profile/96953/2/HanzoJR/";
		
		//echo "tentando abrir: $url<br>";
		
		//echo $url . "<BR>";
		
		$content = @file_get_contents($url);

		if(!$content)
			return false;
		$json = json_decode($content);
		
		if(isset($json->status)) {
			if ($json->status = "nok") {
				return false;
				
			}
		} 
		
		$this->name = $json->displayName;
		$this->portraitX = $json->portrait->x;
		$this->portraitY = $json->portrait->y;
		$this->portraitGroup = 0;
		$this->portraitUrl = $json->portrait->url;
		$this->achievementPoints = $json->achievements->points->totalPoints;
		$this->totalCareerGames = $json->career->careerTotalGames;
		$this->gamesThisSeason = $json->career->seasonTotalGames;
		$this->swarmLevel = $json->swarmLevels->level;	
		$this->actualLeague = @$json->career->league;
		
		$this->terranWins  = $json->career->terranWins;
		$this->zergWins = $json->career->zergWins;
		$this->protossWins  = $json->career->protossWins;
		
		$this->winsThisSeason = $this->terranWins + $this->zergWins + $this->protossWins;
		$this->lossThisSeason = $this->gamesThisSeason - $this->winsThisSeason;
		
		$this->highestSolo_times  = 1;
		$this->highestSolo_league  = @$json->career->highest1v1Rank; 
		$this->highestTeam_times  = 1;
		$this->highestTeam_league  = @$json->career->highestTeamRank; 
			
		if ($this->lossThisSeason == 0)
			$this->ratio = 0;
		else
			$this->ratio = number_format($this->winsThisSeason / $this->lossThisSeason, 2);
		
		$this->seasonYear  = $json->season->seasonYear;
		$this->seasonNumber  = $json->season->seasonNumber;
		$this->seasonId  = $json->season->seasonId;
		
		loga($this->name.": JSON loaded Ok.");
		
		//echo "seasonYear: $this->seasonYear / seasonNumber: $this->seasonNumber";
		
		return true;
	
		
	}
	


	function loadXMLData() {
		$xml = @simplexml_load_file("https://sciigears.appspot.com/parsing?protVer=1&op=profInfo&apiKey=U25UU-V061N-LM6XA-SLDPV-AA6M9&bnetProfileUrl=$this->bnetProfileUrl");

		if (!$xml) {
			echo "ERRO: ".@$cache[$key];
			exit(1);
		}
		
		if ($xml->result['code'] != 0) {
			loga("Erro ao carregar Profile do player $this->name");
		} else {

			$this->name = $xml->profInfo->playerId['name'];
			$this->portraitColumn = $xml->profInfo->portrait ['column'];
			$this->portraitRow = $xml->profInfo->portrait ['row'];
			$this->portraitGroup = $xml->profInfo->portrait ['group'];
			$this->achievementPoints = $xml->profInfo->achievementPoints['value'];
			$this->totalCareerGames = $xml->profInfo->totalCareerGames['value'];
			$this->gamesThisSeason = $xml->profInfo->gamesThisSeason['value'];
			$this->terranWins  = $xml->profInfo->terranWins ['value'];
			$this->zergWins = $xml->profInfo->zergWins['value'];
			$this->protossWins  = $xml->profInfo->protossWins ['value'];
			$this->winsThisSeason = $this->terranWins + $this->zergWins + $this->protossWins;
			$this->lossThisSeason = $this->gamesThisSeason - $this->winsThisSeason;
			$this->highestSolo_times  = $xml->profInfo->highestSoloFinishLeague ['timesAchieved'];
			$this->highestSolo_league  = $xml->profInfo->highestSoloFinishLeague ['value'];
			$this->highestTeam_times  = $xml->profInfo->highestTeamFinishLeague ['timesAchieved'];
			$this->highestTeam_league  = $xml->profInfo->highestTeamFinishLeague ['value'];
			
			if ($this->lossThisSeason == 0)
				$this->ratio = 0;
			else
				$this->ratio = number_format($this->winsThisSeason / $this->lossThisSeason, 2);
				
			loga($this->name.": XML loaded Ok.");
		}

	}
	
	function savePlayerData() {
		$sql = "

		UPDATE tb_player SET
			 tx_player = '$this->name',
			 portraitX = $this->portraitX,
			 portraitY = $this->portraitY,
			 portraitUrl = '$this->portraitUrl',
			 swarmLevel = $this->swarmLevel,
			 actualLeague = '$this->actualLeague',
			 achievementPoints = $this->achievementPoints,
			 totalCareerGames = $this->totalCareerGames,
			 highestSolo_times = $this->highestSolo_times,
			 highestSolo_league = '$this->highestSolo_league',
			 highestTeam_times = $this->highestTeam_times,
			 highestTeam_league = '$this->highestTeam_league',
			 ia_wins = $this->iaWins,
			 ia_loss = $this->iaLoss
		WHERE
			id_player = $this->idPlayer
	
					";
		
		//echo $sql;
			
		if(!queryDB($sql)) 
			loga("$this->name: ERROR! Cant save Player data.");
		else
			loga("$this->name: Player data Ok.");
		

	}

	function saveSeasonData() {
	
		$sql = "
			INSERT INTO tb_data(dt_stamp,id_player,id_season, seasonYear, seasonNumber,
				gamesThisSeason,winsThisSeason,lossThisSeason,
				terranWins,protossWins,zergWins,ratio)
			VALUES('".getToday()."',$this->idPlayer,$this->seasonId, $this->seasonYear, $this->seasonNumber,
				$this->gamesThisSeason,$this->winsThisSeason,$this->lossThisSeason,
				$this->terranWins,$this->protossWins,$this->zergWins,$this->ratio);
			";
		
		//echo $sql;
		
		if(!queryDB($sql)) 
			loga($this->name . ": ERROR! Cant save Season data.");
		else
			loga($this->name . ": Season data Ok.");

	}
	
	function getLastHistory() {
	
		$sql = "select max(date) as ultima from tb_history where id_player = $this->idPlayer";
	
		$rs = queryDB($sql);

		$row = mysql_fetch_object($rs);
	
		if($row->ultima==null)
			return new DateTime('2000-01-01');
	
		return new DateTime($row->ultima);
	
	
	}

	function getIACounters() {
		$this->iaWins = $this->getWinsAgainstIA();
		$this->iaLoss = $this->getLossAgainstIA();
		
		$this->winsThisSeason = $this->winsThisSeason - $this->iaWins;
		
		$this->lossThisSeason = $this->lossThisSeason - $this->iaLoss;
		$this->gamesThisSeason =  $this->winsThisSeason + $this->lossThisSeason;
	}
	
	private function getWinsAgainstIA() {
		$sql = "select count(*) wins from tb_history
		where
		type='CO_OP'
		and decision = 'WIN'
		and seasonYear = $this->seasonYear
		and seasonNumber = $this->seasonNumber
		and id_player = $this->idPlayer";
		
		
		//echo "SQL: $sql";
		
		$rs = queryDB($sql);
		
		$row = mysql_fetch_object($rs);
		
		($row->wins==null)? $result = 0 : $result = $row->wins;
		
 		return $result;		
		
		
	}
	
	private function getLossAgainstIA() {
		$sql = "select count(*) loss from tb_history
				where
					type='CO_OP'
					and decision = 'LOSS'
					and seasonYear = $this->seasonYear
					and seasonNumber = $this->seasonNumber
					and id_player = $this->idPlayer";
		
		$rs = queryDB($sql);
		
		$row = mysql_fetch_object($rs);
	
		($row->loss==null)? $result = 0 : $result = $row->loss;
		
 		return $result;		
		

	}	
	
	function saveHistoryData() {
		//      https://us.api.battle.net/sc2/profile/96953/2/HanzoJR/matches?locale=en_US&apikey=fxhpgcfu4m2m9ssecb3vvq56ws9yssfc
		$url = "https://us.api.battle.net/sc2/profile/$this->bnetId/$this->realm/$this->name/matches?locale=en_US&apikey=fxhpgcfu4m2m9ssecb3vvq56ws9yssfc";
	
	//	echo "URL: $url<br>";
		
		$content = @file_get_contents($url);
	
		if(!$content) {
			echo "Erro ao pegar conteudo.";
			return false;
			
		}
			
	
		$json = json_decode($content);
	
		if(isset($json->status)) 	
			if ($json->status = "nok") {
				echo "Erro ao decodificar JSON.";
				return false;
				
			}
	
			 $gmtManaus = 4*3600;

	
			// 	$sql = "truncate table tb_history";
			// 	queryDB($sql);
	
	
			$dateUltima = $this->getLastHistory();
	
// 			 	echo "data calculada: ".$dateUltima->format('Y-m-d H:i:s') . "\n";
	
	
			foreach ($json->matches as $match) {
	
				$match->date=$match->date-$gmtManaus;
	
				$datePartida = gmdate('Y-m-d H:i:s',$match->date);

				if($dateUltima < new DateTime($datePartida) ) {
	
					$sql = "INSERT INTO tb_history (id_player, seasonYear, seasonNumber, map, type, decision, speed, date) VALUES (
					$this->idPlayer, $this->seasonYear, $this->seasonNumber, '$match->map', '$match->type','$match->decision','$match->speed', '$datePartida')";
	
					// 	echo $sql . "<br><br>";
	
					if(!queryDB($sql))
						loga($this->name.": ERROR! Cant save History data.");
					else
						loga($this->name.": History data Ok.");
				}
	
			}

	}	


}
	
?>
