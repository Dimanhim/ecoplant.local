<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <div class="col s12">
            <h5>Добавить свидетельства</h5>
        </div>
    </div>
    <form method="post">
        <div class="row">
            <div class="input-field col s12">
                <select id="select" name="product" class="id_product">
                    <?php
                    if ($productListSQL) {
                        while ($row = $productListSQL->fetch()) {
                            if ($row['id_product'] == $idProduct) { ?>
                                <option value="<?php echo $row['id_product']; ?>" selected><?php
                                    echo $row['name_product_rus'];
                                    ?></option>
                                <?php
                            } else { ?>
                                <option value="<?php echo $row['id_product']; ?>"><?php
                                    echo $row['name_product_rus'];
                                    ?></option>
                                <?php
                            } ?>
                            <?php
                        }
                    } ?>
                </select>
                <label>Выберите препарат</label>
            </div>
        </div>

        <div class="row">
            <div class="col s12 center">
                <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="action">
                    Продолжить
                </button>
            </div>
        </div>
    </form>

<?php include(ROOT . '/views/layout/footer.php'); ?>