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
                            }

                            if ($productClass) {
                                $id_clprod = $productClass["id_clproduct"];
                                $id_culture_group = $productClass["id_culture_group"];
                                $rnameproduct = $productClass["name_product_rus"];
                                $rnameclprod = $productClass["name_clproduct_rus"];
                                $rnameculture = $productClass["name_rus"];
                            } ?>
                            <a href="<?php echo PATH; ?>/pesticide/id-culture-group-<?php echo $id_culture_group; ?>" class="breadcrumb"><?php echo $rnameculture; ?></a>
                            <a href="javascript:void(0);" class="breadcrumb">Препарат</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row">
                <h5 class="center"><?php
                    $resultrnameclproduct = mb_substr("$rnameclprod", 0, -1);
                    echo $resultrnameclproduct . ' ' . $rnameproduct;
                    ?></h5>
            </div>
            <div class="row">
                <?php
                // Установление соединения с таблицой Производитель. Вывод названия и логотипа Производителя .
                if ($manufacture) {
                    $rnamemanufacture = $manufacture["name_manufacture_rus"];
                    $manufacturelogo = $manufacture["file_manufacture_logo"];
                    $rnameimporter = $manufacture["name_importer_rus"];
                }
                ?>
                <ul class="collection">
                    <li class="collection-item">
                        <div class="row margin-none">
                            <div class="col s9">Производитель: <?php echo $rnamemanufacture; ?></div>
                            <div class="col s3"><?php
                                $filePath = 'template/img/manufacture_logo/' . $manufacturelogo;
                                if (file_exists($filePath)) {
                                    $size = getimagesize($filePath);
                                    echo '<img class="right" style="max-width: 68px; max-height: 68px;" src=' . PATH . '/' . $filePath . '>';
                                } ?></div>
                        </div></li>
                    <li class="collection-item">Импортер в РФ: <?php echo $rnameimporter; ?></li>
                </ul>
            </div>
            <div class="row title">
                <p>Информация по стоимости препарата</p>
            </div>
            <div class="row">
                <?php
                if ($productPriceList) {
                    while ($rowabprod = $productPriceList->fetch()) {
                        $rnamesubstunit = '';
                        //$rnamesubstunit = $rowabprod["name_substance_unit_rus"];
                        $price_rub = $rowabprod["price_rub"];
                        $price_usd = '';
                        //$price_usd = $rowabprod["price_usd"];
                        $minrate = $rowabprod["min_rate"];
                        $maxrate = $rowabprod["max_rate"];
                    }
                }

                // Определение единицы измерения препарата
                $resultrnamesubstunit = mb_substr($rnamesubstunit, -1);
                // Выполнение расчета стоимости обработки 1 гектара данной культуры
                // Определение стоимости в рублях или у.е.
                if ($price_rub != 0) {
                    $price = $price_rub;
                } else {
                    // Загрузить значения валуты с ЦБ России
                    include('currency_rus.php');
                    $price = round($price_usd * $dollar, 2);
                }
                $mincost = round($price * $minrate, 2);
                $maxcost = round($price * $maxrate, 2);
                ?>
                <ul class="collection">
                    <li class="collection-item">Стоимость <?php echo $rnamesubstunit; ?> препарата: <b><?php echo $price; ?></b> руб.</li>
                    <li class="collection-item">Минимальная стоимость обработки 1 га: <b><?php echo $mincost; ?></b> руб./га</li>
                    <li class="collection-item">Максимальная  стоимость обработки 1 га: <b><?php echo $maxcost; ?></b> руб./га</li>
                </ul>
            </div>
            <div class="row title"><p>Действующее вещество:</p></div>
            <div class="row">
                <?php
                // Установление соединения с таблицой Действующее вещество. Вывод списка д.в.
                if ($substanceList) {
                    while ($rowsubst = $substanceList->fetch()) {
                        $id_substance = $rowsubst["id_substance"];
                        $rnamesubstance = $rowsubst["name_rus"];
                        $concentration = $rowsubst["concentration"];
                        $rnamesubstunit = $rowsubst["name_substance_unit_rus"];
                        ?>
                        <ul class="collection">
                            <li class="collection-item">
                                <div class="row info">
                                    <div class="col s6"><?php echo $concentration . ' ' . $rnamesubstunit; ?></div>
                                    <div class="col s6"><?php echo '<a href="' . PATH . '/substance/info/id-substance-' . $id_substance . '">' . $rnamesubstance . '</a>'; ?></div>
                                </div>
                            </li>
                        </ul>
                        <?php
                    }
                }
                ?>
            </div>
            <div class="row title"><p>Препаративная форма:</p></div>
            <div class="row">
                <?php
                if ($solutionList) {
                    while ($rowsolution = $solutionList->fetch()) {
                        $id_product_solution = $rowsolution ["id_product_solution"];
                        $rshnameproductsolution = $rowsolution ["short_name_product_solution"];
                        $rnameproductsolution = $rowsolution ["name_product_solution"]; ?>
                        <ul class="collection">
                            <li class="collection-item">
                                <div class="row info">
                                    <div class="col s6"><?php echo $rshnameproductsolution; ?></div>
                                    <div class="col s6"><?php echo $rnameproductsolution; ?></div>
                                </div>
                            </li>
                        </ul>
                        <?php
                    }
                } ?>
            </div>

            <?php

            if ($taraList) { ?>
                <div class="row title"><p>Упаковка:</p></div>
                <div class="row">
                    <?php
                    while ($rowtara = $taraList->fetch()) { ?>
                        <ul class="collection">
                            <li class="collection-item">
                                <div class="row info">
                                    <div class="col s6"><?php echo $rowtara["pack"]; ?></div>
                                    <div class="col s6"><?php echo $rowtara["tara"]; ?></div>
                                </div>
                            </li>
                        </ul>
                        <?php
                    } ?>
                </div>
                <?php
            } ?>
            <div class="row title"><p>Регистрация в Российской Федерации:</p></div>
            <div class="row">
                <table class="striped">
                    <tr>
                        <th class="center">Описание</th>
                        <th class="center">Мин.</th>
                        <th class="center">Макс.</th>
                        <th class="center">Сроки ожидания</th>
                        <th class="center">Кратность обработок</th>
                        <th class="center" colspan="2" style="text-align: center;">Сроки выхода</th>
                    </tr>
                    <tr>
                        <th colspan="5"></th>
                        <th class="center">ручных</th>
                        <th class="center">мех.</th>
                    </tr>
                    <?php
                    //
                    // Установление соединения с таблицой Продукт и Культура. Вывод регистрационной информации.
                    if ($regDataList) {
                        while ($rowprodsubst = $regDataList->fetch()) { ?>
                            <tr>
                                <td colspan="7" class="title-table"><?php
                                    echo $rnameculture;
                                    if ($namesObject) { ?>
                                        <span class="object-list-name"><br><?php echo $namesObject; ?></span><?php
                                    } ?></td>
                            </tr>
                            <tr>
                                <td class="center"><?php echo $rowprodsubst["description"]; ?></td>
                                <td class="center"><?php echo $rowprodsubst["min_rate"]; ?></td>
                                <td class="center"><?php echo $rowprodsubst["max_rate"]; ?></td>
                                <td class="center"><?php echo $rowprodsubst["waiting_period"]; ?></td>
                                <td class="center"><?php echo $rowprodsubst["maxtimes"]; ?></td>
                                <td class="center"><?php echo $rowprodsubst["date4people"]; ?></td>
                                <td class="center"><?php echo $rowprodsubst["date4machine"]; ?></td>
                            </tr>
                            <?php
                        }
                    }?>
                </table>
            </div>


            <?php
            if ($productAndBiotargetList) { ?>
                <div class="row title"><p>Таблица эффективности препарата:</p></div>
                <div class="row">
                    <table class="striped">
                        <tr>
                            <th>Объект<?php //echo $name_table; ?></th>
                            <th>Доза</th>
                            <th>Эф., %</th>
                            <th>Литература</th>
                        </tr>
                        <?php

                        while ($rowclbt = $productAndBiotargetList->fetch()) {
                            $id_biotarget_class = $rowclbt["id_biotarget_class"];
                            if ($id_biotarget_class < 2) {
                                // Установление соединения с таблицой Группа Объектов. Вывод эффективности.
                                $productandbiotarget = Product::getListAndBioTargetWithObjectGroup($idProduct, $idCulture, $id_biotarget_class);
                                if ($productandbiotarget) {
                                    while ($rowprodbt = $productandbiotarget->fetch()) {
                                        $id_objectgroup = $rowprodbt["id_grobject"];
                                        $rnamegrobject = $rowprodbt["grobject_name_rus"];
                                        $rate = $rowprodbt["rate"];
                                        $efficacy = $rowprodbt["efficacy"];
                                        $namebiblink = $rowprodbt["name_link"]; ?>
                                        <tr>
                                            <td><?php echo $rnamegrobject; ?></td>
                                            <td><?php echo $minrate; ?></td>
                                            <td><?php echo $efficacy; ?></td>
                                            <td><?php echo $namebiblink; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            } elseif ($id_biotarget_class == 2) {
                                // Установление соединения с таблицой Объекты. Вывод эффективности.
                                $productandbiotarget = Product::getListAndBioTargetWithObject($idProduct, $idCulture, $id_biotarget_class);
                                if ($productandbiotarget) {
                                    while ($rowprodbt = $productandbiotarget->fetch()) {
                                        $id_object = $rowprodbt["id_object"];
                                        $rnameobject = $rowprodbt["rnameobject"];
                                        $rate = $rowprodbt["rate"];
                                        $efficacy = $rowprodbt["efficacy"];
                                        $namebiblink = $rowprodbt["name_link"]; ?>
                                        <tr>
                                            <td><?php echo $rnameobject; ?></td>
                                            <td><?php echo $minrate; ?></td>
                                            <td><?php echo $efficacy; ?></td>
                                            <td><?php echo $namebiblink; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            } else {
                                // Установление соединения с таблицой Вид. Вывод эффективности.
                                $productandbiotarget = Product::getListAndBioTargetWithSpecies($idProduct, $idCulture, $id_biotarget_class);
                                if ($productandbiotarget) {
                                    while ($rowprodbt = $productandbiotarget->fetch()) {
                                        $id_species = $rowprodbt["id_species"];
                                        $name_lat = $rowprodbt["name_lat"];
                                        $rate = $rowprodbt["rate"];
                                        $efficacy = $rowprodbt["efficacy"];
                                        $namebiblink = $rowprodbt["name_link"]; ?>
                                        <tr>
                                            <td><?php echo $name_lat; ?></td>
                                            <td><?php echo $minrate; ?></td>
                                            <td><?php echo $efficacy; ?></td>
                                            <td><?php echo $namebiblink; ?></td>
                                        </tr>
                                        <?php
                                    }
                                }
                            }
                        } ?>
                    </table>
                </div>
                <?php
            }
            ?>

            <div class="row">Полная информация о препарате <?php echo '<a href="' . PATH . '/pesticide/full-info/id-product-' . $idProduct . '">' . $rnameproduct . '</a>'; ?></div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>