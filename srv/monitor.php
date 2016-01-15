<?php

$api = new APIStats();

$api->getAPIStats();


class APIStats {
	var
	$engineVer,
	$serverTime,
	$paidOps,
	$callStat,
	$calls = array();

	function getAPIStats() {
		$xml = @simplexml_load_file("https://sciigears.appspot.com/parsing?protVer=1&op=info&apiKey=U25UU-V061N-LM6XA-SLDPV-AA6M9");

		if (!$xml) {
			echo "General Error.";
			exit(1);
		}

		if ($xml->result['code'] != 0) {
			loga("Erro ao carregar Info da API");
		} else {
			
			//echo print_r($xml);
			
			$this->engineVer = $xml->engineVer['value'];
			$this->serverTime = $xml->serverTime['value'];
			$this->paidOps = $xml->paidOps['value'];
			$this->availOps = $xml->availOps['value'];
			
			echo $this->engineVer."<BR>";
			echo $this->serverTime."<BR>";
			echo $this->paidOps."<BR>";
			echo $this->availOps."<BR>";
				
			$GLOBALS['calls'][] = new Call("TOTAL");
				
			foreach ($GLOBALS['calls'] as $call) {

				$call->apiCalls = $xml->callStats->callStat->apiCalls['value'];
				$call->usedOps = $xml->callStats->callStat->usedOps['value'];
				$call->avgExecTime = $xml->callStats->callStat->avgExecTime['value'] . $xml->callStats->callStat->avgExecTime['unit'];
				$call->deniedCalls = $xml->callStats->callStat->deniedCalls['value'];
				$call->errors = $xml->callStats->callStat->errors['value'];
				$call->infoCalls = $xml->callStats->callStat->infoCalls['value'];
				$call->avgInfoExecTime = $xml->callStats->callStat->avgInfoExecTime['value'] . $xml->callStats->callStat->avgInfoExecTime['unit'];
				$call->mapInfoCalls = $xml->callStats->callStat->mapInfoCalls['value'];
				$call->avgMapInfoExecTime = $xml->callStats->callStat->avgMapInfoExecTime['value'] . $xml->callStats->callStat->avgMapInfoExecTime['unit'];
				$call->parseRepCalls = $xml->callStats->callStat->parseRepCalls['value'];
				$call->avgParseRepExecTime = $xml->callStats->callStat->avgParseRepExecTime['value'] . $xml->callStats->callStat->avgParseRepExecTime['unit'];
				$call->profInfoCalls = $xml->callStats->callStat->profInfoCalls['value'];
				$call->avgProfInfoExecTime = $xml->callStats->callStat->avgProfInfoExecTime['value'] . $xml->callStats->callStat->avgProfInfoExecTime['unit'];

				echo "apiCalls: " . $call->apiCalls;
				echo "usedOps: " . $call->usedOps."<BR>";
				echo "avgExecTime: " . $call->avgExecTime."<BR>";
				echo "deniedCalls: " . $call->deniedCalls."<BR>";
				echo "errors: " . $call->errors."<BR>";
				echo "infoCalls: " . $call->infoCalls."<BR>";
				echo "avgInfoExecTime: " . $call->avgInfoExecTime."<BR>";
				echo "mapInfoCalls: " . $call->mapInfoCalls."<BR>";
				echo "avgMapInfoExecTime: " . $call->avgMapInfoExecTime."<BR>";
				echo "parseRepCalls: " . $call->parseRepCalls."<BR>";
				echo "avgParseRepExecTime: " . $call->avgParseRepExecTime."<BR>";
				echo "profInfoCalls: " . $call->profInfoCalls."<BR>";
				echo "avgProfInfoExecTime: " . $call->avgProfInfoExecTime."<BR>";

			}

		}

	}
}

class Call {
	var
	$day, $apiCalls, $usedOps, $avgExecTime,
	$deniedCalls, $errors, $infoCalls, $avgInfoExecTime, $mapInfoCalls,
	$avgMapInfoExecTime, $parseRepCalls, $avgParseRepExecTime, $profInfoCalls, $avgProfInfoExecTime;

	function __construct($date) {
		$this->day = $date;
	}
}

?>

