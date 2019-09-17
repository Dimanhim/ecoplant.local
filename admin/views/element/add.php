<?php include (ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Проверка наличия в базе данных</h5>
    </div>
    <div class="row">
        <div class="input-field col s12">
            <select name="element_0">
                <?php
                if ($elementList) {
                    while ($row = $elementList->fetch()) {
                        echo "<option value = " . $row["id_element"] . ">" . $row["name_rus"] . " (" . $row["chemformulation"] . ")</option>";
                    }
                }
                ?>
            </select>
            <label>Проверьте имеется ли элемент в базе данных</label>
        </div>
    </div>
    <div class="row"></div>
    <div class="row">
        <h5>Добавить элемент</h5>
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
                        <input id="name" name="name" placeholder="Название элемента" type="text" class="validate" value="<?php echo $name; ?>">
                        <label for="name">Название элемента</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="chemformulation" name="chemformulation" placeholder="Химическая формула" type="text" class="validate" value="<?php echo $chemFormula; ?>">
                        <label for="chemformulation">Химическая формула</label>
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

<?php include (ROOT . '/views/layout/footer.php'); ?>