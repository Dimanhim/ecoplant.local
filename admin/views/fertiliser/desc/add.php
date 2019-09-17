<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить описание удобрения</h5>
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
                        <select name="idFertiliser">
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
                    <div class="input-field col s12">
                        <textarea id="desc" class="materialize-textarea" name="desc"><?php echo $desc; ?></textarea>
                        <label for="desc">Текст описания</label>
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