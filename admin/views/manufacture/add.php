<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <div class="col s12"><h5>Добавить производителя в БД</h5></div>
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
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name_manufacture_rus" type="text" name="name_manufacture_rus" data-name-letter="id_letter">
                        <label for="name_manufacture_rus">Название</label>
                    </div>
                    <div class="input-field col s12">
                        <button class="waves-effect waves-light btn light-blue darken-2 right" type="submit"><i class="material-icons right">add</i>Добавить</button>
                    </div>
                </div>
                <div class="row letter-container">
                    <div class="col s12">
                        <input type="hidden" name="id_letter" value="<?php echo $idLetter; ?>">
                        <p>Выберите русскую букву алфавита</p>
                        <?php
                        if ($rusLetterListSQL) {
                            while ($row = $rusLetterListSQL->fetch()) {
                                if ($idLetter == $row["id_alphabet_rus"]) { ?>
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
                    <div class="col s12">
                        <h5>Добавление логотипа</h5>
                        <div class="file-field input-field">
                            <div class="btn blue">
                                <span>Выбор фотографии</span>
                                <input type="file" multiple class="photos" name="photo">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" placeholder="Загрузите фотографию">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <ul class="collection with-header">
                <li class="collection-header"><h5>Производители пестицидов, зарегистрированные в России</h5></li>
                <?php
                // Установление соединения с таблицой Продукт. Вывод всех гербицидов
                if ($manufactureListSQL) {
                    while ($row = $manufactureListSQL->fetch()) {
                        echo '<li class="collection-item">' . $row["name_manufacture_rus"] .
                            '<i class="material-icons delete-button delete-button-manufacture" data-id="' . $row["id_manufacture"] . '">delete</i></li>';
                    }
                } ?>
            </ul>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>