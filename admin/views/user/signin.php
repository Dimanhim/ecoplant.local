<?php include (ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <div class="col s12">
            <div class="row">
                <h4>Авторизация</h4>
            </div>
            <?php if ($errors) { ?>
                <blockquote class="error">
                    <?php
                    for ($i = 0; $i < count($errors); $i++) {
                        echo $errors[$i] . '<br>';
                    }
                    ?>
                </blockquote>
            <?php } else { ?>
                <div class="row">
                    <blockquote>Для отображения страницы войдите в систему.</blockquote>
                </div>
                <?php
            } ?>
            <form method="post">
                Имя: <input class="textfield" type="text" name="login" value="<?php echo $login; ?>">
                Пароль: <input class="textfield" type="password" name="password">
                <button class="waves-effect waves-light btn light-blue darken-2" type="submit">Войти</button>
            </form>
        </div>
    </div>

<?php include (ROOT . '/views/layout/footer.php'); ?>