<?php
	include_once('../config.php');
	
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
	$sth = $dbh->prepare("SELECT * FROM invoice_usermeta INNER JOIN invoice_users ON invoice_users.ID = invoice_usermeta.user_id WHERE meta_key='full_name';");
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
	    and m7.meta_key='user_company'
	WHERE usercustnum=:customer");
	$sth->bindParam(':customer', $custnum, PDO::PARAM_INT);
	$sth->execute();
	return $sth->fetch();
}

function getInvoices($status=''){
	global $dbh;
	$check = false;
	if($status != ''){
		$sth = $dbh->prepare("SELECT * FROM invoice_invoices WHERE invoice_status=:status");
	}else{
		$sth = $dbh->prepare("SELECT * FROM invoice_invoices");
	}
	$sth->bindParam(':status', $status, PDO::PARAM_INT);
	$sth->execute();
	return $sth->fetchAll();
}

function createInvoice($data){
	global $dbh;
	$userdata       = getUserData($data['userid']);
	$recipient      = $data['userid'];
	$address        = json_encode(array($userdata[9], "", $userdata[10], $userdata[11], $userdata[12]));
	$products       = json_encode($data['products']);
	$subTotal       = 0;
	$invoicedate    = date("Y-m-d H:i:s", strtotime($data['invoice_date']));
	$invoiceduedate = date("Y-m-d H:i:s", strtotime('+14 days', strtotime($data['invoice_date'])));
	foreach($data['products'] as $product) $subTotal += $product[2] * $product[1];
	$tax        = 0.21 * $subTotal;
	$grandTotal = $subTotal + $tax;
	$sth = $dbh->prepare("
	INSERT INTO invoice_invoices (invoice_recipient, invoice_date, invoice_products, invoice_status, invoice_subtotal, invoice_tax, invoice_total, invoice_duedate, invoice_adress, invoice_number, invoice_ordernum) VALUES (:invoice_recipient, :invoice_date, :invoice_products, '0', :invoice_subtotal, :invoice_tax, :invoice_total, :invoice_duedate, :invoice_adress, :invoice_number, :invoice_ordernum);");
	$sth->bindParam(':invoice_recipient', $recipient, PDO::PARAM_STR);
	$sth->bindParam(':invoice_products', $products, PDO::PARAM_STR);
	$sth->bindParam(':invoice_subtotal', $subTotal, PDO::PARAM_INT);
	$sth->bindParam(':invoice_tax', $tax, PDO::PARAM_INT);
	$sth->bindParam(':invoice_total', $grandTotal, PDO::PARAM_INT);
	$sth->bindParam(':invoice_adress', $address, PDO::PARAM_STR);
	$sth->bindParam(':invoice_date', $invoicedate, PDO::PARAM_STR);
	$sth->bindParam(':invoice_duedate', $invoiceduedate, PDO::PARAM_STR);
	$sth->bindParam(':invoice_number', $data['invoice_number'], PDO::PARAM_INT);
	$sth->bindParam(':invoice_ordernum', $data['order_number'], PDO::PARAM_INT);
	$sth->execute();
	global $invoiceCreateOk;
	$invoiceCreateOk= "Factuur is toegevoegd!";
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

if (!isset($_SESSION['user']) && $_SERVER['SCRIPT_NAME'] != '/login.php'){
	header("Location: {$domain}/login/?red=".urlencode($_SERVER['REQUEST_URI']));
}

if ($_SESSION['user_priv'] != '0'){
	die('Not Allowed :(');
}

if (isset($_POST['userdatasubmit'])) {
	updateUser($_POST);
}

if (isset($_POST['invoicesubmit'])) {
	createInvoice($_POST);
}