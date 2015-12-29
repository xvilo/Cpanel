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

function addUser(){
	$hash = password_hash("password", PASSWORD_BCRYPT, array("cost" => 10));
}

function getAllUsersOption(){
	global $dbh;
	$sth = $dbh->prepare("SELECT ID, meta_key, meta_value FROM invoice_usermeta INNER JOIN invoice_users ON invoice_users.ID = invoice_usermeta.user_id WHERE meta_key='full_name';");
	$sth->execute();
	return $sth->fetchAll();
}

function getAllUsers(){
	global $dbh;
	$sth = $dbh->prepare("SELECT u.*, m1.meta_value, m2.meta_value FROM invoice_users u LEFT OUTER JOIN invoice_usermeta m1 on u.id = m1.user_id and m1.meta_key='user_phone' LEFT OUTER JOIN invoice_usermeta m2 on u.id = m2.user_id and m2.meta_key='full_name'");
	$sth->execute();
	return $sth->fetchAll();
}

if (!isset($_SESSION['user']) && $_SERVER['SCRIPT_NAME'] != '/login.php'){
	header("Location: {$domain}/login/?red=".urlencode($_SERVER['REQUEST_URI']));
}