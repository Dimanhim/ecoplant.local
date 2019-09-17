<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Редактирование описания объекта</h5>
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

        <form method="post">
            <div class="row">
                <div class="col s12">
                    <div class="row">
                        <div class="input-field col s10">
                            <select name="objectId">
                                <?php
                                if ($objectListSQL) {
                                    while ($row = $objectListSQL->fetch()) {
                                        if ($objectId == $row["id_object"]) {
                                            echo "<option value='{$row["id_object"]}' selected='selected'>{$row["rnameobject"]}</option>";
                                        } else {
                                            echo "<option value='{$row["id_object"]}'>{$row["rnameobject"]}</option>";
                                        }
                                    }
                                } ?>
                            </select>
                            <label>Выберите объект</label>
                        </div>
                        <div class="input-field col s2"><a href="<?php echo PATH; ?>/object/add">Добавить объект</a></div>
                    </div>

                    <?php
//                    if (isset($descBiology) && $descBiology != 'delete') {
                    if (isset($descBiology) && is_array($descBiology)) { ?>
                        <div class="row desc_biology_block desc-block">
                            <div class="col s12">
                                <h5>
                                    <span class="index">1.</span> Описание биологии объекта
                                    <div class="chip chip-desc-block">Удалить<i class="close close-desc-block material-icons">close</i></div>
                                </h5>
                            </div>
                            <div class="input-field col s12">
                            <textarea id="desc_biology" class="materialize-textarea" name="desc_biology[]"><?php
                                if (isset($descBiology) && is_array($descBiology)) {
                                    echo $descBiology[0];
                                } ?></textarea>
                                <label for="desc_biology">Описание биологии объекта</label>
                            </div>
                            <div class="input-field col s10">
                                <select name="desc_biology_biblio_link[]">
                                    <?php
                                    if ($biblioLinkSQL) {
                                        while ($row = $biblioLinkSQL->fetch()) {
                                            if (is_array($idDescBiologyBiblioLink) &&
                                                isset($idDescBiologyBiblioLink[0]) && $idDescBiologyBiblioLink[0] == $row["id_biblio_link"] &&
                                                isset($idDescBiologyBiblioLinkAutocomplete[0]) && $idDescBiologyBiblioLinkAutocomplete[0]) {
                                                echo "<option value='{$row["id_biblio_link"]}' selected='selected'>{$row["name_link"]}</option>";
                                            } else {
                                                echo "<option value='{$row["id_biblio_link"]}'>{$row["name_link"]}</option>";
                                            }
                                        }
                                    } ?>
                                </select>
                                <label>Литературный источник для описания биологии объекта</label>
                            </div>
                            <div class="input-field col s2"><a href="<?php echo PATH; ?>/biblio/add">Добавить другой источник</a></div>
                        </div>
                        <?php
                    }
                    if (isset($descBiology) && is_array($descBiology)) {
                            for ($i = 1; $i < count($descBiology); $i++) { ?>
                                <div class="row desc_biology_block desc-block">
                                    <div class="col s12">
                                        <h5>
                                            <span class="index"><?php echo $i + 1; ?>.</span> Описание биологии объекта
                                            <div class="chip chip-desc-block">Удалить<i class="close close-desc-block material-icons">close</i></div>
                                        </h5>
                                    </div>
                                    <div class="input-field col s12">
                                        <textarea id="desc_biology" class="materialize-textarea" name="desc_biology[]"><?php
                                            if (isset($descBiology) && is_array($descBiology)) {
                                                echo $descBiology[$i];
                                            } ?></textarea>
                                        <label for="desc_biology">Описание биологии объекта</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <select name="desc_biology_biblio_link[]">
                                            <?php
                                            if ($biblioLinkSQL) {
                                                $biblioLinkSQL->execute();
                                                while ($row = $biblioLinkSQL->fetch()) {
                                                    if (isset($idDescBiologyBiblioLink[$i]) &&
                                                        isset($idDescBiologyBiblioLink[$i]) && $idDescBiologyBiblioLink[$i] == $row["id_biblio_link"] &&
                                                        isset($idDescBiologyBiblioLinkAutocomplete[$i]) && $idDescBiologyBiblioLinkAutocomplete[$i]) {
                                                        echo "<option value='{$row["id_biblio_link"]}' selected='selected'>{$row["name_link"]}</option>";
                                                    } else {
                                                        echo "<option value='{$row["id_biblio_link"]}'>{$row["name_link"]}</option>";
                                                    }
                                                }
                                            } ?>
                                        </select>
                                        <label>Литературный источник для описания биологии объекта</label>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                    ?>
                    <div class="row">
                        <div class="col s12 center">
                            <a href="javascript:void(0);" class="waves-effect waves-light btn light-blue darken-2 add_desc_biology_block">
                                <i class="material-icons right">add</i>Добавить описание биологии объекта
                            </a>
                        </div>
                    </div>

                    <?php
                    //if (isset($descDevelopment) && $descDevelopment != 'delete') {
                    if (isset($descDevelopment) && is_array($descDevelopment)) { ?>
                        <div class="row desc_development_block desc-block">
                            <div class="col s12">
                                <h5>
                                    <span class="index">1.</span> Описание развития поражения
                                    <div class="chip chip-desc-block">Удалить<i class="close close-desc-block material-icons">close</i></div>
                                </h5>
                            </div>
                            <div class="input-field col s12">
                            <textarea id="desc_development" class="materialize-textarea" name="desc_development[]"><?php
                                if (isset($descDevelopment) && is_array($descDevelopment)) {
                                    echo $descDevelopment[0];
                                } ?></textarea>
                                <label for="desc_development">Описание развития поражения</label>
                            </div>
                            <div class="input-field col s10">
                                <select name="desc_development_biblio_link[]">
                                    <?php
                                    if ($biblioLinkSQL) {
                                        $biblioLinkSQL->execute();
                                        while ($row = $biblioLinkSQL->fetch()) {
                                            if (is_array($idDescDevelopmentBiblioLink) &&
                                                isset($idDescDevelopmentBiblioLink[0]) && $idDescDevelopmentBiblioLink[0] == $row["id_biblio_link"] &&
                                                isset($idDescDevelopmentBiblioLinkAutoComplete[0]) && $idDescDevelopmentBiblioLinkAutoComplete[0]) {
                                                echo "<option value='{$row["id_biblio_link"]}' selected='selected'>{$row["name_link"]}</option>";
                                            } else {
                                                echo "<option value='{$row["id_biblio_link"]}'>{$row["name_link"]}</option>";
                                            }
                                        }
                                    } ?>
                                </select>
                                <label>Литературный источник для описания развития поражения</label>
                            </div>
                            <div class="input-field col s2"><a href="<?php echo PATH; ?>/biblio/add">Добавить другой источник</a></div>
                        </div>
                        <?php
                    }
                    if (isset($descDevelopment) && is_array($descDevelopment)) {
                            for ($i = 1; $i < count($descDevelopment); $i++) { ?>
                                <div class="row desc_development_block desc-block">
                                    <div class="col s12">
                                        <h5>
                                            <span class="index"><?php echo $i + 1; ?>.</span> Описание развития поражения
                                            <div class="chip chip-desc-block">Удалить<i class="close close-desc-block material-icons">close</i></div>
                                        </h5>
                                    </div>
                                    <div class="input-field col s12">
                                    <textarea id="desc_development" class="materialize-textarea" name="desc_development[]"><?php
                                        echo $descDevelopment[$i]; ?></textarea>
                                        <label for="desc_development">Описание развития поражения</label>
                                    </div>
                                    <div class="input-field col s10">
                                        <select name="desc_development_biblio_link[]">
                                            <?php
                                            if ($biblioLinkSQL) {
                                                $biblioLinkSQL->execute();
                                                while ($row = $biblioLinkSQL->fetch()) {
                                                    if (is_array($idDescDevelopmentBiblioLink) &&
                                                        isset($idDescDevelopmentBiblioLink[$i]) && $idDescDevelopmentBiblioLink[$i] == $row["id_biblio_link"] &&
                                                        isset($idDescDevelopmentBiblioLinkAutoComplete[$i]) && $idDescDevelopmentBiblioLinkAutoComplete[$i]) {
                                                        echo "<option value='{$row["id_biblio_link"]}' selected='selected'>{$row["name_link"]}</option>";
                                                    } else {
                                                        echo "<option value='{$row["id_biblio_link"]}'>{$row["name_link"]}</option>";
                                                    }
                                                }
                                            } ?>
                                        </select>
                                        <label>Литературный источник для описания развития поражения</label>
                                    </div>
                                    <div class="input-field col s2"><a href="<?php echo PATH; ?>/biblio/add">Добавить другой источник</a></div>
                                </div>
                                <?php
                            }
                        } ?>
                    <div class="row">
                        <div class="col s12 center">
                            <a href="javascript:void(0);" class="waves-effect waves-light btn light-blue darken-2 add_desc_development_block">
                                <i class="material-icons right">add</i>Добавить описание развития поражения
                            </a>
                        </div>
                    </div>

                    <?php
                    //if (isset($descSignificance) && $descSignificance != 'delete') {
                    if (isset($descSignificance) && is_array($descSignificance)) { ?>
                        <div class="row desc_significance_block desc-block">
                            <div class="col s12">
                                <h5>
                                    <span class="index">1.</span> Описание экономического значения
                                    <div class="chip chip-desc-block">Удалить<i class="close close-desc-block material-icons">close</i></div>
                                </h5>
                            </div>
                            <div class="input-field col s12">
                            <textarea id="desc_significance" class="materialize-textarea" name="desc_significance[]"><?php
                                if (isset($descSignificance) && is_array($descSignificance)) {
                                    echo $descSignificance[0];
                                } ?></textarea>
                                <label for="desc_significance">Описание экономического значения</label>
                            </div>
                            <div class="input-field col s10">
                                <select name="desc_significance_biblio_link[]">
                                    <?php
                                    if ($biblioLinkSQL) {
                                        $biblioLinkSQL->execute();
                                        while ($row = $biblioLinkSQL->fetch()) {
                                            if (is_array($idDescSignificanceBiblioLink) &&
                                                isset($idDescSignificanceBiblioLink[0]) && $idDescSignificanceBiblioLink[0] == $row["id_biblio_link"] &&
                                                isset($idDescSignificanceBiblioLinkAutocomplete[0]) && $idDescSignificanceBiblioLinkAutocomplete[0]) {
                                                echo "<option value='{$row["id_biblio_link"]}' selected='selected'>{$row["name_link"]}</option>";
                                            } else {
                                                echo "<option value='{$row["id_biblio_link"]}'>{$row["name_link"]}</option>";
                                            }
                                        }
                                    } ?>
                                </select>
                                <label>Литературный источник для описания экономического значения</label>
                            </div>
                            <div class="input-field col s2"><a href="<?php echo PATH; ?>/biblio/add">Добавить другой источник</a></div>
                        </div>
                        <?php
                    }
                    if (isset($descSignificance) && is_array($descSignificance)) {
                            for ($i = 1; $i < count($descSignificance); $i++) { ?>
                                <div class="row desc_significance_block desc-block">
                                    <div class="col s12">
                                        <h5>
                                            <span class="index"><?php echo $i + 1; ?>.</span> Описание экономического значения
                                            <div class="chip chip-desc-block">Удалить<i class="close close-desc-block material-icons">close</i></div>
                                        </h5>
                                    </div>
                                    <div class="input-field col s12">
                                        <textarea id="desc_significance" class="materialize-textarea" name="desc_significance[]"><?php
                                            echo $descSignificance[$i]; ?></textarea>
                                        <label for="desc_significance">Описание экономического значения</label>
                                    </div>
                                    <div class="input-field col s10">
                                        <select name="desc_significance_biblio_link[]">
                                            <?php
                                            if ($biblioLinkSQL) {
                                                $biblioLinkSQL->execute();
                                                while ($row = $biblioLinkSQL->fetch()) {
                                                    if (is_array($idDescSignificanceBiblioLink) &&
                                                        isset($idDescSignificanceBiblioLink[$i]) && $idDescSignificanceBiblioLink[$i] == $row["id_biblio_link"] &&
                                                        isset($idDescSignificanceBiblioLinkAutocomplete[$i]) && $idDescSignificanceBiblioLinkAutocomplete[$i]) {
                                                        echo "<option value='{$row["id_biblio_link"]}' selected='selected'>{$row["name_link"]}</option>";
                                                    } else {
                                                        echo "<option value='{$row["id_biblio_link"]}'>{$row["name_link"]}</option>";
                                                    }
                                                }
                                            } ?>
                                        </select>
                                        <label>Литературный источник для описания экономического значения</label>
                                    </div>
                                    <div class="input-field col s2"><a href="<?php echo PATH; ?>/biblio/add">Добавить другой источник</a></div>
                                </div>
                                <?php
                            }
                        } ?>
                    <div class="row">
                        <div class="col s12 center">
                            <a href="javascript:void(0);" class="waves-effect waves-light btn light-blue darken-2 add_desc_significance_block">
                                <i class="material-icons right">add</i>Добавить описание экономического значения
                            </a>
                        </div>
                    </div>

                    <?php
                    //if (isset($descSymptoms) && $descSymptoms != 'delete') {
                    if (isset($descSymptoms) && is_array($descSymptoms)) { ?>
                        <div class="row desc_symptoms_block desc-block">
                            <div class="col s12">
                                <h5>
                                    <span class="index">1.</span> Описание симптомов
                                    <div class="chip chip-desc-block">Удалить<i class="close close-desc-block material-icons">close</i></div>
                                </h5>
                            </div>
                            <div class="input-field col s12">
                            <textarea id="desc_symptoms" class="materialize-textarea" name="desc_symptoms[]"><?php
                                if (isset($descSymptoms) && is_array($descSymptoms)) {
                                    echo $descSymptoms[0];
                                } ?></textarea>
                                <label for="desc_symptoms">Описание симптомов</label>
                            </div>
                            <div class="input-field col s10">
                                <select name="desc_symptoms_biblio_link[]">
                                    <?php
                                    if ($biblioLinkSQL) {
                                        $biblioLinkSQL->execute();
                                        while ($row = $biblioLinkSQL->fetch()) {
                                            if (is_array($idDescSymptomsBiblioLink) &&
                                                isset($idDescSymptomsBiblioLink[0]) && $idDescSymptomsBiblioLink[0] == $row["id_biblio_link"] &&
                                                isset($idDescSymptomsBiblioLinkAutoComplete[0]) && $idDescSymptomsBiblioLinkAutoComplete[0]) {
                                                echo "<option value='{$row["id_biblio_link"]}' selected='selected'>{$row["name_link"]}</option>";
                                            } else {
                                                echo "<option value='{$row["id_biblio_link"]}'>{$row["name_link"]}</option>";
                                            }
                                        }
                                    } ?>
                                </select>
                                <label>Литературный источник для описания симптомов</label>
                            </div>
                            <div class="input-field col s2"><a href="<?php echo PATH; ?>/biblio/add">Добавить другой источник</a></div>
                        </div>
                        <?php
                    }
                    if (isset($descSymptoms) && is_array($descSymptoms)) {
                        for ($i = 1; $i < count($descSymptoms); $i++) { ?>
                            <div class="row desc_symptoms_block desc-block">
                                <div class="col s12">
                                    <h5>
                                        <span class="index"><?php echo $i + 1; ?>.</span> Описание симптомов
                                        <div class="chip chip-desc-block">Удалить<i class="close close-desc-block material-icons">close</i></div>
                                    </h5>
                                </div>
                                <div class="input-field col s12">
                                    <textarea id="desc_symptoms" class="materialize-textarea" name="desc_symptoms[]"><?php
                                        echo $descSymptoms[$i]; ?></textarea>
                                    <label for="desc_symptoms">Описание симптомов</label>
                                </div>
                                <div class="input-field col s12">
                                    <select name="desc_symptoms_biblio_link[]">
                                        <?php
                                        if ($biblioLinkSQL) {
                                            $biblioLinkSQL->execute();
                                            while ($row = $biblioLinkSQL->fetch()) {
                                                if (is_array($idDescSymptomsBiblioLink) &&
                                                    isset($idDescSymptomsBiblioLink[$i]) && $idDescSymptomsBiblioLink[$i] == $row["id_biblio_link"] &&
                                                    isset($idDescSymptomsBiblioLinkAutoComplete[$i]) && $idDescSymptomsBiblioLinkAutoComplete[$i]) {
                                                    echo "<option value='{$row["id_biblio_link"]}' selected='selected'>{$row["name_link"]}</option>";
                                                } else {
                                                    echo "<option value='{$row["id_biblio_link"]}'>{$row["name_link"]}</option>";
                                                }
                                            }
                                        } ?>
                                    </select>
                                    <label>Литературный источник для описания симптомов</label>
                                </div>
                            </div>
                            <?php
                        }
                    } ?>
                    <div class="row">
                        <div class="col s12 center">
                            <a href="javascript:void(0);" class="waves-effect waves-light btn light-blue darken-2 add_desc_symptoms_block">
                                <i class="material-icons right">add</i>Добавить описание симптомов
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s12 center">
                            <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="action"><i class="material-icons right">save</i>Сохранить</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="hidden" style="display: none;">
            <select name="biblio_link">
                <?php
                if ($biblioLinkSQL) {
                    $biblioLinkSQL->execute();
                    while ($row = $biblioLinkSQL->fetch()) {
                        echo "<option value='{$row["id_biblio_link"]}'>{$row["name_link"]}</option>";
                    }
                } ?>
            </select>
        </div>


<?php include(ROOT . '/views/layout/footer.php'); ?>