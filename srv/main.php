<?php
header('Content-type: text/html; charset=utf-8');

ini_set('max_execution_time', 300); //300 seconds = 5 minutes

include_once 'db.php'; //acesso ao DB
include_once 'class.php'; //acesso a classe Player
include_once 'functions.php'; //acesso a funcoes diversas

//cria um vetor e carrega a lista de players ativos da tabela
$players = loadPlayerList();

//limpa os dados do dia de hoje da tabela
cleanDay(); 


 //$player = $players[0];


//varre o vetor de Players carregando o XML do webservice e salvando na tabela
foreach ($players as $player) {
	
// 	//verifica se ocorreu erro ao acessar o webservice
 	if ($player->loadJSONData()) {//carrega todos os dados do JSON na instancia de Player

 		$player->saveHistoryData(); //carrega e persiste os dados pertinentes a historico de partidas;
		$player->getIACounters();
		
 		$player->saveSeasonData(); //persiste os dados de season do objeto Player
 		$player->savePlayerData(); //persiste os dados do Player
		

	} else {

		loga("ERROR! Cant get data from $player->name.");
	}
}

//echo getToday();


echo "Finish!<BR>";

?>
