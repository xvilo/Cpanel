<?php
	require_once('libs/autoload.php');
	require_once('libs/PHPMailer/PHPMailerAutoload.php');
	require_once('config.php');
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

function gen_uuid() {
    return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),mt_rand( 0, 0xffff ),mt_rand( 0, 0x0fff ) | 0x4000,mt_rand( 0, 0x3fff ) | 0x8000, mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ));
}

if (isset($_POST['loginsubmit'])) {
	if ($siteKey === '' || $secret === ''){
		$loginerror = 'Config Error.';
		return;
	}elseif (isset($_POST['g-recaptcha-response'])){
		$recaptcha = new \ReCaptcha\ReCaptcha($secret);
		$resp = $recaptcha->verify($_POST['g-recaptcha-response'], $_SERVER['REMOTE_ADDR']);
		if ($resp->isSuccess()){
			checkLogin($_POST['login_user'], $_POST['login_pass']);
		}else{
			$loginerror = 'Captcha incorrect.';
			return;
		}
	}
}

function createNewPasswordLostToken(){
	global $dbh;
	$uuid = gen_uuid();
	$user_name = $_POST['reset_user'];
	
	$sth = $dbh->prepare("UPDATE `invoice_users` SET user_password_reset_token=:token, user_password_reset_date=NOW() WHERE user_login=:user;");
	$sth->bindParam(':token', $uuid, PDO::PARAM_STR);
	$sth->bindParam(':user', $user_name, PDO::PARAM_STR);
	$sth->execute();
	
	$sth = $dbh->prepare("SELECT user_email FROM `invoice_users` WHERE user_login=:user;");
	$sth->bindParam(':user', $user_name, PDO::PARAM_STR);
	$sth->execute();
	$data = $sth->fetch();
	
	$mail_host = 'smtp-relay.gmail.com';
	$mail_SMTPAuth = true;
	$mail_Username = 'sem@thisisd3.com';
	$mail_Password = 'Verti0Ndoos';
	$mail_SMTPSecure = 'tls';
	$mail_Port = 587;
	$mail_setFrom_email = 'sem@thisisd3.com';
	$mail_setFrom_name= 'sem schilder';
	
	
	$mail = new PHPMailer;$mail->isSMTP();
	$mail->Host = $mail_host;
	$mail->SMTPAuth = $mail_SMTPAuth;
	$mail->Username = $mail_Username;
	$mail->Password = $mail_Password;
	$mail->SMTPSecure = $mail_SMTPSecure;
	$mail->Port = $mail_Port;
	
	$mail->setFrom($mail_setFrom_email, $mail_setFrom_name);
	$mail->addAddress($data['user_email']);
	$mail->Subject = 'Wachtwoord reset D3 Control Panel';
	$mail->Body    = "Hallo,
	
Je hebt een wachtwoord reset aangevraagd. Je reset token is: '$uuid' (zonder ''). 
Vul deze in bij het invul veld en vervolgens voer je je nieuwe wachtwoord in.<br> 

Heb je de pagina niet meer open staan? Vraag dan opnieuw een wachtwoord aan, je ontvangt dan een nieuwe token. Deze is dan niet meer bruikbaar.
LET OP: Je code is 24 uur geldig.

Groet,
Sem";
	if(!$mail->send()) {
		echo 'Message could not be sent.<br>';
	    echo 'Mailer Error: ' . $mail->ErrorInfo;
	    die();
	}
	return true;
}

function doPasswordReset(){
	global $dbh;
	$uuid = $_POST['reset_token'];
	$password = password_hash($_POST['reset_pass'], PASSWORD_BCRYPT, array("cost" => 10));;
	
	$sth = $dbh->prepare("SELECT * FROM `invoice_users` WHERE `user_password_reset_token`=:token;");
	$sth->bindParam(':token', $uuid, PDO::PARAM_STR);
	$sth->execute();
	$count = $sth->rowCount();
	if($count == 0){
		die('Er is iets fout gegaan. Check of de token juist is.');
	}
	$data = $sth->fetch();
	
	/* To Do, a 24 hour check
	if(time() - $data['user_password_reset_date'] >! 60*60*24){
		die('Deze token ('.$uuid.') is niet meer geldig. Vraag een nieuwe aan.');
	}
	*/
	
	$sth = $dbh->prepare("UPDATE `invoice_users` SET user_pass=:password, user_password_reset_token='' WHERE user_password_reset_token=:token;");
	$sth->bindParam(':token', $uuid, PDO::PARAM_STR);
	$sth->bindParam(':password', $password, PDO::PARAM_STR);
	$sth->execute();
	
	return 'Je wachtwoord is met success veranderd!';
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
	    and m7.meta_key='user_company'
	WHERE usercustnum=:customer");
	$sth->bindParam(':customer', $custnum, PDO::PARAM_INT);
	$sth->execute();
	return $sth->fetch();
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

if (isset($_POST['loginforgotsubmit'])) {
	createNewPasswordLostToken();
}

if (isset($_POST['loginforgotresetsubmit'])) {
	$loginsuccess = doPasswordReset();
}

if (!isset($_SESSION['user']) && $_SERVER['SCRIPT_NAME'] != '/login.php'){
	header("Location: {$domain}/login/?red=".urlencode($_SERVER['REQUEST_URI']));
}

if (isset($_POST['userdatasubmit'])) {
	updateUser($_POST);
}