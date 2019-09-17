<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"></div>
    <div class="row">
        <?php include (ROOT . '/views/layout/leftmenu4pest.php'); ?>

        <div class="col s12 m9 content-row">
            <div class="row">
                <nav class="breadcrumb-nav">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="<?php echo PATH; ?>/" class="breadcrumb">Главная</a>
                            <?php
                            if ($productClass) { ?>
                            <a href="<?php echo PATH; ?>/pesticide/product-class-<?php echo $productClass["id_clproduct"]; ?>" class="breadcrumb">
                                <?php echo $productClass["name_clproduct_rus"]; ?>
                                </a><?php
                            }

                            // Вывод название Группы пестицида и культуры.
                            if ($productClassByIdProduct) {
                                $id_clproduct = $productClassByIdProduct["id_clproduct"];
                                $id_manufacture = $productClassByIdProduct["id_manufacture"];
                                $rnamemanufacture = $productClassByIdProduct["name_manufacture_rus"];
                                $rnameproduct = $productClassByIdProduct["name_product_rus"];

                                ?>
                                <a href="<?php echo PATH; ?>/pesticide/id-manufacture-<?php echo $productClassByIdProduct["id_manufacture"]; ?>" class="breadcrumb">
                                    <?php echo $rnamemanufacture; ?>
                                </a>
                                <?php
                            } ?>
                            <?php
                            if ($productClassByIdProduct) { ?>
                                <a href="<?php echo PATH; ?>/pesticide/full-info/id-product-<?php echo $idProduct; ?>" class="breadcrumb"><?php
                                    echo $productClassByIdProduct["name_product_rus"];
                                ?></a><?php
                            } ?>
                            <a href="javascript:void(0);" class="breadcrumb">Действ. вещ.</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row">
                <h5 class="center">Действующее вещество <?php
                    // Установление соединения с таблицой Пестицид. Вывод названия пестицида.
                    if ($substance) {
                        echo $substance["name_rus"];
                    } ?></h5>
            </div>
            <div class="row title"><p>Химический класс:</p></div>
            <div class="row">
                <?php
                if ($chemClassList) {
                    while ($row = $chemClassList->fetch()) { ?>
                        <ul class="collection">
                            <li class="collection-item">
                                <div class="row info">
                                    <div class="col s12"><?php echo $row["name_chemclass_rus"]; ?></div>
                                </div>
                            </li>
                        </ul>
                        <?php
                    }
                }?>
            </div>
            <div class="row title"><p>Механизм действия:</p></div>
            <div class="row">
                <?php
                // Установление соединения с таблицой Действующее вещество. Вывод списка механизма действия
                if ($modeActionList) {
                    while ($row = $modeActionList->fetch()) { ?>
                        <ul class="collection">
                            <li class="collection-item">
                                <div class="row info">
                                    <div class="col s6">Обозначение</div>
                                    <div class="col s6"><?php echo $row["short_name_modeaction"]; ?></div>
                                </div>
                            </li>
                        </ul>
                        <ul class="collection">
                            <li class="collection-item">
                                <div class="row info">
                                    <div class="col s6">Краткое описание</div>
                                    <div class="col s6"><?php echo $row["name_modeaction"]; ?></div>
                                </div>
                            </li>
                        </ul>
                        <?php
                    }
                } ?>
            </div>
            <div class="row title">
                <p>Препараты, содержащие д.в. <?php echo $substance["name_rus"]; ?> и зарегистрированные на территории РФ</p>
            </div>
            <div class="row">
                <table class="striped">
                    <tr>
                        <th>Препарат</th>
                        <th>Производитель</th>
                        <th>Культуры</th>
                    </tr>
                    <?php
                    if ($productContainSubstance) {
                        while ($rowsubst = $productContainSubstance->fetch()) {
                            $id_product = $rowsubst["id_product"];
                            $rnameproduct = $rowsubst["name_product_rus"];
                            $rnamemanufacture = $rowsubst["name_manufacture_rus"];
                            $rnameculture = $rowsubst["nameculture"];
                            ?>
                            <tr>
                                <td><?php echo '<a href="' . PATH . '/pesticide/full-info/id-product-' . $id_product . '">' . $rnameproduct . '</a>'; ?></td>
                                <td><?php echo $rnamemanufacture; ?></td>
                                <td><?php echo $rnameculture; ?></td>
                            </tr>
                            <?php
                        }
                    } ?>
                </table>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>