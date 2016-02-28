<?php
	//config
	$config = array(
		'general'=>array(
			'database' => '********',
			'dbuser' => '********',
			'dbpass' => '********',
			'domain'  => 'http://domain.com',
		),
		'email'=>array(
			'from' => 'email@domain.com',
			'fromName' => 'Your name',
			'smtphost' => 'smtp-relay.gmail.com',
			'smtpauth' => true,
			'smtpuser' => 'email@domain.com',
			'smtppass' => '*********',
			'smtpsec' => 'tls',
			'smtpport' => 587,
		),

		'twilio'=>array(
			'enable' => false,
			'sid' => '********************************',
			'authtoken' => '********************************',
			'number' => 'xxx-xxx-xxxx',
		),

		'recaptcha'=>array(
			'secret' => "************************-********",
			'sitekey' => '************************-****************',
		),
		
		'stripe'=>array(
			'status' => true,
			//'apiKey' => 'sk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			//'pubKey' => 'pk_test_xxxxxxxxxxxxxxxxxxxxxxxxxxxx'
			'apiKey' => 'sk_live_xxxxxxxxxxxxxxxxxxxxxxxxxxxx',
			'pubKey' => 'pk_live_xxxxxxxxxxxxxxxxxxxxxxxxxxxx'
		)
	);
?>
