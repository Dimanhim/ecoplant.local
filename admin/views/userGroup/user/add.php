<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"><h5>Добавление нового пользователя</h5></div>
    <div class="row">
        <?php
        if ($errors) { ?>
            <blockquote class="error">
                <?php
                for ($i = 0; $i < count($errors); $i++) {
                    echo $errors[$i] . '<br>';
                }
                ?>
            </blockquote>
        <?php } ?>
        <form method="post">
            <div class="row">
                <div class="input-field col s12">
                    <select name="idUserGroup">
                        <option value="" disabled selected>Выберите группу пользователей</option>
                        <?php
                            if ($userGroupList) {
                                while ($row = $userGroupList->fetch()) { ?>
                                    <option value="<?php echo $row['id']; ?>"<?php if ($idUserGroup == $row['id']) echo ' selected'; ?>><?php echo $row['name']; ?></option>
                                    <?php
                                }
                            } ?>
                    </select>
                    <label>Группа пользователей</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="username" name="username" placeholder="Введите логин пользователя" type="text" class="validate" value="<?php echo $username; ?>">
                    <label for="username">Логин пользователя</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="pass" placeholder="Введите пароль пользователя (не менее 6 символов)" type="text" class="validate" value="<?php echo $pass; ?>">
                    <label for="password">Пароль пользователя</label>
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

<?php include(ROOT . '/views/layout/footer.php'); ?>