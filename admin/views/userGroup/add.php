<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"><h5>Добавление новой группы пользователей</h5></div>
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
                    <input id="name" name="name" placeholder="Введите название группы" type="text" class="validate" value="<?php echo $name; ?>">
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
                                    <?php if (isset($_POST['admin-block-func-' . $row['id']]) &&
                                    $_POST['admin-block-func-' . $row['id']] == 'on') {
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
                        <i class="material-icons right">add</i>Добавить
                    </button>
                </div>
            </div>
        </form>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>