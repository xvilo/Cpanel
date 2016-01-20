<?php
	include_once('../config.php');
	require_once('../libs/PHPMailer/PHPMailerAutoload.php');
	
	try {
		$dbh = new PDO("mysql:host=localhost;dbname={$config['general']['database']}", $config['general']['dbuser'], $config['general']['dbpass']);
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

function getInvoices($status='', $userid=''){
	global $dbh;
	$check = false;
	if($userid != ''){
		$sth = $dbh->prepare("SELECT * FROM invoice_invoices WHERE invoice_recipient=:uid ORDER BY invoice_date DESC");
		$sth->bindParam(':uid', $userid, PDO::PARAM_STR);
	}elseif($status != ''){
		$sth = $dbh->prepare("SELECT * FROM invoice_invoices WHERE invoice_status=:status ORDER BY invoice_date DESC");
		$sth->bindParam(':status', $status, PDO::PARAM_INT);
	}else{
		$sth = $dbh->prepare("SELECT * FROM invoice_invoices ORDER BY invoice_date DESC");
	}
	$sth->execute();
	return $sth->fetchAll();
}

function createInvoice($data){
	global $dbh;
	$userdata       = getUserData($data['userid']);
	$recipient      = $data['userid'];
	$address        = json_encode(array($userdata[15], $userdata[14], $userdata[9], "{$userdata[10]} {$userdata[11]}", $userdata[12]));
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
	sendMail($userdata['user_email'], "Uw Factuur van D3 Creative Agency" ,"Beste {$userdata[14]},<br/><br/><div>In je account <strong>{$userdata['user_login']}</strong> is een nieuwe factuur voor je aangemaakt met factuurnummer {$data['invoice_number']}. We hebben de factuur ook onderaan dit bericht toegevoegd.<br/><br/>Je hebt aangegeven gebruik te willen maken van overboeking. Let er op dat de factuur op tijd word betaald op om pauzering van je diensten te voorkomen.<br/><br/>Voor eventuele vragen kan je ons altijd bereiken via <a href=\"mailto:sem@thisisd3.com\">sem@thisisd3.com</a> of via de knop 'Contact' in je <a href=\"http://cp.thisisd3.com/contact/\">controlepaneel</a>.<br/></div><p>Met vriendelijke groet,<br/><br />D3 - Creative Agency<br /></p><br><br><hr><br><br>".showInvoice($data['invoice_number']));
	global $invoiceCreateOk;
	$invoiceCreateOk= "Factuur is toegevoegd! En ge-e-mailed naar <i>{$userdata['user_email']}</i>";
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
function showInvoice($id){
	$invoiceData = getFullInvoiceData($id);
	ob_start();
	include('../templates/invoice.php');
	$contents = ob_get_contents();
	ob_end_clean();
	return $contents;
}

function sendMail($recipient, $subject, $data){
	global $dbh;
	global $config;
	
	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = $config['email']['smtphost'];
	$mail->SMTPAuth = $config['email']['smtpauth'];
	$mail->Username = $config['email']['smtpuser'];
	$mail->Password = $config['email']['smtppass'];
	$mail->SMTPSecure = $config['email']['smtpsec'];
	$mail->Port = $config['email']['smtpport'];
	
	$mail->setFrom($config['email']['from'], $config['email']['fromName']);
	$mail->addAddress($recipient);
	$mail->Subject = $subject;
	$mail->Body    = $data;
	$mail->IsHTML(true); 
	if(!$mail->send()) {
		echo 'Message could not be sent.<br>';
	    echo 'Mailer Error: <pre>'.$mail->ErrorInfo.'</pre>';
	    die();
	}
	return true;
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