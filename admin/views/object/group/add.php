<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить группу объектов</h5>
    </div>
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
    <div class="row">
        <div class="col s12">
            <form method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <input id="rnamegrobject" type="text" name="rnamegrobject" value="">
                        <label for="rnamegrobject">Русское название</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="engnamegrobject" type="text" name="engnamegrobject" value="">
                        <label for="engnamegrobject">Английское название</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <select name="clproduct">
                            <option value="" disabled selected>Выберите Класс продукта для объекта</option>
                            <?php
                            if ($productClassListSQL) {
                                while ($row = $productClassListSQL->fetch()) {
                                    echo "<option value = " . $row["id_clproduct"] . ">" . $row["name_clproduct_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12"><h5>Объекты</h5></div>
                    <div class="input-field col s11">
                        <select id="selectObject">
                            <?php
                            if ($objectListSQL) {
                                while ($row = $objectListSQL->fetch()) {
                                    echo "<option value = " . $row["id_object"] . ">" . $row["rnameobject"] . "</option>";
                                }
                            } ?>
                        </select>
                    </div>
                    <div class="input-field col s1">
                        <button class="btn light-blue darken-2 object-add-btn"><i class="material-icons">add</i></button>
                    </div>
                    <div class="col s12 objectList">
                        <div class="chip light-blue darken-2 white-text">Добавленные объекты:</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center">
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit"><i class="material-icons right">add</i>Добавить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>