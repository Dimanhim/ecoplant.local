<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить журнал/сборник/книгу</h5>
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
                        <input id="name_collection" type="text" name="name_collection">
                        <label for="name_collection">Название журнала/сборника/книги</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name_collection_eng" type="text" name="name_collection_eng">
                        <label for="name_collection_eng">Название журнала/сборника/книги на английском языке</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name_publish_house" type="text" name="name_publish_house">
                        <label for="name_publish_house">Название издательства</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name_publish_house_eng" type="text" name="name_publish_house_eng">
                        <label for="name_publish_house_eng">Название издательства на английском языке</label>
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