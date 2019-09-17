<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить литературной ссылки</h5>
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
    </div>
    <div class="row">
        <div class="col s12">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name_link" name="name_link" placeholder="Текст по авторам" type="text" class="validate">
                        <label for="name_link">Текст по авторам</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name_link_eng" name="name_link_eng" placeholder="Текст по авторам (Англ.)" type="text" class="validate">
                        <label for="name_link_eng">Текст по авторам (Англ.) - Не обязательное</label>
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
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="action">
                            <i class="material-icons right">add</i>Добавить
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>