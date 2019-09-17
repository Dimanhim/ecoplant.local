<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить связку препарат и культура</h5>
    </div>
    <?php
    if ($errors) { ?>
        <blockquote class="error">
            <?php
            for ($i = 0; $i < count($errors); $i++) {
                echo $errors[$i] . '<br>';
            }
            ?>
        </blockquote>
    <?php }
    if ($success) { ?>
        <blockquote>
            <?php
            for ($i = 0; $i < count($success); $i++) {
                echo $success[$i] . '<br>';
            }
            ?>
        </blockquote>
        <?php
    } ?>
    <div class="row">
        <div class="col s12">
            <form method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <select name="product">
                            <option value="" disabled selected>Выберите продукт</option>
                            <?php
                            if ($productListSQL) {
                                while ($row = $productListSQL->fetch())
                                {
                                    echo "<option value = " . $row["id_product"] . ">" . $row["name_product_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                        <label></label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select name="culture">
                            <option value="" disabled selected>Выберите культуру</option>
                            <?php
                            if ($cultureListSQL) {
                                while ($row = $cultureListSQL->fetch())
                                {
                                    echo "<option value = " . $row["id_culture"] . ">" . $row["name_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                        <label></label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="min-rate" name="min_rate" type="text" class="validate">
                        <label for="min-rate">Мин. концентрация</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="max-rate" name="max_rate" type="text" class="validate">
                        <label for="max-rate">Макс. концентрация</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="description" name="description" type="text" class="validate">
                        <label for="description">Условия</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center">
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit"><i class="material-icons right">add</i>Добавить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>