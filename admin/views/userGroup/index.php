<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"><h5>Группы пользователей</h5></div>
    <?php
        if ($userGroupList) {
            while ($row = $userGroupList->fetch()) { ?>
                <div class="row"><a href="<?php echo PATH; ?>/userGroup/edit/<?php echo $row['id']; ?>"><?php echo $row['name']; ?></a></div>
                <?php
            }
        } ?>
    <div class="row">
        <div class="col s12 right-align">
            <a class="waves-effect waves-light btn light-blue darken-2" href="<?php echo PATH; ?>/userGroup/add">
                <i class="material-icons right">add</i>Добавить новую группу
            </a>
        </div>
    </div>
    <div class="row"><h5>Пользователи</h5></div>
    <?php
        if ($userList) {
            while ($row = $userList->fetch()) { ?>
                <div class="row">
                    <a href="<?php echo PATH; ?>/userGroup/user/edit/<?php echo $row['id_user']; ?>">
                        <?php echo $row['name']; ?> &gt; <?php echo $row['username']; ?></a>
                </div>
                <?php
            }
        } ?>
    <div class="row">
        <div class="col s12 right-align">
            <a class="waves-effect waves-light btn light-blue darken-2" href="<?php echo PATH; ?>/userGroup/user/add">
                <i class="material-icons right">add</i>Добавить нового пользователя
            </a>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>