<?php State::save(); ?>
<html lang="ru">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="Средства защиты растений ">
    <meta name="keywords" content="средства защиты растений">
    <meta http-equiv="content-language" content="ru">
    <meta name="publisher" content="EcoPlant Organisation">
    <meta name="copyright" content="&copy; 2006 EcoPlant Organisation. All Rights Reserved.">
    <meta http-equiv="reply-to" content="admin@ecoplant.org">
    <meta name="creation_date" content="3.12.2012">
    <title>EcoPlant Агро</title>

    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo PATH; ?>/template/css/materialize.css?date=<?php echo filemtime(ROOT . '/template/css/materialize.css'); ?>" media="screen,projection"/>
    <link href="<?php echo PATH; ?>/template/css/main.css?date=<?php echo filemtime(ROOT . '/template/css/main.css'); ?>" rel="stylesheet">
</head>
<body>
<nav class="green">
    <div class="nav-wrapper">
        <a href="<?php echo PATH; ?>/" class="brand-logo">
            <div><img src="<?php echo PATH; ?>/template/img/var1_1_4_1_end.svg" alt=""></div>
        </a>
        <form class="nav-search hide-on-med-and-down">
            <div class="input-field">
                <input id="search" class="search_input" type="search" required autocomplete="off">
                <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                <i class="material-icons">close</i>
            </div>
            <div class="search_autocomplete"></div>
        </form>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="<?php echo PATH; ?>/imycopathogen.php" class="link1">Микопатогены</a></li>
            <li><a href="<?php echo PATH; ?>/pesticide" class="link1">Пестициды</a></li>
        </ul>
    </div>
</nav>
<main>
    <div class="container">