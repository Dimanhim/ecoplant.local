<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить Литературу</h5>
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
                    <div class="col s12">
                        Выберите авторов
                    </div>
                </div>
                <div class="row">
                    <?php
                    if ($biblioAuthorListSQL) {
                        $index = 0;
                        while ($row = $biblioAuthorListSQL->fetch()) { ?>
                            <div class="col s6">
                                <input type="checkbox" id="author<?php echo $index; ?>" name='author[]' value="<?php echo $row["id_biblio_author"]; ?>" />
                                <label for="author<?php echo $index; ?>"><?php echo $row["surname"] . " " . $row["firstname_short"] . " " . $row["patronymic_short"]; ?></label>
                            </div>
                            <?php
                            $index++;
                        }
                    } ?>
                </div>
                <div class="row center"><a href="<?php echo PATH; ?>/biblio/author/add/<?php echo $idBiblioWork; ?>">Добавить автора</a></div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="link1" name="link" type="text" class="validate">
                        <label for="link1">Литературная ссылка <i>(например, Пашков и др., 1997)</i></label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="link2" name="link_eng" type="text" class="validate">
                        <label for="link2">Литературная ссылка на английском <i>(например, Pashkov at al., 1997)</i></label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="elink" name="elink" placeholder="Ссылка на источник" type="text" class="validate">
                        <label for="elink">Ссылка на источник в сети интернет</label>
                    </div>
                </div>
                <div class="file-field input-field">
                    <div class="btn light-blue darken-2">
                        <span>Прикрепить pdf-файл</span>
                        <input type="file" name="file">
                    </div>
                    <div class="file-path-wrapper">
                        <input class="file-path validate" type="text" name="file_name">
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center">
                        <input type="hidden" name="action">
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit"><i class="material-icons right">add</i>Добавить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>