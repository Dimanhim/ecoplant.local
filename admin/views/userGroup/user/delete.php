<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"><h5>Удаление пользователя</h5></div>
    <div class="row">
        <div class="col s12">Вы уверены, что хотите удалить пользователя "<?php echo $user['username']; ?>"</div>
    </div>
    <div class="row">
        <form method="post" class="col s12">
            <div class="row">
                <div class="col s6">
                    <a class="waves-effect waves-light btn light-blue darken-2"
                       href="<?php echo PATH; ?>/userGroup/user/edit/<?php echo $idUser; ?>">Отменить</a>
                </div>
                <div class="col s6 right-align">
                    <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="action">
                        <i class="material-icons right">delete</i>Удалить
                    </button>
                </div>
            </div>
        </form>
    </div>


<?php include(ROOT . '/views/layout/footer.php'); ?>