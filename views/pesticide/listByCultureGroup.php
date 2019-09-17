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
                            <a href="javascript:void(0);" class="breadcrumb">Культура</a>
                        </div>
                    </div>
                </nav>
            </div>
            <?php
            if ($cultureListSQL) {
                include (ROOT . '/config/currency_rus.php');

                while ($rowCult = $cultureListSQL->fetch()) { ?>
                    <div class="row title"><p><?php echo $rowCult["name_rus"]; ?></p></div>
                    <div class="row">
                        <table class="striped">
                            <tr>
                                <th>Препарат</th>
                                <th>Механизм действия *</th>
                                <th>Производитель</th>
                                <th colspan="2">Стоимость руб./га</th>
                            </tr>
                            <tr>
                                <th colspan="3"></th>
                                <th>мин.</th>
                                <th>макс.</th>
                            </tr>
                            <?php
                            $nameMod = '';
                            $productList = Product::getListByIdCultureAndProductClassWithRegData($rowCult["id_culture"], $idProductClass);
                            while ($rowProd = $productList->fetch()) {
                                $data3 = Product::getListAndCultureContainRegDataSQL($rowCult['id_culture'], $rowProd["id_product"]);
                                $data = Product::getListAndPriceByIdProductSQL($rowProd["id_product"]);

                                if ($rowProd["id_product"] !== $data["id_product"]) {
                                    continue;
                                }
                                if ($rowProd["id_product"] !== $data3["id_product"]) {
                                    continue;
                                }

                                if ($rowProd["namemod"] == 'multi-site') {
                                  $rowProd["namemod"] = 'Не указано';
                                }
                                if ($nameMod != $rowProd["namemod"]) {
                                  $nameMod = $rowProd["namemod"]; ?>
                                  <tr>
                                    <td class="center name-mod" colspan="5"><?php echo $nameMod; ?></td>
                                  </tr>
                                  <?php
                                }
                                ?>
                                <tr>
                                    <td><?php echo '<a href="' . PATH . '/pesticide/info/id-product-' . $rowProd["id_product"] . '/id-culture-' . $rowCult["id_culture"] . '">' . $rowProd["name_product_rus"] . '</a>'; ?></td>
                                    <td><?php echo $rowProd["namemod"]; ?></td>
                                    <td><?php echo $rowProd["name_manufacture_rus"]; ?></td>
                                    <td><?= (round($data["price_usd"]) == 0) ? round($data["price_rub"] * $data3["min_rate"], 1) : round($data["price_rub"] = $data["price_usd"] * $dollar, 1); ?></td>
                                    <td><?= (round($data["price_usd"]) == 0) ? round($data["price_rub"] * $data3["max_rate"], 1) : round($data["price_rub"] = $data["price_usd"] * $dollar, 1); ?></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div class="row"></div>
                    <?php
                }
            } ?>
            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Описание механизма действия</h5>
                        </li>
                      <li class="collection-item"><?php
                        if ($cultureListTwoSQL) {
                          $a = array();
                          while ($rowcult2 = $cultureListTwoSQL->fetch()) {
                            $product2 = Product::getListByIdCultureAndProductClass($rowcult2["id_culture"], $idProductClass);
                            while ($rowprod2 = $product2->fetch()) {
                              $a[] = $rowprod2['1'];
                              $a[] = $rowprod2['2'];
                            }
                          }

                          $an = array_unique($a);
                          foreach ($an as $v1) {
                            echo $v1 . "<br>";
                          }
                        } ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>