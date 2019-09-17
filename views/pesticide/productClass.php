<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"></div>
    <div class="row">
        <?php include (ROOT . '/views/layout/leftmenu4pest.php'); ?>

        <div class="col s12 m9 content-row">
            <div class="row">
                <nav class="breadcrumb-nav">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="<?php echo PATH; ?>/pesticide" class="breadcrumb">Главная</a>
                            <a href="javascript:void(0);" class="breadcrumb">Группа препаратов</a>
                        </div>
                    </div>
                </nav>
            </div>
            <h5 class="center"><?php
                if ($productClass) {
                    echo $productClass["name_clproduct_rus"];
                } ?></h5>
            <div class="row title"><p>Выберите препарат по названию</p></div>
            <div class="row center">
                <?php
                while ($row = $firstLetterByProductClass->fetch()) {
                    ?><a href="<?php echo PATH; ?>/pesticide/id-alphabet-<?php echo $row["id_alphabet_rus"]; ?>" class="chip">
                    <?php echo $row["letter"]; ?>
                    </a><?php
                }
                ?>
            </div>
            <div class="row title"><p>Выберите препарат по регистрации на культуру в РФ</p></div>
            <div class="row">
                <?php
                if ($cultureClassListSQL) {
                    while ($row = $cultureClassListSQL->fetch()) { ?>
                        <p><?php echo $row["name_culture_class_rus"]; ?></p>
                        <?php
                        $cultureGroupListSQL = CultureGroup::getListByIdCultureClassAndIdProductClassMerged($row["id_culture_class"], $idProductClass);
                        if ($cultureGroupListSQL) { ?>
                            <ul class="collection">
                            <li class="collection-item">
                            <?php
                            $line = '';
                            while ($rowGrCult = $cultureGroupListSQL->fetch()) {
                                $line .= '<a href="' . PATH . '/pesticide/id-culture-group-' . $rowGrCult["id_culture_group"] . '">'
                                    . $rowGrCult["name_culture_group_rus"] . '</a> | ';
                            }
                            echo trim($line, '| ');
                        } ?>
                        </li>
                        </ul>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="row title"><p>Выберите препарат по производителю</p></div>
            <div class="row center">
                <?php
                if ($manufactureByProductClassListSQL) {
                    while ($row = $manufactureByProductClassListSQL->fetch()) {
                        ?><a href="<?php echo PATH; ?>/pesticide/id-manufacture-<?php echo $row["id_manufacture"]; ?>" class="chip">
                        <?php echo $row["name_manufacture_rus"]; ?>
                        <i class="material-icons">link</i>
                        </a><?php
                    }
                } ?>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>