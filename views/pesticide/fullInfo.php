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
                            if ($productClassByIdProduct) { ?>
                            <a href="<?php echo PATH; ?>/pesticide/product-class-<?php echo $productClassByIdProduct["id_clproduct"]; ?>" class="breadcrumb">
                                <?php echo $productClassByIdProduct["name_clproduct_rus"]; ?>
                                </a><?php

                                $rnamemanufacture = $productClassByIdProduct["name_manufacture_rus"];
                                $rnameproduct = $productClassByIdProduct["name_product_rus"];
                                $rnameclprod = $productClassByIdProduct["name_clproduct_rus"];

                                ?>
                                <a href="<?php echo PATH; ?>/pesticide/id-manufacture-<?php echo $productClassByIdProduct["id_manufacture"]; ?>" class="breadcrumb">
                                    <?php echo $rnamemanufacture; ?>
                                </a>
                                <?php
                            } ?>
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
            <div class="row"><?php
                if ($manufacture) {
                    $rnamemanufacture = $manufacture["name_manufacture_rus"];
                    $manufacturelogo = $manufacture["file_manufacture_logo"];
                }

                // Вывод компании-импортера
                if ($importerList) {
                    while ($rowimporter = $importerList->fetch()) {
                        $resultrnamesubstunit = '';

                        $price_rub = $priceMinRate["price_rub"];
                        $price_usd = $priceMinRate["price_usd"];

                        $minrate = $priceMinRate["min_rate"];
                        $maxrate = $priceMaxRate["max_rate"];
                        // Определение единицы измерения препарата

                        // Выполнение расчета стоимости обработки 1 гектара данной культуры
                        // Определение стоимости в рублях или у.е.
                        if ($price_rub != 0) {
                            $price = $price_rub;
                        } else {
                            // Загрузить значения валуты с ЦБ России
                            include (ROOT . '/config/currency_rus.php');
                            $price = round($price_usd * $dollar, 2);
                        }
                        $mincost = round($price * $minrate, 2);
                        $maxcost = round($price * $maxrate, 2);

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
                                        }
                                        ?></div>
                                </div>
                            </li>
                            <li class="collection-item">Импортер в
                                РФ: <?php echo $rowimporter["name_importer_rus"]; ?></li>
                        </ul>
                        <?php
                    }
                }?>
            </div>
            <div class="row title">
                <p>Информация по стоимости препарата</p>
            </div>
            <div class="row">
                <ul class="collection">
                    <li class="collection-item">Стоимость 1 <?php echo $resultrnamesubstunit; ?> препарата: <b><?php echo $price; ?></b> руб.</li>
                    <li class="collection-item">Минимальная стоимость обработки 1 га: <b><?php echo $mincost; ?></b> руб./га</li>
                    <li class="collection-item">Максимальная  стоимость обработки 1 га: <b><?php echo $maxcost; ?></b> руб./га</li>
                </ul>
            </div>
            <div class="row title"><p>Действующее вещество:</p></div>
            <div class="row">
                <?php
                if ($substanceList) {
                    while ($rowsubst = $substanceList->fetch()) {
                        $id_substance = $rowsubst["id_substance"];
                        $rnamesubstance = $rowsubst["name_rus"];
                        $concentration = $rowsubst["concentration"];
                        $rnamesubstunit = $rowsubst["name_substance_unit_rus"]; ?>
                        <ul class="collection">
                            <li class="collection-item">
                                <div class="row info">
                                    <div class="col s6"><?php echo RegData::getNumberToString($concentration). ' ' . $rnamesubstunit; ?></div>
                                    <div class="col s6"><?php echo '<a href="' . PATH . '/substance/full-info/id-substance-' . $id_substance . '">' . $rnamesubstance . '</a>'; ?></div>
                                </div>
                            </li>
                        </ul>
                        <?php
                    }
                } ?>
            </div>
            <div class="row title"><p>Препаративная форма:</p></div>
            <div class="row">
                <?php
                if ($solutionList) {
                    while ($rowsolution = $solutionList->fetch()) { ?>
                        <ul class="collection">
                            <li class="collection-item">
                                <div class="row info">
                                    <div class="col s6"><?php echo $rowsolution["short_name_product_solution"]; ?></div>
                                    <div class="col s6"><?php echo $rowsolution["name_product_solution"]; ?></div>
                                </div>
                            </li>
                        </ul>
                        <?php
                    }
                }?>
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
            <div class="row title"><p>По культурам</p></div>
            <div class="row">
                <?php
                if ($regDataCultureList) { ?>
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
                    while ($rowprodsubst = $regDataCultureList->fetch()) { ?>
                        <tr>
                            <td colspan="7" class="title-table">
                                <?php
                                    echo $rowprodsubst["name_rus"]."<br />";
                                    $namesObject = RegData::getListByIdProductAndIdCultureContainObject($idProduct, $rowprodsubst['id_culture']);
                                if ($namesObject) { ?>
                                    <span class="object-list-name"><br><?php echo $namesObject; ?></span>
                                <?php } ?>
                                <br />
                                <?php
                                    $namesGroupObject = RegData::getListByIdProductAndIdCultureContainGroupObject($idProduct, $rowprodsubst['id_culture']);
                                if ($namesGroupObject) { ?>
                                    <span class="object-list-name"><br><?php echo $namesGroupObject; ?></span>
                                <?php } ?>
                            </td>
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
                    ?>
                    </table>
                <?php
                } else { ?>
                    <blockquote>Зарегистрированных культур нет в базе данных</blockquote>
                    <?php
                }
                ?>
            </div>

            <div class="row title"><p>Свидетельство о регистрации:</p></div>
            <div class="row"><?php
                if ($regCertificate) {
                    while ($row = $regCertificate->fetch()) { ?>
                        <a href="<?php echo PATH; ?>/template/img/regcertificates/<?php echo $row["file_regcertif"]; ?>"><?php
                        echo $row["filename_regcertif"]; ?>
                        </a><?php
                    }
                } else { ?>
                    <blockquote>Информации о свидетельстве регистрации продукта нет в базе данных</blockquote>
                    <?php
                } ?>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>