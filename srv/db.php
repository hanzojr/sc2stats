<?php

include_once 'functions.php';

$username = "";
$password = "";
$hostname = "";
$dbname = "";

$conn = mysql_connect($hostname, $username, $password)
or die("Unable to connect to MySQL");

if (!mysql_select_db($dbname, $conn)) {
	loga('Could not select database '.$dbname);
	exit;
}

function queryDB($sql) {
	$rs = mysql_query($sql, $GLOBALS['conn']);
	
	if (!$rs) {
		//loga("DB Error, could not query the database");
		//loga('MySQL Error: ' . mysql_error());
		return false;
	}
	
	return $rs;
}

?>
