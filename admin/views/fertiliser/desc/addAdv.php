<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить описание преимуществ удобрения</h5>
    </div>
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
} ?>
    <div class="row">
        <div class="col s12">
            <form method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <select name="idFertiliserAdv">
                            <?php
                            if ($fertiliserList) {
                                while ($row = $fertiliserList->fetch()) { ?>
                                    <option value="<?php echo $row['id_fertiliser']; ?>"<?php
                                    if ($idFertiliser == $row['id_fertiliser'])
                                        echo ' selected';
                                    ?>><?php echo $row['name_fertiliser']; ?></option>
                                    <?php
                                }
                            } ?>
                        </select>
                        <label>Выберите удобрение</label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12"><h5>Введите текст преимущества</h5></div>
                    <div class="input-field col s11">
                        <input type="text" name="descAdv">
                    </div>
                    <div class="input-field col s1">
                        <button class="btn light-blue darken-2 descAdv-add-btn"><i class="material-icons">add</i></button>
                    </div>
                    <div class="col s12 descAdvList">
                        <div class="chip light-blue darken-2 white-text">Добавленные преимущества:</div>
                        <?php
                        if ($descAdvArr) {
                            for ($i = 0; $i < count($descAdvArr); $i++) { ?>
                                <div class="chip">
                                    <input type="hidden" name="descAdv[]"
                                           value="<?php echo $descAdvArr[$i]; ?>"><?php echo $descAdvArr[$i]; ?>
                                    <i class="close material-icons">close</i>
                                </div>
                                <?php
                            }
                        } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center">
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="actionAdd">
                            <i class="material-icons right">add</i>Добавить
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>