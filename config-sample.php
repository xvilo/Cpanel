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
		)
	);
?>
