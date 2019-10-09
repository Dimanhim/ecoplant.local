<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <div class="col s12">
            <h5>Добавить регистрацистрационные данные препарата</h5>
        </div>
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
    <form method="post" class="row" enctype="multipart/form-data">
        <div class="col s12">
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

            <div class="show_hidden_fields btn light-blue darken-2"><span class="text_1">Показать</span> дополнительные поля</div>

            <div id="container_hidden_fields" class="row hidden_fields">
                <?php
                if ($number) {
                    for ($n = 0; $n < count($number); $n++) { ?>
                        <div class="col s12 m6">
                            <div class="card grey darken-3">
                                <div class="card-content white-text">
                                    <div class="row">
                                      <span class="card-close"><i class="material-icons">close</i></span>
                                        <div class="col s12">Номер свидетельства:
                                            <input type="text" name="number[]" value="<?php if (isset($number[$n])) echo $number[$n]; ?>">
                                        </div>
                                        <div class="col s12">
                                            <div class="row">
                                                <div class="col s6">Дата окончания свидетельства</div>
                                                <div class="col s2">
                                                    <input type="text" name="day[]" placeholder="День" size="4" value="<?php if (isset($day[$n])) echo $day[$n]; ?>">
                                                </div>
                                                <div class="col s2">
                                                    <select name="month[]">
                                                        <?php
                                                        for ($p = 1; $p <= 12; $p++) {
                                                            if ($month[$n] == $p) {
                                                                echo '<option value="' . $p . '" selected>' . $p . '</option>';
                                                            } else {
                                                                echo '<option value="' . $p . '">' . $p . '</option>';
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                                <div class="col s2">
                                                    <select name="year[]">
                                                        <?php
                                                        for ($p = 2013; $p <= 2030; $p++) {
                                                            if ($year[$n] == $p) {
                                                                echo '<option value="' . $p . '" selected>' . $p . '</option>';
                                                            } else {
                                                                echo '<option value="' . $p . '">' . $p . '</option>';
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col s12">Название файла:
                                            <input type="text" name="fileName[]" size="12" value="<?php if (isset($fileName[$n])) echo $fileName[$n]; ?>">
                                            <input type="file" name="file[]">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            <a class="hidden_fields btn light-blue darken-2 addFieldsBtn">Добавить</a>

            <div class="row">
                <div class="col s12"><h5>Культуры</h5></div>
                <div class="input-field col s11">
                    <select id="selectCulture">
                        <?php
                        if ($cultureListSQL) {
                            while ($row = $cultureListSQL->fetch()) { ?>
                                <option value="<?php echo $row['id_culture']; ?>"><?php
                                    echo $row['name_rus'];
                                    ?></option>
                                <?php
                            }
                        } ?>
                    </select>
                </div>
                <div class="input-field col s1">
                    <a class="btn light-blue darken-2 cultureListAdd"><i class="material-icons">add</i></a>
                </div>
                <div class="col s12 cultureList">
                    <div class="chip light-blue darken-2 white-text">Добавленные культуры:</div>
                    <?php
                    if ($idCultureList) {
                        for ($i = 0; $i < count($idCultureList); $i++) { ?>
                            <div class="chip">
                                <input type="hidden" name="selectCulture[]" value="<?php echo $idCultureList[$i]; ?>">
                                <i class="close material-icons">close</i>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col s12"><h5>Группа вредных объектов</h5></div>
                <div class="input-field col s11">
                    <select id="selectObject">
                        <?php
                        if ($objectGroupListSQL) {
                            while($row = $objectGroupListSQL->fetch()) { ?>
                                <option value="<?php echo $row['id_grobject']; ?>"><?php
                                    echo $row['grobject_name_rus'];
                                    ?></option>
                                <?php
                            }
                        } ?>
                    </select>
                </div>
                <div class="input-field col s1">
                    <a class="btn light-blue darken-2 objectListAdd"><i class="material-icons">add</i></a>
                </div>
                <div class="col s12 objectList">
                    <div class="chip light-blue darken-2 white-text">Добавленные вредные объекты:</div>
                    <?php
                    if ($idObjectList) {
                        for ($i = 0; $i < count($idObjectList); $i++) { ?>
                            <div class="chip">
                                <input type="hidden" name="selectObject[]" value="<?php echo $idObjectList[$i]; ?>">
                                <i class="close material-icons">close</i>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="col s12"><h5>Вредные объекты</h5></div>
                <div class="input-field col s11">
                    <select id="selectObject2">
                        <?php
                        if ($objectGroupListSQL2) {
                            while($row = $objectGroupListSQL2->fetch()) { ?>
                                <option value="<?php echo $row['id_object']; ?>"><?php
                                    echo $row['rnameobject'];
                                    ?></option>
                                <?php
                            }
                        } ?>
                    </select>
                </div>
                <div class="input-field col s1">
                    <a class="btn light-blue darken-2 objectListAdd2"><i class="material-icons">add</i></a>
                </div>
                <div class="col s12 objectList2">
                    <div class="chip light-blue darken-2 white-text">Добавленные вредные объекты:</div>
                    <?php
                    if ($idObjectList2) {
                        for ($i = 0; $i < count($idObjectList2); $i++) { ?>
                            <div class="chip">
                                <input type="hidden" name="selectObject2[]" value="<?php echo $idObjectList2[$i]; ?>">
                                <i class="close material-icons">close</i>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m3">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title">Нормы применения препарата (г/га)</span>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="min_prim" type="text" name="min_prim" size="5" value="<?php echo $min_prim; ?>">
                                    <label for="min_prim">Мин.</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="max_prim" type="text" name="max_prim" size="5" value="<?php echo $max_prim; ?>">
                                    <label for="max_prim">Макс.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m3">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title">Способ, время, особенности пременения</span>
                            <div class="row">
                                <div class="input-field col s12">
                                    <textarea id="description" class="materialize-textarea" name="description"><?php echo $desc; ?></textarea>
                                    <label for="description">Текстовое поле</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m3">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title">Сроки ожидания</span>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="waiting_period" type="text" name="waiting_period" size="5" value="<?php echo $waitingPeriod; ?>">
                                    <label for="waiting_period">Текстовое поле</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m3">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title">Кратность обработок</span>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="maxtimes" type="text" name="maxtimes" size="5" value="<?php echo $maxTimes; ?>">
                                    <label for="maxtimes">Текстовое поле</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s12 m3">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <span class="card-title">Сроки выхода для</span>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="date4people" type="text" name="date4people" size="5" value="<?php echo $date4people; ?>">
                                    <label for="date4people">Ручных</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="date4machine" type="text" name="date4machine" size="5" value="<?php echo $date4machine; ?>">
                                    <label for="date4machine">Мех.</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 center">
                    <input type="hidden" name="action" value="action">
                    <button class="waves-effect waves-light btn light-blue darken-2" type="submit"><i class="material-icons right">save</i>Сохранить</button>
                </div>
            </div>
        </div>
    </form>

<?php include(ROOT . '/views/layout/footer.php'); ?>