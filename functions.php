<?php
	
	$database = "thisisd3_cp";
	$dbuser   = "thisisd3_cp";
	$dbpass   = "ooqQe6Sm";
	$domain   = "http://cp.thisisd3.com";
	try {
		$dbh = new PDO("mysql:host=localhost;dbname={$database}", $dbuser, $dbpass);
	} catch (PDOException $e) {
	    print "Error: " . $e->getMessage() . "<br/>";
	    die();
	}
	
session_start();

function checkPassword($password, $hash){
	if (password_verify($password, $hash)) {
   		return true;
	} else {
	    return false;
	}
}

function checkLogin($username, $password){
	doLoginQuery($username, $password);
}

function addUser(){
	$hash = password_hash("password", PASSWORD_BCRYPT, array("cost" => 10));
}

function doLoginQuery($username, $password){
	global $dbh;
	global $loginerror;
	global $domain;
	$check = false;
	$sth = $dbh->prepare("SELECT * FROM invoice_users WHERE user_login=:username;");
	$sth->bindParam(':username', $username, PDO::PARAM_STR);
	$sth->execute();
		
	foreach($sth as $row) {
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

function getInvoices($userid){
	global $dbh;
	$check = false;
	$sth = $dbh->prepare("SELECT invoice_id, invoice_status, invoice_number, invoice_duedate, invoice_total FROM invoice_invoices WHERE invoice_recipient=:userid;");
	$sth->bindParam(':userid', $_SESSION['user_id'], PDO::PARAM_STR);
	$sth->execute();
	return $sth->fetchAll();
}

function getFullInvoiceData($invoicenum=''){
	global $dbh;
	if($invoicenum == ''){
		$sth = $dbh->prepare("SELECT * FROM invoice_invoices;");
	}else{
		$sth = $dbh->prepare("SELECT * FROM invoice_invoices WHERE invoice_number=:invoice_num;");
	}
	$sth->bindParam(':invoice_num', $invoicenum, PDO::PARAM_INT);
	$sth->execute();
	return $sth->fetch();
}

function getInvoiceStatus($status){
	if($status == 0){
		return "&nbsp;";
	}elseif($status == 1){
		return '<i class="fa fa-check payed"></i>';
	}
}

if (isset($_POST['loginsubmit'])) {
	checkLogin($_POST['login_user'], $_POST['login_pass']);
}

if (!isset($_SESSION['user']) && $_SERVER['SCRIPT_NAME'] != '/login.php'){
	header("Location: {$domain}/login/?red=".urlencode($_SERVER['REQUEST_URI']));
}