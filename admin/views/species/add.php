<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить вид</h5>
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
                    <div class="input-field col s9">
                        <input id="lnamespecies" type="text" data-name-letter="id_letter" name="lnamespecies" value="<?php echo $nameSpeciesLat;?>">
                        <label for="lnamespecies">Латинское название</label>
                    </div>
                    <div class="input-field col s3">
                        <input type="checkbox" class="filled-in" id="actuality" name="actuality" <?php if ($actuality) echo 'checked'; ?>>
                        <label for="actuality">Актуальное</label>
                    </div>
                </div>
                <div class="row letter-container">
                    <div class="col s12">
                        <input type="hidden" name="id_letter" value="<?php echo $idLetter; ?>">
                        <p>Выберите латинскую букву алфавита</p>
                        <?php
                        if ($latLetterListSQL) {
                            while ($row = $latLetterListSQL->fetch()) {
                                if ($idLetter == $row["id_alphabet_lat"]) { ?>
                                    <a href="javascript:void();" class="chip letter-select select"
                                       data-id-letter="<?php echo $row["id_alphabet_lat"]; ?>"><?php echo $row["letter"]; ?></a>
                                    <?php
                                } else { ?>
                                    <a href="javascript:void();" class="chip letter-select"
                                       data-id-letter="<?php echo $row["id_alphabet_lat"]; ?>"><?php echo $row["letter"]; ?></a>
                                    <?php
                                }
                            }
                        } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select name="id_object">
                            <?php
                            if ($objectListSQL) {
                                while ($row = $objectListSQL->fetch()) {
                                    if ($idObject == $row["id_object"])
                                        echo "<option value = " . $row["id_object"] . " selected>" . $row["rnameobject"] . "</option>";
                                    else
                                        echo "<option value = " . $row["id_object"] . ">" . $row["rnameobject"] . "</option>";
                                }
                            } ?>
                        </select>
                        <label>Выберите объект</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <select name="id_synonym">
                            <?php
                            if ($speciesWithoutSynonymSQL) {
                                while ($row = $speciesWithoutSynonymSQL->fetch()) {
                                    if ($idSynonym == $row["id_species"])
                                        echo "<option value = " . $row["id_species"] . " selected>" . $row["name_lat"] . "</option>";
                                    else
                                        echo "<option value = " . $row["id_species"] . ">" . $row["name_lat"] . "</option>";
                                }
                            } ?>
                        </select>
                        <label>Вид является синонимом для</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center">
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="action">
                            <i class="material-icons right">add</i>Добавить
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>