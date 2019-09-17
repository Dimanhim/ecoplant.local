<?php include (ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить состав удобрения</h5>
    </div>
    <?php
    if (isset($errors) && is_array($errors)) {
        for ($i = 0; $i < count($errors); $i++) { ?>
            <blockquote class="error"><?php echo $errors[$i]; ?></blockquote>
            <?php
        }
    }
    if (isset($success) && is_array($success)) {
        for ($i = 0; $i < count($success); $i++) { ?>
            <blockquote><?php echo $success[$i]; ?></blockquote>
            <?php
        }
    } ?>
    <div class="row">
        <div class="col s12">
            <form method="post">
                <div class="element-container">
                    <div class="col s12 m6 element">
                        <div class="card grey darken-3">
                            <div class="card-content white-text">
                                <div class="row">
                                    <div class="input-field col s10">
                                        <select name="element_0">
                                            <?php
                                            if ($elementList) {
                                                while ($row = $elementList->fetch()) {
                                                    echo "<option value = " . $row["id_element"] . ">" . $row["name_rus"] . " (" . $row["chemformulation"] . ")</option>";
                                                }
                                            } ?>
                                        </select>
                                        <label>Выберите элемент</label>
                                    </div>
                                    <div class="col s2"><a href="<?php echo PATH; ?>/element/add">Добавить элемент</a></div>
                                    <div class="input-field col s12">
                                        <input id="concentration" name="concentration[]" placeholder="Концентрация" type="text" class="validate">
                                        <label for="concentration">Концентрация</label>
                                    </div>
                                    <div class="input-field col s12">
                                        <select name="idSubstanceUnit[]">
                                            <option value="" disabled selected>Выберите ед. измерения</option>
                                            <?php
                                            if ($substanceUnitList) {
                                                while ($row = $substanceUnitList->fetch()) { ?>
                                                    <option value="<?php echo $row['id_substance_unit']; ?>"><?php echo $row['name_substance_unit_rus']; ?></option>
                                                    <?php
                                                }
                                            } ?>
                                        </select>
                                        <label>Единица измерения</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center">
                        <button class="waves-effect waves-light btn light-blue darken-2 add-element" style="margin-right: 30px;">
                            <i class="material-icons right">add</i>Добавить еще один элемент
                        </button>
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="actionAdd">
                            <i class="material-icons right">save</i>Сохранить
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include (ROOT . '/views/layout/footer.php'); ?>