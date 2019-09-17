<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"><h5>Редактирование группы пользователей</h5></div>
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
                    <input id="name" name="name" placeholder="Введите название группы" type="text" class="validate" value="<?php
                    if ($userGroup) {
                        echo $userGroup['name'];
                    } ?>">
                    <label for="name">Название группы</label>
                </div>
            </div>
            <?php
            if ($adminBlockFuncList) {
                $adminBlockFuncList->execute();
                while ($row = $adminBlockFuncList->fetch()) { ?>
                    <p>
                        <input type="checkbox" id="admin-block-func-<?php echo $row['id']; ?>"
                               name="admin-block-func-<?php echo $row['id']; ?>"
                            <?php if (isset($adminBlockFuncArray[$row['id']])) {
                                echo 'checked';
                            } ?>>
                        <label for="admin-block-func-<?php echo $row['id']; ?>"><?php echo $row['name']; ?></label>
                    </p>
                    <?php
                }
            }
            ?>
            <div class="row">
                <div class="col s12 center">
                    <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="action">
                        <i class="material-icons right">save</i>Сохранить
                    </button>
                </div>
            </div>
        </form>
        <?php
        if ($idUserGroup != 1) { ?>
            <div class="row col s12 center">или</div>
            <div class="row">
                <div class="col s12 center">
                    <a class="waves-effect waves-light btn light-blue darken-2"
                       href="<?php echo PATH; ?>/userGroup/delete/<?php echo $idUserGroup; ?>">
                        <i class="material-icons right">delete</i>Удалить группу
                    </a>
                </div>
            </div>
            <?php
        } ?>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>