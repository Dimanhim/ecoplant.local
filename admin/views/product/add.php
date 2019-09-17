<?php include (ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить препарат в БД</h5>
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
                    <div class="col s10">
                        <select name="manufacture">
                            <option value="" disabled selected>Выберите производителя</option>
                            <?php
                            if ($manufactureListSQL) {
                                while ($row = $manufactureListSQL->fetch()) {
                                    echo "<option value = " . $row["id_manufacture"] . ">" . $row["name_manufacture_rus"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col s2"><a href="<?php echo PATH; ?>/manufacture/add">Добавить производителя</a></div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <select name="ProductClass">
                            <option value="" disabled selected>Выберите тип препарата</option>
                            <?php
                            if ($productClassListSQL) {
                                while ($row = $productClassListSQL->fetch()) {
                                    echo "<option value = " . $row["id_clproduct"] . ">" . $row["name_clproduct_rus"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <input id="name_product_rus" type="text" name="name_product_rus" data-name-letter="id_letter">
                        <label for="name_product_rus">Название</label>
                    </div>
                </div>
                <div class="row letter-container">
                    <div class="col s12">
                        <input type="hidden" name="id_letter" value="<?php echo $idLetter; ?>">
                        <p>Выберите русскую букву алфавита</p>
                        <?php
                        if ($rusLetterListSQL) {
                            while ($row = $rusLetterListSQL->fetch()) {
                                if ($idLetter == $row["id_alphabet_rus"]) { ?>
                                    <a href="javascript:void();" class="chip letter-select select"
                                       data-id-letter="<?php echo $row["id_alphabet_rus"]; ?>"><?php echo $row["letter"]; ?></a>
                                    <?php
                                } else { ?>
                                    <a href="javascript:void();" class="chip letter-select"
                                       data-id-letter="<?php echo $row["id_alphabet_rus"]; ?>"><?php echo $row["letter"]; ?></a>
                                    <?php
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col s10">
                        <select name="solution">
                            <option value="" disabled selected>Выберите препаративную форму</option>
                            <?php
                            if ($solutionListSQL) {
                                while ($row = $solutionListSQL->fetch()) {
                                    echo "<option value = " . $row["id_product_solution"] . ">" . $row["short_name_product_solution"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col s2"><a href="<?php echo PATH; ?>/solution/add">Добавить препаративную форму</a></div>
                </div>
                <div class="row">
                    <div class="col s12"><h5>Упаковки</h5></div>
                    <div class="input-field col s11 taraList-container">
                        <select id="selectTara" name="tara_ids">
                            <?php
                            if ($packAndTaraListSQL) {
                                while ($row = $packAndTaraListSQL->fetch()) {
                                    echo "<option value = " . $row["id_product_tara"] . ">" . $row["pack_and_tara"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                        <label>Введите упаковку</label>
                    </div>
                    <div class="input-field col s1">
                        <button class="btn light-blue darken-2 tara-add-btn"><i class="material-icons">add</i></button>
                    </div>
                    <div class="col s12 taraList">
                        <div class="chip light-blue darken-2 white-text">Добавленные упаковки:</div>
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

<?php include (ROOT . '/views/layout/footer.php'); ?>