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
                    <div class="input-field col s12">
                        <input id="surname" name="surname" type="text" class="validate">
                        <label for="surname">Фамилия автора</label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
                        <input id="surname_eng" name="surname_eng" type="text" class="validate">
                        <label for="surname_eng">Фамилия автора на английском языке</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="firstname_short" name="firstname_short" type="text" class="validate">
                        <label for="firstname_short">Инициалы имени автора</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="firstname_short_eng" name="firstname_short_eng" type="text" class="validate">
                        <label for="firstname_short_eng">Инициалы имени автора на английском языке</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="patronymic_short" name="patronymic_short" type="text" class="validate">
                        <label for="patronymic_short">Инициалы отчества автора</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="patronymic_short_eng" name="patronymic_short_eng" type="text" class="validate">
                        <label for="patronymic_short_eng">Инициалы отчества автора на английском языке</label>
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