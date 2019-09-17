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
                            <a href="javascript:void(0);" class="breadcrumb">По названию</a>
                        </div>
                    </div>
                </nav>
            </div>
            <?php
            while ($row = $firstLetterObjectListSQL->fetch()) { ?>
                <div class="row title"><p><a name="<?php echo $row['id_alphabet_rus'];?>"></a>Объекты на '<?php echo $row['letter'];?>'</p></div>
                <div class="row center">
                    <ul class="collection">
                        <?php
                        $objectList = Object::getListByIdAlphabetSQL($row['id_alphabet_rus']);
                        while ($rowObj = $objectList->fetch()) { ?>
                            <li class="collection-item"><a href="<?php echo PATH; ?>/object/object-<?php echo $rowObj['id_object']; ?>"><?php echo $rowObj['rnameobject']; ?></a></li>
                            <?php
                        } ?>
                    </ul>
                </div>
                <?php
            }
            ?>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>