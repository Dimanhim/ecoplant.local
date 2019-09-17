<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Добавить связку: регистрация препарата на группу объектов</h5>
    </div>
    <div class="row">
        <h5>Таблица связки препарата и культуры</h5>
    </div>
    <div class="row">
        <?php

        if ($regDataListSQL) { ?>
    <table class="striped">
    <tr>
        <th>ID</th>
        <th>Название</th>
        <th>Мин. концентрация</th>
        <th>Макс. концентрация</th>
        <th>Условие</th>
    </tr>
    <?php
        while ($row = $regDataListSQL->fetch()) {
            echo '<tr>
                <td>' . $row["id_regdata"] . '</td>
                <td>' . $row["name_rus"] . '</td>
                <td>' . $row["min_rate"] . '</td>
                <td>' . $row["max_rate"] . '</td>
                <td>' . $row["description"] . '</td>
                </tr>';
        }
    } ?>
    </table>
    </div>
    <div class="row">
        <div class="col s12">
            <form method="post">
                <input type="hidden" name="idProduct" value="<?php echo $idProduct; ?>">
                <div class="row">
                    <div class="input-field col s12">
                        <select name="regdata">
                            <option value="" disabled selected>Выберите ID связки препарат и культура</option>
                            <?php
                            if ($regDataListSQL) {
                                $regDataListSQL->execute();

                                while ($row = $regDataListSQL->fetch()) {
                                    echo "<option value = " . $row["id_regdata"] . ">" . $row["id_regdata"] . "</option>";
                                }
                            } ?>
                        </select>
                        <label></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12">
                        <h5>Выберите группу объектов</h5>
                    </div>
                </div>
                <div class="row">
                    <?php
                    if ($objectGroupListSQL) {
                        $index = 1;
                        while ($row = $objectGroupListSQL->fetch()) { ?>
                            <div class="col s6">
                                <input class="object-group-checkbox" type="checkbox" id="<?php echo $index; ?>"
                                       name='grobject[]' value="<?php echo $row["id_grobject"]; ?>">
                                <label for="<?php echo $index; ?>"><?php echo $row["grobject_name_rus"]; ?></label>
                            </div>
                            <?php
                            $index++;
                        }
                    } ?>
                </div>
                <div class="row center"><a class="link3" href="<?php echo PATH; ?>/object/group/add">Добавить группу объектов</a></div>

                <div class="row">
                    <div class="col s12 center">
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit">Отправить даные</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>