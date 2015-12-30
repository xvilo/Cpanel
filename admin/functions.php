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

function updateUser($userInfo){
	global $dbh;
	foreach($userInfo['meta_key'] as $key => $value){
		$query  =  $dbh->query("SELECT meta_value FROM invoice_usermeta WHERE meta_key='$key' AND user_id='{$userInfo['id']}'");
	    $q      =  $query->fetch(PDO::FETCH_OBJ);
	    if(isset($q->meta_value) && $value != ""){
	        $sth = $dbh->prepare("UPDATE invoice_usermeta SET meta_value=:meta_value WHERE meta_key=:meta_key AND user_id=:userid;");
	        $sth->bindParam(':meta_key', $key, PDO::PARAM_INT);
			$sth->bindParam(':meta_value', $value, PDO::PARAM_INT);
			$sth->bindParam(':userid', $userInfo['id'], PDO::PARAM_INT);
			$sth->execute();
	    }elseif(!isset($q->meta_value) && $value != ""){
		    $sth = $dbh->prepare("INSERT INTO invoice_usermeta (user_id,meta_key, meta_value) VALUES(:userid, :meta_key, :meta_value)");
	        $sth->bindParam(':meta_key', $key, PDO::PARAM_INT);
			$sth->bindParam(':meta_value', $value, PDO::PARAM_INT);
			$sth->bindParam(':userid', $userInfo['id'], PDO::PARAM_INT);
			$sth->execute();
	    }else{
	    }
    }
}

function getUserData($custnum){
	global $dbh;
	$sth = $dbh->prepare("
	SELECT u.*, m1.meta_value, m2.meta_value, m3.meta_value, m4.meta_value, m5.meta_value, m6.meta_value, m7.meta_value
	FROM invoice_users u
	LEFT OUTER JOIN invoice_usermeta m1
	    on u.id = m1.user_id 
	    and m1.meta_key='adress_street'
	LEFT OUTER JOIN invoice_usermeta m2
	    on u.id = m2.user_id 
	    and m2.meta_key='adress_zip'
	LEFT OUTER JOIN invoice_usermeta m3
	    on u.id = m3.user_id 
	    and m3.meta_key='adress_city'
	LEFT OUTER JOIN invoice_usermeta m4
	    on u.id = m4.user_id 
	    and m4.meta_key='adress_country'
	LEFT OUTER JOIN invoice_usermeta m5
	    on u.id = m5.user_id 
	    and m5.meta_key='user_phone'
	LEFT OUTER JOIN invoice_usermeta m6
	    on u.id = m6.user_id 
	    and m6.meta_key='full_name'
	LEFT OUTER JOIN invoice_usermeta m7
	    on u.id = m7.user_id 
	    and m7.meta_key='company_name'
	WHERE usercustnum=:customer");
	$sth->bindParam(':customer', $custnum, PDO::PARAM_INT);
	$sth->execute();
	return $sth->fetch();
}

if (!isset($_SESSION['user']) && $_SERVER['SCRIPT_NAME'] != '/login.php'){
	header("Location: {$domain}/login/?red=".urlencode($_SERVER['REQUEST_URI']));
}

if ($_SESSION['user_priv'] != '0'){
	die('Not Allowed :(');
}

if (isset($_POST['userdatasubmit'])) {
	updateUser($_POST);
}