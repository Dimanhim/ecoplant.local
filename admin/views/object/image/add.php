<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Редактор фотографий объектов</h5>
        <input type="hidden" name="idObject" value="<?php
        if ($idObject)
            echo $idObject;
        else
            echo -1;
        ?>">
    </div>
    <div class="row">
        <div class="col s12">
            <form method="post" class="selectObjectForImage">
                <div class="row">
                    <div class="input-field col s12">
                        <select name="idObject" class="select-object-id">
                            <?php
                            if ($objectListSQL) {
                                while ($row = $objectListSQL->fetch()) {
                                    if ($idObject == $row["id_object"])
                                        echo "<option value = " . $row["id_object"] . " selected>" . $row["rnameobject"] . "</option>";
                                    else
                                        echo "<option value = " . $row["id_object"] . ">" . $row["rnameobject"] . "</option>";
                                }
                            } ?>
                        </select>
                        <label>Выберите объект</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center">
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit"><i class="material-icons right">chevron_right</i>Далее</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php
    if ($showPhotoList) { ?>

        <div class="row">
            <div class="col s12">
                <form method="post" name="upload">
                    <input type="hidden" name="countalready" value="<?php echo $countPhotos; ?>">
                    <div class="row photos-row">
                        <div class="col s12">
                            <h5>Фотографии</h5>
                            <?php
                            if ($objectPhotoListSQL) { ?>
                                <div class="slider">
                                    <div class="button-row">
                                        <?php
                                        if ($avatarIdListSQL) {
                                            while ($row = $avatarIdListSQL->fetch()) { ?>
                                                <input type="hidden" name="avatar-id[]" value="<?php echo $row['id']; ?>">
                                            <?php
                                            }
                                        } ?>
                                        <ul>
                                            <li><button class="btn blue publish">Опубликовать</button></li>
                                            <li><button class="btn blue select-avatar">Сделать главной для культуры</button></li>
                                            <li><button class="btn-floating blue delete-photo"><i class="material-icons">delete</i></button></li>
                                        </ul>
                                    </div>
                                    <ul class="slides">
                                        <?php
                                        while ($row = $objectPhotoListSQL->fetch()) {
                                            $tagList = '';
                                            $tagListSQL = Tag::getListByIdImageSQL($row['id']);
                                            if ($tagListSQL) {
                                                while ($tagRow = $tagListSQL->fetch()) {
                                                    $tagList .= $tagRow['text'] . ',';
                                                }
                                                $tagList = trim($tagList, ', ');
                                            } ?>
                                            <li>
                                                <img data-photo-id="<?php echo $row['id']; ?>"
                                                     data-photo-desc="<?php echo $row['desc']; ?>"
                                                     data-photo-tags="<?php echo $tagList; ?>"
                                                     data-culture-id="<?php echo $row['id_culture']; ?>"
                                                     data-show="<?php echo $row['show']; ?>"
                                                     src="<?php echo PATH; ?>/../template/img/object/<?php echo $row['filename']; ?>">
                                            </li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                                <p class="bold">Параметры фотографии</p>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <select name="culture" class="select-image-culture-id">
                                            <option value="0" selected disabled>Выберите культуру</option>
                                            <?php
                                                if ($cultureListSQL) {
                                                    while ($row = $cultureListSQL->fetch()) {
                                                        echo "<option value = " . $row["id_culture"] . ">" . $row["name_rus"] . "</option>";
                                                    }
                                                } ?>
                                        </select>
                                        <label></label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="desc" name="desc" type="text" class="validate">
                                        <label for="desc">Описание фотографии</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12"><h5>Теги</h5></div>
                                    <div class="input-field col s11 tagList-container">
                                        <select name="tag_ids">
                                            <?php
                                            if ($tagForSelectListSQL) {
                                                while ($row = $tagForSelectListSQL->fetch()) {
                                                    echo "<option value=''>" . $row["text"] . "</option>";
                                                }
                                            } ?>
                                        </select>
                                        <label>Введите тег</label>
                                    </div>
                                    <div class="input-field col s1">
                                        <button class="btn light-blue darken-2 tag-add-btn"><i class="material-icons">add</i></button>
                                    </div>
                                    <div class="col s12 tagList">
                                        <div class="chip light-blue darken-2 white-text">Добавленные теги:</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12 center">
                                        <button class="waves-effect waves-light btn light-blue darken-2 save-photo-param">Сохранить параметры</button>
                                    </div>
                                </div>
                                <?php
                            } else { ?>
                                <blockquote>Не добавлено ни одной фотографии</blockquote>
                                <?php
                            }
                            ?>

                        </div>
                        <?php
                        if ($countPhotos < $countMaxPhoto) { ?>
                            <div class="col s12">
                                <h5>Добавление новых фотографий</h5>
                                <div class="file-field input-field">
                                    <div class="btn blue">
                                        <span>Выбор фотографий</span>
                                        <input type="file" multiple class="photos" name="photo[]">
                                    </div>
                                    <div class="file-path-wrapper">
                                        <input class="file-path validate" type="text" placeholder="Загрузите одну или несколько фотографий">
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                    if ($countPhotos < $countMaxPhoto) { ?>
                        <div class="row">
                            <div class="col s12 center">
                                <button class="btn waves-effect waves-light blue" type="submit" name="action">Загрузить фотографии</button>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </form>
            </div>
        </div>

        <?php
    }

    include(ROOT . '/views/layout/footer.php'); ?>