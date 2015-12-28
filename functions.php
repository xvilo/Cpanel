<?php
	
	$database = "thisisd3_cp";
	$dbuser   = "thisisd3_cp";
	$dbpass   = "ooqQe6Sm";
	$domain   = "http://cp.thisisd3.com";
	
	$dbh = new PDO("mysql:host=localhost;dbname={$database}", $dbuser, $dbpass);
	
session_start();

function checkPassword($password, $hash){
	if (password_verify($password, $hash)) {
   		return true;
	} else {
	    return false;
	}
}

function checkLogin($username, $password){
	global $dbh;
	$usernameQuoted = $dbh->quote($username);
	$passwordQuoted = $dbh->quote($password);
	doQuery("SELECT * FROM invoice_users WHERE user_login={$usernameQuoted};");
}

function addUser(){
	$hash = password_hash("Verti0Ndoos", PASSWORD_BCRYPT, array("cost" => 10));
}

function doQuery($query){
	global $dbh;
	global $loginerror;
	global $domain;
	$check = false;
	foreach($dbh->query("$query") as $row) {
    	$check = checkPassword($_POST['login_pass'], $row['user_pass']);
    	$info = $row;
	}
	if(!$check){
		$loginerror = 'Deze combinatie gebruikersnaam/wachtwoord is niet bij ons bekend.';
	}else{
		$_SESSION['user']       = $info['user_login'];
		$_SESSION['user_priv']  = $info['user_status'];
		$_SESSION['user_email'] = $info['user_email'];
		$_SESSION['user_num']   = $info['usercustnum'];
		$_SESSION['user_id']    = $info['ID'];
		header("Location: {$domain}{$_GET['red']}");
	}
}

if (isset($_POST['loginsubmit'])) {
	checkLogin($_POST['login_user'], $_POST['login_pass']);
}

if (!isset($_SESSION['user']) && $_SERVER['SCRIPT_NAME'] != '/login.php'){
	header("Location: {$domain}/login.php?red=".urlencode($_SERVER['REQUEST_URI']));
}