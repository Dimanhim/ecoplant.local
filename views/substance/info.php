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
                            <?php
                            if ($productClass) { ?>
                            <a href="<?php echo PATH; ?>/pesticide/product-class-<?php echo $productClass["id_clproduct"]; ?>" class="breadcrumb">
                                <?php echo $productClass["name_clproduct_rus"]; ?>
                                </a><?php
                            } ?>
                            <?php
                            if ($productClassByProductAndCulture) {
                                $id_clprod = $productClassByProductAndCulture["id_clproduct"];
                                $id_culture_group = $productClassByProductAndCulture["id_culture_group"];
                                $rnameproduct = $productClassByProductAndCulture["name_product_rus"];
                                $rnameclprod = $productClassByProductAndCulture["name_clproduct_rus"];
                                $rnameculture = $productClassByProductAndCulture["name_rus"];
                            } ?>
                            <a href="<?php echo PATH; ?>/pesticide/id-culture-group-<?php echo $id_culture_group; ?>" class="breadcrumb"><?php echo $rnameculture; ?></a>
                            <a href="<?php echo PATH; ?>/pesticide/info/id-product-<?php echo $idProduct; ?>/id-culture-<?php echo $idCulture; ?>" class="breadcrumb"><?php echo $rnameproduct; ?></a>
                            <a href="javascript:void(0);" class="breadcrumb">Действ. вещ.</a>
                        </div>
                    </div>
                </nav>
            </div>
            <?php
            if ($productClassByProductAndCulture) {
                $id_clprod = $productClassByProductAndCulture["id_clproduct"];
                $rnameproduct = $productClassByProductAndCulture["name_product_rus"];
                $rnameclprod = $productClassByProductAndCulture["name_clproduct_rus"];
                $rnameculture = $productClassByProductAndCulture["name_rus"];
            }
            // Установление соединения с таблицой Пестицид. Вывод названия пестицида.
            if ($substance) {
                $id_substance = $substance["id_substance"];
                $rnamesubstance = $substance["name_rus"];
            } ?>
            <div class="row"><h5 class="center">Действующее вещество <?php echo $rnamesubstance;?></h5></div>
            <div class="row title"><p>Химический класс:</p></div>
            <div class="row">
                <?php
                // Установление соединения с таблицой Действующее вещество. Вывод списка хим.класса
                if ($chemClassList) {
                    while ($rowchemcl = $chemClassList->fetch()) {
                        $rnamechemcl = $rowchemcl["name_chemclass_rus"]; ?>
                        <ul class="collection">
                            <li class="collection-item">
                                <div class="row info">
                                    <div class="col s12"><?php echo $rnamechemcl; ?></div>
                                </div>
                            </li>
                        </ul>
                        <?php
                    }
                }?>
            </div>
            <div class="row title"><p>Зарегистрированные в РФ нормы внесения действующего вещества <?php echo $rnamesubstance; ?> на культуру <?php echo $rnameculture; ?></p></div>
            <div class="row">
                <?php
                if ($productClassList) {
                    while ($rowclprod = $productClassList->fetch()) {
                        $rnameclproduct = $rowclprod["name_clproduct_rus"]; ?>
                        <p class="center"><?php echo $rnameclproduct; ?></p>
                        <?php
                        // Установление соединения с таблицой Продукт и Действующее вещество. Вывод списка продуктов, которые содержат данное д.в.
                        $substance = Product::getListByIdSubstanceAndIdCultureAndIdProductClass($idSubstance, $idCulture, $rowclprod["id_clproduct"]);
                        if ($substance) { ?>
                        <table class="striped">
                            <tr>
                                <th>Препарат</th>
                                <th>Производитель</th>
                                <th colspan="2">Норма внесения</th>
                            </tr>
                            <tr>
                                <th colspan="2"></th>
                                <th>мин. (г/га)</th>
                                <th>макс. (г/га)</th>
                            </tr>
                            <?php
                                while ($rowsubst = $substance->fetch()) {
                                    $id_product = $rowsubst ["id_product"];
                                    $rnameproduct = $rowsubst ["name_product_rus"];
                                    $rnamemanufacture = $rowsubst ["name_manufacture_rus"];
                                    $minconcentr = $rowsubst ["minconcentr"];
                                    $maxconcentr = $rowsubst ["maxconcentr"];
                                    // Вычисления
                                    $min = sprintf("%.2f", $minconcentr);
                                    $max = sprintf("%.2f", $maxconcentr);
                                    ?>
                                    <tr>
                                        <td><?php echo '<a href="' . PATH . '/pesticide/' . $id_product . '">' . $rnameproduct . '</a>'; ?></td>
                                        <td><?php echo $rnamemanufacture; ?></td>
                                        <td><?php echo $min; ?></td>
                                        <td><?php echo $max; ?></td>
                                    </tr>
                                    <?php
                                }
                            ?>
                        </table>
                        <?php
                        } else {
                            echo '<p class="center">Нет данных</p>';
                        }
                    }
                } ?>
            </div>
            <div class="row"></div>
            <div class="row title">
                <p>Стоимость обработки 1 га культуры 1 г действующего вещества <?php echo $rnamesubstance; ?></p>
            </div>
            <div class="row">
                <?php
                if ($productClassList) {
                    $productClassList->execute();
                    while ($rowclprod = $productClassList->fetch()) {
                        $rnameclproduct = $rowclprod["name_clproduct_rus"];
                        ?>
                        <p class="center"><?php echo $rnameclproduct; ?></p>
                        <?php
                        // Установление соединения с таблицой Продукт и Действующее вещество. Вывод списка продуктов, которые содержат данное д.в.
                        $substance = Product::getListByIdSubstanceAndIdCultureAndIdProductClass($idSubstance, $idCulture, $rowclprod["id_clproduct"]);
                        ?>
                        <table class="striped">
                            <tr>
                                <th>Препарат</th>
                                <th>Производитель</th>
                                <th colspan="2">Стоимость, вкл. НДС</th>
                            </tr>
                            <tr>
                                <th colspan="2"></th>
                                <th>мин. (руб./га)</th>
                                <th>макс. (руб./га)</th>
                            </tr>
                            <?php
                            while ($rowsubst = $substance->fetch()) {
                                $id_product = $rowsubst ["id_product"];
                                $rnameproduct = $rowsubst ["name_product_rus"];
                                $rnamemanufacture = $rowsubst ["name_manufacture_rus"];
                                $minrate = $rowsubst ["min_rate"];
                                $maxrate = $rowsubst ["max_rate"];
                                $minconcentr = $rowsubst ["minconcentr"];
                                $maxconcentr = $rowsubst ["maxconcentr"];
                                $rprice = $rowsubst ["price_rub"];

                                // Вычисления
                                $mincost = sprintf("%.2f", $minrate * $rprice);
                                $mincostsubst = sprintf("%.2f", $mincost / $minconcentr);
                                $maxcost = sprintf("%.2f", $maxrate * $rprice);
                                $maxcostsubst = sprintf("%.2f", $maxcost / $maxconcentr);
                                ?>
                                <tr>
                                    <td><?php echo '<a href="' . PATH . '/pesticide/full-info/id-product-' . $id_product . '">' . $rnameproduct . '</a>'; ?></td>
                                    <td><?php echo $rnamemanufacture; ?></td>
                                    <td><?php echo $mincostsubst; ?></td>
                                    <td><?php echo $maxcostsubst; ?></td>
                                </tr>
                                <?php
                            } ?>
                        </table>
                        <?php
                    }
                } ?>
            </div>
            <div class="row">Полная информация по действующему веществу: <a href="<?php echo PATH; ?>/substance/full-info/id-substance-<?php echo $id_substance;?>"><?php echo $rnamesubstance; ?></a></div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>