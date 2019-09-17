<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"></div>
    <div class="row">
        <?php include (ROOT . '/views/layout/leftmenu4pest.php'); ?>

        <div class="col s12 m9 content-row">
            <h5 class="center">Актуальные цены на Пестициды на территории Российской Федерации</h5>
            <div class="row title"><p>Группы препаратов:</p></div>
            <?php
            // Установление соединения с таблицой Группа продуктов. Вывод определение и описание групп продуктов.
            if ($listProductClassWithDesc) {
                while ($row = $listProductClassWithDesc->fetch()) { ?>
                    <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>
                                <a href="<?php echo PATH; ?>/pesticide/product-class-<?php echo $row["id_clproduct"]; ?>">
                                    <?php echo $row['name_clproduct_rus']; ?></a>
                            </h5>
                            <a href="<?php echo PATH; ?>/pesticide/product-class-<?php echo $row["id_clproduct"]; ?>" class="chip right">
                                Перейти
                                <i class="material-icons">link</i>
                            </a>
                        </li>
                        <li class="collection-item"><?php echo $row['definition_rus']; ?></li>
                    </ul>
                    </div><?php
                }
            } ?>
            <div class="row"></div>
            <div class="row title"><p>Производители:</p></div>
            <div class="row center">
                <?php
                if ($manufactureListSQL)
                {
                    while ($row = $manufactureListSQL->fetch()) {
                        ?><a href="price-list/manufacture-<?php echo $row["id_manufacture"]; ?>" class="chip">
                        <?php echo $row["name_manufacture_rus"]; ?>
                        <i class="material-icons">link</i>
                        </a><?php
                    }
                } ?>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>