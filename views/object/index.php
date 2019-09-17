<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"></div>
    <div class="row">
        <?php include (ROOT . '/views/layout/leftmenu4object.php'); ?>

        <div class="col s12 m9 content-row">
            <div class="row">
                <nav class="breadcrumb-nav">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="<?php echo PATH; ?>/" class="breadcrumb">Главная</a>
                            <a href="javascript:void(0);" class="breadcrumb">Вредные объекты</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row title"><p>Выберите объект по названию</p></div>
            <div class="row center">
                <?php
                if ($firstLetterObjectListSQL) {
                    while ($row = $firstLetterObjectListSQL->fetch()) {
                        ?><a href="<?php echo PATH; ?>/object/id-alphabet#<?php echo $row["id_alphabet_rus"]; ?>" class="chip">
                        <?php echo $row["letter"]; ?>
                        </a><?php
                    }
                } ?>
            </div>
            <div class="row title"><p>Выберите объект по поражению культуры</p></div>
            <div class="row">
                <?php
                // Установка с таблицей Культура
                if ($cultureClassByExistObjectSQL) {
                    while ($row = $cultureClassByExistObjectSQL->fetch()) { ?>
                        <p><?php echo $row["name_culture_class_rus"]; ?></p>
                        <?php
                        $cultureByCultureGroupSQL = Culture::getListByIdCultureClass($row["id_culture_class"]);
                        if ($cultureByCultureGroupSQL) { ?>
                            <ul class="collection">
                                <li class="collection-item">
                                <?php
                                    $line = '';
                                    while ($rowGrCult = $cultureByCultureGroupSQL->fetch()) {
                                        $line .= '<a href="' . PATH . '/object/id-culture-' . $rowGrCult["id_culture"] . '">'
                                            . $rowGrCult["name_rus"] . '</a> | ';
                                    }
                                    echo trim($line, '| '); ?>
                                </li>
                            </ul><?php
                        }
                    }
                }

//                if ($cultureWithoutGroupSQL) { ?>
<!--                    <p>Культуры без группы</p>-->
<!--                    <ul class="collection">-->
<!--                        <li class="collection-item">-->
<!--                            --><?php
//                            $line = '';
//                            while ($row = $cultureWithoutGroupSQL->fetch()) {
//                                $line .= '<a href="' . PATH . '/object/id-culture#' . $row["id_culture"] . '">'
//                                    . $row["name_rus"] . '</a> | ';
//                            }
//                            echo trim($line, '| ');
//                            ?>
<!--                        </li>-->
<!--                    </ul>-->
<!--                    --><?php
//                }
                ?>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>