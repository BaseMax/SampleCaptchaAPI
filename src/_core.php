<?php
if(!defined("BASE")) {
	exit();
}
require_once "_phpedb.php";
$db=new database();
$db->connect("localhost", "root", "linuxconfig.org");
$db->db="thincaptcha";
$db->create_database($db->db, false);

function getIpAddr(){
	if(!empty($_SERVER["HTTP_CLIENT_IP"])) {
		// share internet
		$ip = $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
		// proxy
		$ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	else if(isset($_SERVER["REMOTE_ADDR"])){
		// webserver
		$ip = $_SERVER["REMOTE_ADDR"];
	}
	else {
		// cli, without webserver
		$ip="::1";
	}
	return $ip;
}

function getUserAgent() {
	if(isset($_SERVER["HTTP_USER_AGENT"])) {
		return $_SERVER["HTTP_USER_AGENT"];
	}
	return "cli";
}
function display($array) {
	header("Content-Type: application/json");
	exit(json_encode($array));
}

function string($input, $length = 5) {
	$lengths = strlen($input);
	$output = "";
	for($i = 0; $i < $length; $i++) {
		$output .= $input[mt_rand(0, $lengths - 1)];
	}
	return $output;
}