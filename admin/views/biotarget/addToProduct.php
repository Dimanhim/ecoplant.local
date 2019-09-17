<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавление связки препарат и биотаргет</h5>
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
                    <div class="col s12">
                        <select name="product">
                            <option value="" disabled selected>Выберите продукт</option>
                            <?php
                            if ($productListSQL) {
                                while ($row = $productListSQL->fetch()) {
                                    echo "<option value = " . $row["id_product"] . ">" . $row["name_product_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <select name="link">
                            <option value="" disabled selected>Выберите ссылку на Публикацию</option>
                            <?php
                            if ($biblioLinkListSQL) {
                                while ($row = $biblioLinkListSQL->fetch()) {
                                    echo "<option value = " . $row["id_biblio_link"] . ">" . $row["name_link"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <select name="culture">
                            <option value="" disabled selected>Выберите Культуру</option>
                            <?php
                            if ($cultureListSQL) {
                                while ($row = $cultureListSQL->fetch()) {
                                    echo "<option value = " . $row["id_culture"] . ">" . $row["name_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <select name="target">
                            <option value="" disabled selected>Выберите БиоТаргет</option>
                            <?php
                            switch($idBiotargetClass) {
                                case 1:
                                    while ($row = $biotargetListSQL->fetch()) {
                                        echo "<option value = " . $row["id_grobject"] . ">" . $row["grobject_name_rus"] . "</option>";
                                    }
                                    break;
                                case 2:
                                    while ($row = $biotargetListSQL->fetch()) {
                                        echo "<option value = " . $row["id_object"] . ">" . $row["rnameobject"] . "</option>";
                                    }
                                    break;
                                case 3:
                                    while ($row = $biotargetListSQL->fetch()) {
                                        echo "<option value = " . $row["id_species"] . ">" . $row["name_lat"] . "</option>";
                                    }
                                    break;
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="rate" type="text" name="rate">
                        <label for="rate">Доза препарата</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="efficacy" type="text" name="efficacy">
                        <label for="efficacy">Эффективность препарата (%)</label>
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