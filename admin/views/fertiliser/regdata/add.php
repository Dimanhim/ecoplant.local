<?php include (ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить регистрационную информацию</h5>
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
                <div class="row">
                    <div class="input-field col s12">
                        <select name="idFertiliser">
                            <?php
                                if ($fertiliserList) {
                                    while ($row = $fertiliserList->fetch()) { ?>
                                        <option value="<?php echo $row['id_fertiliser']; ?>"<?php
                                        if ($idFertiliser == $row['id_fertiliser'])
                                            echo ' selected';
                                        ?>><?php echo $row['name_fertiliser']; ?></option>
                                        <?php
                                    }
                                } ?>
                        </select>
                        <label>Выберите удобрение</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12"><h5>Культуры</h5></div>
                    <div class="input-field col s11">
                        <select id="selectCulture">
                            <?php
                            // Установление соединения с таблицой Культура
                            if ($cultureList) {
                                while ($row = $cultureList->fetch()) {
                                    echo "<option value = " . $row["id_culture"] . ">" . $row["name_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="input-field col s1">
                        <button class="btn light-blue darken-2 culture-add-btn"><i class="material-icons">add</i></button>
                    </div>
                    <div class="col s12 cultureList">
                        <div class="chip light-blue darken-2 white-text">Добавленные культуры:</div>
                        <?php
                        if ($selectCulture) {
                            for ($i = 0; $i < count($selectCulture); $i++) { ?>
                                <div class="chip">
                                    <input type="hidden" name="selectCulture[]"
                                           value="<?php echo $selectCulture[$i]; ?>"><?php Culture::get($selectCulture[$i])['name_rus']; ?>
                                    <i class="close material-icons">close</i>
                                </div>
                                <?php
                            }
                        } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="min_rate" name="min_rate" placeholder="Мин. норма" type="text" class="validate" value="<?php echo $min_rate; ?>">
                        <label for="min_rate">Мин. норма</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="max_rate" name="max_rate" placeholder="Макс. норма" type="text" class="validate" value="<?php echo $max_rate; ?>">
                        <label for="max_rate">Макс. норма</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="reglament" class="materialize-textarea" name="reglament"><?php echo $reglament; ?></textarea>
                        <label for="reglament">Описание регламента</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center">
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="actionAdd">
                            <i class="material-icons right">add</i>Добавить
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include (ROOT . '/views/layout/footer.php'); ?>