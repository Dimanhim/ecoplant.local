<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"></div>
    <div class="row">
        <div class="col s12 m12 content-row">
            <div class="row">
                <nav class="breadcrumb-nav">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="<?php echo PATH; ?>/" class="breadcrumb">Главная</a>
                            <a href="javascript:void(0);" class="breadcrumb">Вредные объекты</a>
                        </div>
                    </div>
                </nav>
            </div>
            <?php
            if ($species) { ?>
                <div class="row">
                    <div class="col s3" style="text-align: right;"><h5>Название:</h5></div>
                    <div class="col s9"><h5><?php echo $species['name_lat']; ?></h5></div>
                </div>
                <?php
            }

            ?>
            <div class="row">
                <div class="col s3" style="text-align: right;">Синонимы:</div>
                <?php
                if ($speciesSynonymList) {
                    $index = 0;
                    while ($row = $speciesSynonymList->fetch()) { ?>
                        <div class="col s9 <?php if ($index++ != 0) echo 'offset-s3'; ?>">
                            <a href="<?php echo PATH; ?>/species/id-species-<?php echo $row['id_species']; ?>">
                                <?php echo $row['name_lat']; ?>
                            </a>
                        </div>
                        <?php
                    }
                } else { ?>
                    <div class="col s9">Нет информации в базе данных</div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>