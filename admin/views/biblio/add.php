<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить литературный источник</h5>
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
                    <div class="col s10">
                        <select name="collection">
                            <option value="" disabled selected>Выберите журнал/сборник/книгу</option>
                            <?php
                            if ($biblioListSQL) {
                                while ($row = $biblioListSQL->fetch()) {
                                    echo "<option value = " . $row["id_biblio_collection"] . ">" . $row["name_collection"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="col s2"><a href="<?php echo PATH; ?>/biblio/collection/add">Добавить журнал/сборник/книгу</a></div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name_work" type="text" name="name_work">
                        <label for="name_work">Название работы</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name_work_eng" type="text" name="name_work_eng">
                        <label for="name_work_eng">Название работы на английском языке</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s4">
                        <select name="year">
                            <option value="" disabled selected>Год публикации</option>
                            <?php
                            if ($biblioYearListSQL) {
                                while ($row = $biblioYearListSQL->fetch()) {
                                    echo "<option value = " . $row["id_year"] . ">" . $row["year"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="col s4">
                        <select name="volume">
                            <option value="" disabled selected>Том</option>
                            <?php
                            if ($biblioVolumeListSQL) {
                                while ($row = $biblioVolumeListSQL->fetch()) {
                                    echo "<option value = " . $row["id_biblio_volume"] . ">" . $row["biblio_volume"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="col s4">
                        <select name="number">
                            <option value="" disabled selected>Номер</option>
                            <?php
                            if ($biblioNumberListSQL) {
                                while ($row = $biblioNumberListSQL->fetch()) {
                                    echo "<option value = " . $row["id_biblio_number"] . ">" . $row["biblio_number"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="pages" type="text" name="pages">
                        <label for="pages">Страницы <i>(например, 20-25)</i></label>
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