<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Внести (обновить) цены продуктов</h5>
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
            <div class="row">
                <div class="input-field col s12">
                    <select name="productId">
                        <?php
                        if ($productListSQL) {
                            while ($row = $productListSQL->fetch()) {
                                echo "<option value = " . $row["id_product"] . ">" . $row["name_product_rus"] . "</option>";
                            }
                        } ?>
                    </select>
                    <label>Продукты</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <select name="datePrice">
                        <option value="" disabled selected>Выберите существующие даты цен</option>
                    </select>
                    <label>Список имеющихся дат в базе данных</label>
                </div>
            </div>
            <div class="row">
                <form method="post">
                    <input type="hidden" name="idProductSave" value="<?php echo $idProduct; ?>">
                    <input type="hidden" name="idDate" value="">
                    <div class="col s6">
                        <div class="card-exists card grey darken-3">
                            <div class="card-content white-text">
                                <span class="card-title">Цена по дате из списка выше</span>
                                <div class="row">
                                    <div class="row"></div>
                                    <div class="col s12">
                                        <input type="checkbox" class="filled-in" id="actualitySave" name="actualitySave"/>
                                        <label for="actualitySave">Актуальная цена</label>
                                    </div>
                                    <div class="row"></div>
                                    <div class="input-field col s12">
                                        <select class="importer" name="idImporter">
                                            <option value="" disabled selected>Выберите из списка</option>
                                            <?php
                                            if ($importerListSQL) {
                                                while ($row = $importerListSQL->fetch()) {
                                                    echo "<option value = " . $row["id_importer"] . ">" . $row["short_name"] . "</option>";
                                                }
                                            } ?>
                                        </select>
                                        <label>Импортер</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="price_rub" name="price_rub" placeholder=" " type="text" class="validate" pattern="[0-9]+.[0-9]{2}">
                                        <label for="price_rub">Цена в рублях</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="price_usd" name="price_usd" placeholder=" " type="text" class="validate" pattern="[0-9]+.[0-9]{2}">
                                        <label for="price_usd">Цена в долларах</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 center">
                                        <button class="waves-effect waves-light btn light-blue darken-2" name="actionSave" type="submit"><i class="material-icons right">save</i>Сохранить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <form method="post">
                    <input type="hidden" name="idProductAdd" value="<?php echo $idProduct; ?>">
                    <div class="col s6">
                        <div class="card grey darken-3">
                            <div class="card-content white-text">
                                <span class="card-new card-title">Добавить новую цену</span>
                                <div class="row">
                                    <div class="col s7">
                                        <input type="text" class="datepicker" name="date" placeholder="Выберите дату" value="<?php echo $date; ?>">
                                    </div>
                                    <div class="checkbox-actuality col s5">
                                        <input type="checkbox" class="filled-in" id="actualityAdd" <?php
                                        if ($actualityAdd == 1)
                                            echo 'checked="checked"';?> name="actualityAdd"/>

                                        <label for="actualityAdd">Актуальная цена</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select class="importer" name="idImporter">
                                            <option value="" disabled selected>Выберите из списка</option>
                                            <?php
                                            if ($importerListSQL) {
                                                $importerListSQL->execute();
                                                while ($row = $importerListSQL->fetch()) {
                                                    echo "<option value = " . $row["id_importer"] . ">" . $row["short_name"] . "</option>";
                                                }
                                            } ?>
                                        </select>
                                        <label>Импортер</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="price_rub" name="price_rub" placeholder="0.00" type="text" class="validate" pattern="[0-9]+.[0-9]{2}" value="<?php echo $priceRubAdd; ?>">
                                        <label for="price_rub">Цена в рублях</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="price_usd" name="price_usd" placeholder="0.00" type="text" class="validate" pattern="[0-9]+.[0-9]{2}" value="<?php echo $priceUsdAdd; ?>">
                                        <label for="price_usd">Цена в долларах</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 center">
                                        <button class="waves-effect waves-light btn light-blue darken-2" name="actionAdd" type="submit"><i class="material-icons right">add</i>Добавить</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>