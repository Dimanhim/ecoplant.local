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
                        <a href="javascript:void(0);" class="breadcrumb">Прайс-лист</a>
                    </div>
                </div>
            </nav>
        </div>
        <h5 class="center"><?php
            if ($manufacture) {
                $manufacturelogo = $manufacture["file_manufacture_logo"];
                echo 'Прайс-лист компании ' . $manufacture["name_manufacture_rus"] . ' на ' . date("Y") . ' г.';
            }
            ?></h5>
        <div class="row"></div>
        <div class="row center">
            <?php
            $filePath = 'template/img/manufacture_logo/' . $manufacturelogo;
            if (file_exists($filePath)) {
                echo '<img style="max-width: 128px; max-height: 128px;" src=' . PATH . '/' . $filePath . '>';
            }
            ?>
        </div>
        <div class="row title"><p>Регистрация в Российской Федерации:</p></div>
        <div class="row">
            <?php
            // Загрузить значения валуты с ЦБ России
            include (ROOT . '/config/currency_rus.php');

            while ($rowdate = $importerList->fetch()) { ?>
                <p class="center">Импортер в РФ: <?php echo $rowdate["name_importer_rus"]; ?></p>
                <p class="center">Дата публикации: <?php echo date("j M Y", strtotime($rowdate["date"])); ?></p>

                <?php
                $listProduct = Product::getListByIdManufactureAndIdImporterAndIdProductClass($idManufacture, $rowdate["id_importer"], $idProductClass);
                // Вывод информации.
                if ($listProduct) { ?>
                <table class="striped">
                    <tr>
                        <th>Препарат</th>
                        <th>Стоимость, руб.</th>
                        <th>Культура</th>
                    </tr>
                <?php
                    while ($rowlprod = $listProduct->fetch()) { ?>
                        <tr>
                            <td><?php echo '<a href="' . PATH . '/pesticide/full-info/id-product-' . $rowlprod["id_product"] . '">' . $rowlprod["name_product_rus"] . '</a>'; ?></td>
                            <td><?php
                                // Определение стоимости в рублях или у.е.
                                if ($rowlprod["price_rub"] != 0) {
                                    $price = $rowlprod["price_rub"];
                                } else {
                                    $price = round($rowlprod["price_usd"] * $dollar, 2);
                                }
                                echo $price; ?></td>
                            <td><?php echo $rowlprod["nameculture"]; ?></td>
                        </tr>
                        <?php
                    } ?>
                </table>
                    <?php
                } else {
                    echo '<p class="center">Препаратов нет</p>';
                }
            } ?>

        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>