<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить объект</h5>
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
                        <input id="rnameobject" type="text" name="rnameobject" data-name-letter="id_letter">
                        <label for="rnameobject">Русское название</label>
                    </div>
                </div>
                <div class="row letter-container">
                    <div class="col s12">
                        <input type="hidden" name="id_letter" value="<?php echo $idLetterRus; ?>">
                        <p>Выберите русскую букву алфавита</p>
                        <?php
                        if ($rusLetterListSQL) {
                            while ($row = $rusLetterListSQL->fetch()) {
                                if ($idLetterRus == $row["id_alphabet_rus"]) { ?>
                                    <a href="javascript:void();" class="chip letter-select select"
                                       data-id-letter="<?php echo $row["id_alphabet_rus"]; ?>"><?php echo $row["letter"]; ?></a>
                                    <?php
                                } else { ?>
                                    <a href="javascript:void();" class="chip letter-select"
                                       data-id-letter="<?php echo $row["id_alphabet_rus"]; ?>"><?php echo $row["letter"]; ?></a>
                                    <?php
                                }
                            }
                        } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="engnameobject" type="text" name="engnameobject">
                        <label for="engnameobject">Английское название</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <select name="id_clobject">
                            <option value="" disabled selected>Выберите класс объекта</option>
                            <?php
                            if ($objectClassListSQL) {
                                while ($row = $objectClassListSQL->fetch()) {
                                    echo "<option value = " . $row["id_clobject"] . ">" . $row["name_clobject_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12"><h5>Культуры</h5></div>
                    <div class="input-field col s11">
                        <select id="selectCulture">
                            <?php
                            // Установление соединения с таблицой Культура
                            if ($cultureListSQL) {
                                while ($row = $cultureListSQL->fetch()) {
                                    print "<option value = " . $row["id_culture"] . ">" . $row["name_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="input-field col s1">
                        <button class="btn light-blue darken-2 culture-add-btn"><i class="material-icons">add</i></button>
                    </div>
                    <div class="col s12 cultureList">
                        <div class="chip light-blue darken-2 white-text">Добавленные культуры:</div>
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