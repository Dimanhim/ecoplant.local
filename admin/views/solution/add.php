<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <div class="col s12"><h5>Добавить препаративную форму в БД</h5></div>
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
                        <input id="name_product_solution" type="text" name="name_product_solution" value="<?php echo $name; ?>">
                        <label for="name_product_solution">Название препаративной формы</label>
                    </div>
                    <div class="input-field col s12">
                        <input id="short_name_product_solution" type="text" name="short_name_product_solution" value="<?php echo $shortName; ?>">
                        <label for="short_name_product_solution">Сокращение</label>
                    </div>
                    <div class="input-field col s12">
                        <input type="hidden" name="action" value="action">
                        <button class="waves-effect waves-light btn light-blue darken-2 right" type="submit"><i class="material-icons right">add</i>Добавить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col s12">
            <ul class="collection with-header">
                <li class="collection-header"><h5>Препаративные формы в базе данных</h5></li>
                <?php
                if ($solutionListSQL) {
                    while ($row = $solutionListSQL->fetch()) {
                        echo '<li class="collection-item">' . $row["short_name_product_solution"] .
                            '<i class="material-icons delete-button delete-button-form" data-id="' . $row["id_product_solution"] . '">delete</i></li>';
                    }
                }
                ?>
            </ul>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>