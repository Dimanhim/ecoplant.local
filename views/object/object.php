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
            if (isset($success) && is_array($success)) {
                for ($i = 0; $i < count($success); $i++) { ?>
                    <blockquote><?php echo $success[$i]; ?></blockquote>
                    <?php
                }
            }
            if ($object) { ?>
                <div class="row">
                    <div class="col s3" style="text-align: right;"><h5>Название:</h5></div>
                    <div class="col s9"><h5><?php echo $object['rnameobject']; ?></h5></div>
                    <?php
                    if ($object['engnameobject']) { ?>
                        <div class="col s9 offset-s3"><?php echo $object['engnameobject'];?></div>
                        <?php
                    }
                    ?>
                </div>
                <div class="row">
                    <div class="col s3" style="text-align: right;">Виды:</div>
                    <?php
                    if ($speciesListSQL) {
                        $index = 0;
                        while ($row = $speciesListSQL->fetch()) { ?>
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

                <?php
                $cultureText = '';
                $cultureTextSelected = '';
                if ($cultureListSQL) {
                    $index = 0;
                    while ($row = $cultureListSQL->fetch()) {
                        if ($row['id_culture'] == $idCulture) {
                            $cultureTextSelected .= '<div class="row">';
                            $cultureTextSelected .= '<div class="col s3" style="text-align: right;">Выбранная поражаемая культура:</div>';
                            $cultureTextSelected .= '<div class="col s9">';
                            $cultureTextSelected .= '<a href="' . PATH . '/object/id-culture-' . $row['id_culture'] . '">
                                    ' . $row['name_rus'] . '</a></div>';
                            $cultureTextSelected .= '</div>';
                        } else {
                            $cultureText .= '<div class="col s9 ';
                            if ($index++ != 0) $cultureText .= 'offset-s3';
                            $cultureText .= '">';
                            $cultureText .= '<a href="' . PATH . '/object/id-culture-' . $row['id_culture'] . '">
                                    ' . $row['name_rus'] . '</a></div>';
                        }
                    }
                } ?>
                <?php if ($cultureTextSelected) {
                    echo $cultureTextSelected;
                } ?>
                <div class="row">
                    <div class="col s3" style="text-align: right;">Поражаемые культуры:</div>
                    <?php echo $cultureText; ?>
                </div>
                <?php

                $avatarId = false;
                $avatarFileName = false;
                $avatarDesc = false;

                if ($objectPhotoAvatar) {
                    $avatarId = $objectPhotoAvatar['id'];
                    $avatarFileName = $objectPhotoAvatar['filename'];
                    $avatarDesc = $objectPhotoAvatar['desc'];
                }

                ?>
                <div id="modalImage" class="modal">
                    <div class="modal-content">
                        <img src="" alt="">
                        <p></p>
                    </div>
                </div>
                <div class="row">
                    <?php
                    if ($avatarId && $objectPhotoListSQL && $idCulture != 0) { ?>
                        <div class="col s4 avatar-photo"><a class="avatar-photo-link" href="#modalImage" data-desc="<?php echo $avatarDesc; ?>"><img src="<?php echo PATH; ?>/template/img/object/<?php echo $avatarFileName; ?>" alt=""></a></div>
                        <div class="col s8">
                            <div class="carousel">
                                <?php
                                while ($row = $objectPhotoListSQL->fetch()) { ?>
                                    <a class="carousel-item" href="#modalImage" data-desc="<?php echo $row['desc']; ?>"><img src="<?php echo PATH; ?>/template/img/object/<?php echo $row['filename']; ?>"></a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <?php

                    } else if ($avatarId && $idCulture != 0) { ?>
                        <div class="col s12 avatar-photo" style="max-height: 250px; display: flex;">
                            <a class="avatar-photo-link" href="#modalImage" data-desc="<?php echo $avatarDesc; ?>" style="margin: auto; width: auto;">
                                <img src="img/object/<?php echo $avatarFileName; ?>" alt="" style="width: auto; height: 100%;">
                            </a>
                        </div>
                        <?php
                    } else if ($objectPhotoListSQL) { ?>
                        <div class="col s12">
                            <div class="carousel">
                                <?php
                                while ($row = $objectPhotoListSQL->fetch()) { ?>
                                    <a class="carousel-item" href="#modalImage" data-desc="<?php echo $row['desc']; ?>"><img src="<?php echo PATH; ?>/template/img/object/<?php echo $row['filename']; ?>"></a>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="row add-image-object center">
                    <a href="#addImageObject" class="add-image-object-button waves-effect waves-light btn green">
                        <i class="material-icons right">add</i>Добавить фотографию
                    </a>
                </div>
                <div id="addImageObject" class="modal">
                    <?php
                    if (isset($errors) && is_array($errors)) {
                        $showModalAddImageObject = true;
                        ?>
                        <div class="col s12">
                            <?php
                            for ($i = 0; $i < count($errors); $i++) { ?>
                                <blockquote class="error"><?php echo $errors[$i]; ?></blockquote>
                                <?php
                            } ?>
                        </div>
                        <?php
                    } ?>
                    <div class="modal-content">
                        <form method="post" enctype="multipart/form-data">
                            <input type="hidden" name="MAX_FILE_SIZE" value="5242880" />
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="name" name="name"
                                           placeholder="Ваше имя (будет отображено на изображении)" type="text"
                                           class="validate" value="<?php echo $name; ?>">
                                    <label for="name">Ваше имя</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field col s12">
                                    <input id="email" name="email" placeholder="Ваш Email" type="text"
                                           class="validate" value="<?php echo $email; ?>">
                                    <label for="email">Ваш Email (необязательно)</label>
                                </div>
                            </div>
                            <div class="file-field input-field">
                                <div class="btn green">
                                    <span>Выбрать файл</span>
                                    <input type="file" name="photo">
                                </div>
                                <div class="file-path-wrapper">
                                    <input class="file-path validate" type="text" name="filename">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col s12 center">
                                    <button class="waves-effect waves-light btn green" type="submit" name="actionAddImageObject">
                                        <i class="material-icons right">add</i>Добавить
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <?php

                if ($objectDescBiology) { ?>
                    <div class="row">
                        <div class="col s3" style="text-align: right;">Биология объекта:</div>
                        <div class="col s9">
                            <?php
                            while ($row = $objectDescBiology->fetch()) {
                                echo '<p>' . $row['text_rus'] . '</p>';
                                if (isset($row['name_link']) && isset($row['biblio_file_name'])) { ?>
                                    <p><i><a href="<?php echo PATH; ?>/admin/template/files/<?php echo $row['biblio_file_name']; ?>"><?php echo $row['name_link']; ?><i class="material-icons file-icon">insert_drive_file</i></a></i></p>
                                    <?php
                                } else if (isset($row['name_link'])) { ?>
                                    <p><i><?php echo $row['name_link']; ?></i></p>
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>
                    <?php
                }

                if ($objectDescDevelop) { ?>
                    <div class="row">
                        <div class="col s3" style="text-align: right;">Развитие поражения</div>
                        <div class="col s9">
                            <?php
                            while ($row = $objectDescDevelop->fetch()) {
                                echo '<p>' . $row['text_rus'] . '</p>';
                                if (isset($row['name_link']) && isset($row['biblio_file_name'])) { ?>
                                    <p><i><a href="<?php echo PATH; ?>/admin/template/files/<?php echo $row['biblio_file_name']; ?>"><?php echo $row['name_link']; ?><i class="material-icons file-icon">insert_drive_file</i></a></i></p>
                                    <?php
                                } else if (isset($row['name_link'])) { ?>
                                    <p><i><?php echo $row['name_link']; ?></i></p>
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>
                    <?php
                }

                if ($objectDescSignif) { ?>
                    <div class="row">
                        <div class="col s3" style="text-align: right;">Вредоносность:</div>
                        <div class="col s9">
                            <?php
                            while ($row = $objectDescSignif->fetch()) {
                                echo '<p>' . $row['text_rus'] . '</p>';
                                if (isset($row['name_link']) && isset($row['biblio_file_name'])) { ?>
                                    <p><i><a href="<?php echo PATH; ?>/admin/template/files/<?php echo $row['biblio_file_name']; ?>"><?php echo $row['name_link']; ?><i class="material-icons file-icon">insert_drive_file</i></a></i></p>
                                    <?php
                                } else if (isset($row['name_link'])) { ?>
                                    <p><i><?php echo $row['name_link']; ?></i></p>
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>
                    <?php
                }

                if ($objectDescSymptoms) { ?>
                    <div class="row">
                        <div class="col s3" style="text-align: right;">Симптомы поражения растений:</div>
                        <div class="col s9">
                            <?php
                            while ($row = $objectDescSymptoms->fetch()) {
                                echo '<p>' . $row['text_rus'] . '</p>';
                                if (isset($row['name_link']) && isset($row['biblio_file_name'])) { ?>
                                    <p><i><a href="<?php echo PATH; ?>/admin/template/files/<?php echo $row['biblio_file_name']; ?>"><?php echo $row['name_link']; ?><i class="material-icons file-icon">insert_drive_file</i></a></i></p>
                                    <?php
                                } else if (isset($row['name_link'])) { ?>
                                    <p><i><?php echo $row['name_link']; ?></i></p>
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>
                    <?php
                }

                if ($idCulture != 0) {
                    $productBiotarget = Product::getListContainBiotarget($idObject, $idCulture);
                    if ($productBiotarget) { ?>
                        <div class="row col s12"><p>Таблица - Таблица эффективности препаратов:</p></div>
                        <div class="row">
                            <table class="striped">
                                <tr>
                                    <th>Культура</th>
                                    <th>Препарат<?php //echo $name_table; ?></th>
                                    <th>Доза</th>
                                    <th>Эф., %</th>
                                    <th>Литература</th>
                                </tr>
                                <?php
                                while ($row = $productBiotarget->fetch()) { ?>
                                    <tr>
                                        <td><?php echo $row["name_rus"]; ?></td>
                                        <td><?php echo $row["name_product_rus"]; ?></td>
                                        <td><?php echo $row["rate"]; ?></td>
                                        <td><?php echo $row["efficacy"]; ?></td>
                                        <td><?php echo $row["name_link"]; ?></td>
                                    </tr>
                                    <?php
                                } ?>
                            </table>
                        </div>
                        <?php
                    }
                } else {
                    $cultureBiotarget = Culture::getListContainBiotarget($idObject);
                    if ($cultureBiotarget) { ?>
                        <div class="row col s12"><p>Таблица - Таблица эффективности препаратов:</p></div>
                        <div class="row">
                        <table class="striped">
                        <tr>
                            <th>Культура</th>
                            <th>Препарат<?php //echo $name_table; ?></th>
                            <th>Доза</th>
                            <th>Эф., %</th>
                            <th>Литература</th>
                        </tr>
                        <?php
                        while ($row = $cultureBiotarget->fetch()) {
                            $productBiotarget = Product::getListContainBiotarget($idObject, $row['id_culture']);
                            if ($productBiotarget) {
                                while ($row = $productBiotarget->fetch()) { ?>
                                    <tr>
                                        <td><?php echo $row["name_rus"]; ?></td>
                                        <td><?php echo $row["name_product_rus"]; ?></td>
                                        <td><?php echo $row["rate"]; ?></td>
                                        <td><?php echo $row["efficacy"]; ?></td>
                                        <td><?php echo $row["name_link"]; ?></td>
                                    </tr>
                                    <?php
                                }
                            }
                        } ?>
                        </table>
                        </div>
                        <?php
                    }
                }

                if ($productListSQL) { ?>
                    <div class="row col s12">Таблица - Препараты зарегистрированные в РФ на данный объект</div>
                    <table class="striped">
                    <tr>
                        <th>Препарат</th>
                        <th>Производитель</th>
                        <th colspan="2">Норма расхода препарата</th>
                    </tr>
                    <tr>
                        <th colspan="2"></th>
                        <th>мин.</th>
                        <th>макс.</th>
                    </tr>
                    <?php
                    while ($row = $productListSQL->fetch()) { ?>
                        <tr>
                            <td>
                                <a href="<?php echo PATH; ?>/pesticide/full-info/id-product-<?php echo $row['id_product']; ?>">
                                    <?php echo $row['name_product_rus']; ?>
                                </a>
                            </td>
                            <td>
                                <?php echo $row['name_manufacture_rus']; ?>
                            </td>
                            <td><?php echo $row['min_rate']; ?></td>
                            <td><?php echo $row['max_rate']; ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    </table><?php
                }
            }
            ?>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>