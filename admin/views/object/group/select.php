<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row">
        <h5>Шаг 1. Выберите продукт</h5>
    </div>
    <div class="row">
        <blockquote>Выбран класс продукта <?php
            if ($nameProductClass) echo $nameProductClass; ?>. Продукты выбраны согласно данному классу.</blockquote>
    </div>
    <div class="row">
        <div class="col s12">
            <form action="<?php echo PATH . '/object/group/merge'?>" method="post">
                <div class="row">
                    <div class="input-field col s12">
                        <select name="idProduct">
                            <option value="" disabled selected>Выберите продукт</option>
                            <?php
                            if ($productListSQL) {
                                while ($row = $productListSQL->fetch()) {
                                    echo "<option value = " . $row["id_product"] . ">" . $row["name_product_rus"] . "</option>";
                                }
                            } ?>
                        </select>
                        <label></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 center">
                        <button class="waves-effect waves-light btn light-blue darken-2" type="submit">Перейти</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>