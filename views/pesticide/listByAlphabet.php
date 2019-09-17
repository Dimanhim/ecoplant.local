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
                            if ($letter) { ?>
                                <a href="javascript:void();" class="breadcrumb">По названию - <?php echo $letter["letter"]; ?></a>
                                <?php
                            } ?>
                        </div>
                    </div>
                </nav>
            </div>
            <h5 class="center">Препараты на '<?php echo $letter["letter"]; ?>' зарегистрированные на территории РФ</h5>
            <div class="row"></div>
            <?php
            if ($productList) { ?>
                <table class="striped one-col-full-width">
                    <tr>
                        <th>Препарат</th>
                        <th>Производитель</th>
                        <th>Культуры</th>
                    </tr><?php
                    while ($rowsubst = $productList->fetch()) { ?>
                        <tr>
                            <td><?php echo '<a href="' . PATH . '/pesticide/full-info/id-product-' . $rowsubst["id_product"] . '">' . $rowsubst["name_product_rus"] . '</a>'; ?></td>
                            <td><?php echo $rowsubst["name_manufacture_rus"]; ?></td>
                            <td><?php echo $rowsubst["nameculture"]; ?></td>
                        </tr>
                        <?php
                    } ?>
                </table>
                <?php
            } else { ?>
                <blockquote>Препаратов на '<?php echo $letter["letter"]; ?>' нет в базе данных</blockquote>
                <?php
            } ?>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>