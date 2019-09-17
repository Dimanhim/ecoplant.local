<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить связку препарат и патоген в БД</h5>
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
        <div class="col s12 m6 center"><a class ="link3" href="<?php echo PATH; ?>">Перейти на главную станицу </a></div>
        <div class="col s12 m6 center"><a class ="link3" href="<?php echo PATH; ?>/product/analog/select">Перейти к добавлению другого препарата-аналога</a></div></div>
    <div class="row">
        <h5>Таблица связки препарата и культуры</h5>
    </div>
    <div class="row">
        <table class="striped">
            <tr>
                <th>ID</th>
                <th>Название</th>
                <th>Мин. концентрация</th>
                <th>Макс. концентрация</th>
                <th>Условие</th>
            </tr>
            <?php
            if ($regDataProductListSQL) {
                while ($row = $regDataProductListSQL->fetch()) {
                    echo '
                            <tr>
                            <td>' . $row["id_regdata"] . '</td>
                            <td>' . $row["name_rus"] . '</td>
                            <td>' . $row["min_rate"] . '</td>
                            <td>' . $row["max_rate"] . '</td>
                            <td>' . $row["description"] . '</td>
                            </tr>';
                }
            } ?>
        </table>
    </div>
    <div class="row">
        <div class="col s12">
            <form method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <select name="regdata">
                            <option value="" disabled selected>Выберите ID связки "Препарат и культура"</option>
                            <?php
                            if ($regDataProductListSQL) {
                                $regDataProductListSQL->execute();
                                while ($row = $regDataProductListSQL->fetch()) {
                                    print "<option value = " . $row["id_regdata"] . ">" . $row["id_regdata"] . "</option>";
                                }
                            } ?>
                        </select>
                        <label></label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select name="product">
                            <option value="" disabled selected>Выберите препарат-аналог</option>
                            <?php
                            if ($productListSQL) {
                                while ($row = $productListSQL->fetch()) {
                                    echo "<option value = " . $row["id_product"] . ">" . $row["name_product_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                        <label></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center">
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="action"><i class="material-icons right">add</i>Добавить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>