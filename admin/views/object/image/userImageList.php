<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Список фотографий объектов от пользователей</h5>
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
        }

        if ($objectImageList) {
            while ($row = $objectImageList->fetch()) {
                $email = 'не указан';
                if ($row['email']) {
                    $email = $row['email'];
                } ?>
                <form method="post">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="idObject" value="<?php echo $row['id_object']; ?>">
                    <input type="hidden" name="idCulture" value="<?php echo $row['id_culture']; ?>">
                    <ul class="collection with-header collection-not-show-image">
                        <li class="collection-header">
                            <strong><?php echo "Культура: {$row['name_rus']}  > Объект: {$row['rnameobject']}"; ?></strong>
                            <button class="waves-effect waves-light btn light-blue darken-2 right" name="actionPublish" type="submit">Опубликовать</button>
                            <button class="waves-effect waves-light btn red darken-2 right" name="actionDelete" type="submit">Удалить</button>
                        </li>
                        <li class="collection-item"><?php echo "{$row['name']} (Email: $email)"; ?>
                            <br>
                            <a href="#modalImage"><img src="<?php echo USER_SITE_URL; ?>/template/img/object/<?php echo $row['filename']; ?>" alt="<?php echo "Культура: {$row['name_rus']}  > Объект: {$row['rnameobject']}"; ?>"></a>
                        </li>
                    </ul>
                </form>
            <?php
            }
        } ?>
    </div>

    <div id="modalImage" class="modal">
        <div class="modal-content">
            <img src="" alt="">
            <p></p>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>