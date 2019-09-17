<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <div class="col s12">
            <h5>Добавить свидетельства</h5>
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
        </div>
    </div>
    <form method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="input-field col s12">
                <select id="select" name="product" class="id_product">
                    <?php
                    if ($productListSQL) {
                        while ($row = $productListSQL->fetch()) {
                            if ($row['id_product'] == $idProduct) { ?>
                                <option value="<?php echo $row['id_product']; ?>" selected><?php
                                    echo $row['name_product_rus'];
                                    ?></option>
                                <?php
                            } else { ?>
                                <option value="<?php echo $row['id_product']; ?>"><?php
                                    echo $row['name_product_rus'];
                                    ?></option>
                                <?php
                            } ?>
                            <?php
                        }
                    } ?>
                </select>
                <label>Выберите препарат</label>
            </div>
        </div>
        <div id="container_hidden_fields" class="row">
            <?php
            if (!$number) { ?>
                <div class="col s12 m6">
                    <div class="card grey darken-3">
                        <div class="card-content white-text">
                            <div class="row">
                                <div class="col s12">Номер свидетельства: <input type="text" name="number[]"/></div>
                                <div class="col s12">
                                    <div class="row">
                                        <div class="col s6">Дата окончания свидетельства</div>
                                        <div class="col s2">
                                            <input type="text" name="day[]" placeholder="День" size="4"/>
                                        </div>
                                        <div class="col s2">
                                            <select name="month[]">
                                                <option>1</option><option>2</option><option>3</option>
                                                <option>4</option><option>5</option><option>6</option>
                                                <option>7</option><option>8</option><option>9</option>
                                                <option>10</option><option>11</option><option>12</option>
                                            </select>
                                        </div>
                                        <div class="col s2">
                                            <select name="year[]">
                                                <option>2017</option><option>2013</option><option>2014</option>
                                                <option>2015</option><option>2016</option><option>2018</option>
                                                <option>2019</option><option>2020</option><option>2021</option>
                                                <option>2022</option><option>2023</option><option>2024</option>
                                                <option>2025</option><option>2026</option><option>2027</option>
                                                <option>2028</option><option>2029</option><option>2030</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12">Название файла: <input type="text" name="fileName[]" size="12"/>
                                    <input type="file" name="file[]"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            } else {
                for ($n = 0; $n < count($number); $n++) { ?>
                    <div class="col s12 m6">
                        <div class="card grey darken-3">
                            <div class="card-content white-text">
                                <div class="row">
                                    <div class="col s12">Номер свидетельства:
                                        <input type="text" name="number[]" value="<?php if (isset($number[$n])) echo $number[$n]; ?>">
                                    </div>
                                    <div class="col s12">
                                        <div class="row">
                                            <div class="col s6">Дата окончания свидетельства</div>
                                            <div class="col s2">
                                                <input type="text" name="day[]" placeholder="День" size="4" value="<?php if (isset($day[$n])) echo $day[$n]; ?>">
                                            </div>
                                            <div class="col s2">
                                                <select name="month[]">
                                                    <?php
                                                    for ($p = 1; $p <= 12; $p++) {
                                                        if ($month[$n] == $p) {
                                                            echo '<option value="' . $p . '" selected>' . $p . '</option>';
                                                        } else {
                                                            echo '<option value="' . $p . '">' . $p . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col s2">
                                                <select name="year[]">
                                                    <?php
                                                    for ($p = 2013; $p <= 2030; $p++) {
                                                        if ($year[$n] == $p) {
                                                            echo '<option value="' . $p . '" selected>' . $p . '</option>';
                                                        } else {
                                                            echo '<option value="' . $p . '">' . $p . '</option>';
                                                        }
                                                    } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col s12">Название файла:
                                        <input type="text" name="fileName[]" size="12" value="<?php if (isset($fileName[$n])) echo $fileName[$n]; ?>">
                                        <input type="file" name="file[]">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <a class="btn light-blue darken-2 addFieldsBtn">Добавить сведетельство</a>
        <div class="row">
            <div class="col s12 center">
                <button class="waves-effect waves-light btn light-blue darken-2 right" type="submit" name="action">
                    <i class="material-icons right">save</i>Сохранить
                </button>
            </div>
        </div>
    </form>

<?php include(ROOT . '/views/layout/footer.php'); ?>