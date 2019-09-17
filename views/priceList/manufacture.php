<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"></div>
    <div class="row">
        <?php include (ROOT . '/views/layout/leftmenu4pest.php'); ?>

        <div class="col s12 m9 content-row">
            <?php
            $rnamemanufacture = '';
            $manufacturelogo = '';
            if ($manufacture) {
                $rnamemanufacture = $manufacture["name_manufacture_rus"];
                $manufacturelogo = $manufacture["file_manufacture_logo"];
            }
            ?>
            <h5 class="center">Прайс-лист компании <?php echo $rnamemanufacture; ?> на <?php echo date("Y");?> г.</h5>
            <?php
            $pathLogo = 'template/img/manufacture_logo/' . $manufacturelogo;
            if (file_exists($pathLogo)) {
                echo '<div class="center"><img style="max-height: 80px;" src="' . PATH . '/' . $pathLogo . '"></div>';
            }
            ?>

            <?php
            // Загрузить значения валуты с ЦБ России
            include (ROOT . '/config/currency_rus.php');

            while ($rowdate = $importerList->fetch()) {
                $pricedate = $rowdate["date"];
                $rnameimporter = $rowdate["name_importer_rus"];
                ?>
                <p class="center">Импортер в РФ: <?php echo $rnameimporter; ?></p>
                <p class="center">Дата публикации: <?php echo date("j M Y", strtotime($pricedate)); ?></p>
                <?php

                // Вывод группы пестицида .
                $priceclproduct = ProductClass::getListByIdManufactureAndIdImporter($idManufacture, $rowdate["id_importer"]);
                while ($rowprclprod = $priceclproduct->fetch()) {
                    ?>
                    <div class="row title-before-table"><p><?php echo $rowprclprod["name_clproduct_rus"]; ?></p></div>
                    <table class="striped">
                        <tr>
                            <th>Препарат</th>
                            <th>Стоимость, руб.</th>
                            <th>Форма</th>
                            <th>Упаковка</th>
                        </tr>
                        <?php
                        // Вывод списка продуктов и цен.
                        $pricelist = Product::getListAndPriceByIdManufactureAndIdImporter($idManufacture, $rowdate["id_importer"], $rowprclprod["id_clproduct"]);
                        while ($rowprl = $pricelist->fetch()) {
                            // Обозначаем поля MySQL, которые собираемся вывести
                            $id_product = $rowprl["id_product"];
                            $rnameproduct = $rowprl["name_product_rus"];
                            $price_rub = $rowprl["price_rub"];
                            $price_usd = $rowprl["price_usd"];
                            $rshnamesol = $rowprl["short_name_product_solution"];
                            $rpack = $rowprl["pack"];
                            $rtara = $rowprl["tara"];

                            ?>
                            <tr>
                                <td><?php echo '<a href="' . PATH . '/pesticide/full-info/id-product-' . $id_product . '">' . $rnameproduct . '</a>'; ?></td>
                                <td>
                                    <?php
                                    // Определение стоимости в рублях или у.е.
                                    if ($price_rub != 0) {
                                        $price = $price_rub;
                                    } else {
                                        $price = round($price_usd * $dollar, 2);
                                    }
                                    echo $price; ?>
                                </td>
                                <td><?php echo $rshnamesol; ?></td>
                                <td><?php echo $rpack . ' ' . $rtara; ?></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                    <?php
                }
            }
            ?>

        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>