<html lang="ru">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="description" content="Средства защиты растений ">
        <meta name="keywords" content="средства защиты растений">
        <meta http-equiv="content-language" content="ru">
        <meta name="publisher" content="EcoPlant Organisation">
        <meta name="copyright" content="&copy; 2006 EcoPlant Organisation. All Rights Reserved.">
        <meta http-equiv="reply-to" content="info@ecoplant.org">
        <meta name="creation_date" content="3.12.2012">
        <title>EcoPlant Агро | Административная часть </title>

        <link rel="stylesheet" href="http://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" href="<?php echo PATH; ?>/template/css/materialize.css" media="screen,projection">
        <link rel="stylesheet" href="<?php echo PATH; ?>/template/css/main.css?date=<?php echo filemtime(ROOT . '/template/css/main.css'); ?>">
    </head>
    <body>
        <nav>
            <div class="nav-wrapper grey darken-4">
                <a href="<?php echo PATH; ?>" class="brand-logo">
                    <img class="logo" src="<?php echo PATH; ?>/template/img/logo_black.png">
                </a>
                <ul id="nav-mobile" class="right hide-on-med-and-down">
                    <?php if (Admin::checkSignIn()) { ?>
                        <li>
                            <a href="<?php echo PATH; ?>">
                                <i class="material-icons left">account_circle</i><?php echo User::getUserName(); ?>: Доступные функции
                            </a>
                        </li>
                        <?php
                            if (UserGroup::accessAdminBlockByIdUser(ACCESS_STAT, User::getId())) { ?>
                                <li>
                                    <a href="<?php echo PATH; ?>/stat/today"><i class="material-icons left">assessment</i>Статистика</a>
                                </li>
                                <?php
                            }

                            if (User::getIdUserGroup(User::getId()) == 1) { ?>
                                <li>
                                    <a href="<?php echo PATH; ?>/userGroup">
                                        <i class="material-icons left">supervisor_account</i>
                                        Настройки групп пользователей
                                    </a>
                                </li>
                                <?php
                            }
                        ?>
                        <li><a href="<?php echo PATH; ?>/signOut">Выйти</a></li>
                    <?php } else { ?>
                        <li>
                            <a href="#">Необходимо авторизоваться</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </nav>
    <main>
        <div class="container">
            <div class="row"><div class="col s12"></div></div>