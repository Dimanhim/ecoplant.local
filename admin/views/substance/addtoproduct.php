<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавление действующего вещества</h5>
    </div>
    <div class="row">
        <div class="col s12">
            <blockquote>
                Вы добавили препарат: <?php echo $_SESSION['nameProductRus']; ?>
            </blockquote>
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
    <div class="row">
        <div class="col s12">
            <form method="post">
                <div class="row">
                    <div class="input-field col s10">
                        <select name="substance">
                            <option value="" disabled selected>Выберите действующее вещество</option>
                            <?php
                            if ($substanceListSQL) {
                                while ($row = $substanceListSQL->fetch()) {
                                    echo "<option value = " . $row["id_substance"] . ">" . $row["name_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="col s2"><a href="<?php echo PATH; ?>/substance/add">Добавить действующее вещество</a></div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input id="substance_unit" name="concentration" type="text" class="validate">
                        <label for="substance_unit">Количество д.в. в препарате</label>
                    </div>
                    <div class="input-field col s6">
                        <select name="substance_unit">
                            <?php
                            if ($substanceUnitListSQL) {
                                while ($row = $substanceUnitListSQL->fetch()) {
                                    echo "<option value = " . $row["id_substance_unit"] . ">" . $row["name_substance_unit_rus"] . "</option>";
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