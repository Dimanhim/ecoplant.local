<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"></div>
    <div class="row">
        <?php include (ROOT . '/views/layout/leftmenu4object.php'); ?>

        <div class="col s12 m9 content-row">
            <div class="row">
                <nav class="breadcrumb-nav">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="<?php echo PATH; ?>/" class="breadcrumb">Главная</a>
                            <a href="<?php echo PATH; ?>/object" class="breadcrumb">Вредные объекты</a>
                            <a href="javascript:void(0);" class="breadcrumb">По культуре</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row title"><p>Выберите объект по поражению культуры</p></div>
            <div class="row">
                <?php
                if ($objectClassListSQL) {
                    while ($row = $objectClassListSQL->fetch()) { ?>
                        <p><?php echo $cultureName . '<i class="material-icons bread-i">chevron_right</i>' . $row['name_clobject_rus']; ?></p>
                        <?php
                        $objectListSQL = Object::getListByIdCultureAndIdObjectClassSQL($idCulture, $row['id_clobject']);
                        if ($objectListSQL) { ?>
                            <ul class="collection">
                                <?php
                                while ($rowObj = $objectListSQL->fetch()) { ?>
                                    <li class="collection-item">
                                        <a href="<?php echo PATH; ?>/object/object-<?php
                                            echo $rowObj['id_object']; ?>/culture-<?php
                                            echo $idCulture; ?>"><?php echo $rowObj['rnameobject'];?></a>
                                    </li>
                                    <?php
                                } ?>
                            </ul>
                            <?php
                        }
                    }
                }
                if ($objectListWithoutObjectClassSQL) { ?>
                    <p><?php echo $cultureName . '<i class="material-icons bread-i">chevron_right</i>Без группы'; ?></p>
                    <ul class="collection">
                        <?php
                        while ($rowObj = $objectListWithoutObjectClassSQL->fetch()) { ?>
                            <li class="collection-item">
                                <a href="<?php echo PATH; ?>/object/object-<?php echo $rowObj['id_object'];?>"><?php echo $rowObj['rnameobject'];?></a>
                            </li>
                            <?php
                        } ?>
                    </ul>
                    <?php
                } ?>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>