<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"></div>
    <div class="row">
        <div class="col s12 m9 content-row">
            <div class="row">
                <nav class="breadcrumb-nav">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="<?php echo PATH; ?>/" class="breadcrumb">Главная</a>
                            <a href="javascript:void(0);" class="breadcrumb">Удобрения</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row title"><p>Выберите класс удобрения</p></div>
            <div class="row">
                <?php
                if ($fertiliserGroupList) {
                    while ($row = $fertiliserGroupList->fetch()) {
                        $fertiliserClassList = FertiliserClass::getListContainGroup($row["id_grfertiliser"]);
                        if ($fertiliserClassList) { ?>
                            <p><?php echo $row["name_grfertilizer_rus"]; ?></p>
                            <ul class="collection">
                            <li class="collection-item">
                            <?php
                            $line = '';
                            while ($rowFertiliserClass = $fertiliserClassList->fetch()) {
                                $line .= '<a href="' . PATH . '/fertiliser/fertiliser-group-' . $row["id_grfertiliser"] .
                                    '/fertiliser-class-' . $rowFertiliserClass["id_clfertiliser"] . '">'
                                    . $rowFertiliserClass["name_clfertilizer_rus"] . '</a> | ';
                            }
                            echo trim($line, '| '); ?>
                            </li>
                            </ul>
                            <?php
                        }
                    }
                }
                ?>
            </div>
            <div class="row title"><p>Выберите производителя удобрения</p></div>
            <div class="row center">
                <?php
                if ($manufactureList) {
                    while ($row = $manufactureList->fetch()) {
                        ?><a href="<?php echo PATH; ?>/fertiliser/id-manufacture-<?php echo $row["id_manufacture"]; ?>" class="chip">
                        <?php echo $row["name_manufacture_rus"]; ?>
                        <i class="material-icons">link</i>
                        </a><?php
                    }
                } ?>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>