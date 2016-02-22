<?php
include('functions.php');
?>
<!DOCTYPE html>

<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Control Panel | D3 - Creative Agency</title>
    <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/css/normalize.css" type="text/css">
    <link rel="stylesheet" href="/css/skeleton.css" type="text/css">
    <link href="/css/style.css" rel="stylesheet" type="text/css">
    <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
    <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
    <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
    <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5BBAD5">
    <meta name="apple-mobile-web-app-title" content="Control Panel D3 - Creative Agency">
    <meta name="application-name" content="Control Panel D3 - Creative Agency">
    <meta name="msapplication-TileColor" content="#2d89ef">
    <meta name="msapplication-TileImage" content="/mstile-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/intlTelInput.css">
</head>

<body>
    <div id="page">
        <header class="mainhead">
            <nav class="top">
                <div class="container">
	                <a class="navbar-brand brand-long" href="/admin">
		                <svg width="207" height="48">
		                	<image xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="/img/d3-full-logo.svg" src="/img/d3-full-logo.png" width="268" height="48" alt="TransIP"></image>
		                	</svg<span class="sr-only">TransIP</span></a>
                    <ul class="mainnav">
                        <li><a href="/admin/create/">Create</a></li>
                        <li><a href="/admin/users/">Klanten</a></li>
                        <li><a href="/admin/invoices/">Facturen</a></li>
                       <?php if (isset($_SESSION['user'])){ ?>
                        <li class="has-sub"><a href='/user/<?php echo $_SESSION['user_num'] ?>'><?php echo $_SESSION['user'] ?><i class="fa fa-chevron-down"></i> </a>
                            <ul>
                                <li>
                                    <div class="navbar-login">
                                        <p>Klantnummer: <strong><?php echo $_SESSION['user_num'] ?></strong></p>
                                        <p class="small"><?php echo $_SESSION['user_email'] ?></p>
                                        <Br>
                                        <p><a class="button button-primary" href="/user/">Mijn Account</a></p>
                                        <p><a class="button button-primary" href="/logout/">Uitloggen</a></p>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </nav>
        </header>
    </div>
</body>
</html>
