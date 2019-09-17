<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"><h5>Редактирование пользователя</h5></div>
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
        <form method="post">
            <div class="row">
                <div class="input-field col s12">
                    <select name="idUserGroup">
                        <option value="" disabled selected>Выберите группу пользователей</option>
                        <?php
                        if ($userGroupList) {
                            while ($row = $userGroupList->fetch()) { ?>
                                <option value="<?php echo $row['id']; ?>"<?php if ($user['id_user_group'] == $row['id']) echo ' selected'; ?>><?php echo $row['name']; ?></option>
                                <?php
                            }
                        } ?>
                    </select>
                    <label>Группа пользователей</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="username" name="username" placeholder="Введите логин пользователя" type="text" class="validate" value="<?php echo $user['username']; ?>" disabled>
                    <label for="username">Логин пользователя</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field col s12">
                    <input id="password" name="pass" placeholder="Введите новый пароль пользователя (не менее 6 символов)" type="text" class="validate" value="<?php echo $pass; ?>">
                    <label for="password">Новый пароль пользователя</label>
                </div>
            </div>
            <div class="row">
                <div class="col s12 center">
                    <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="action">
                        <i class="material-icons right">save</i>Сохранить
                    </button>
                </div>
            </div>
            <?php
            if ($idUser != 1) { ?>
                <div class="row col s12 center">или</div>
                <div class="row">
                    <div class="col s12 center">
                        <a class="waves-effect waves-light btn light-blue darken-2"
                           href="<?php echo PATH; ?>/userGroup/user/delete/<?php echo $idUser; ?>">
                            <i class="material-icons right">delete</i>Удалить пользователя
                        </a>
                    </div>
                </div>
                <?php
            } ?>
        </form>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>