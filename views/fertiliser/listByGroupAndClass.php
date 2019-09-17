<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"></div>
    <div class="row">
        <div class="col s12 content-row">
            <div class="row">
                <nav class="breadcrumb-nav">
                    <div class="nav-wrapper">
                        <div class="col s12">
                            <a href="<?php echo PATH; ?>/" class="breadcrumb">Главная</a>
                            <a href="<?php echo PATH; ?>/fertiliser" class="breadcrumb">Удобрения</a>
                            <a href="javascript:void(0);" class="breadcrumb">Список по группе и классу удобрения</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row title">
                <p>Список удобрений</p>
            </div>
            <div class="row">
                <p>Выбранная группа удобрений: <strong><?php echo $fertiliserGroup['name_grfertilizer_rus']; ?></strong></p>
                <p>Выбранный класс удобрений: <strong><?php echo $fertiliserClass['name_clfertilizer_rus']; ?></strong></p>
            </div>
            <?php if ($elementList) { ?>
                <div class="row title">
                  <p>Произвести фильтрацию по элементу:</p>
                </div>
                <div class="row">
                  <div class="col s1 filter-icon-wrap">
                    <img class="filter-icon" src="<?php echo PATH; ?>/template/img/filter-filled-tool-symbol.svg" alt="filter">
                  </div>
                  <div class="col s11">
                    <select name="id_element" id="element-select">
                      <?php
                      if (isset($idElement) && $idElement) { ?>
                        <option value="0">Сбросить выбор элемента</option>
                        <?php
                      } else { ?>
                        <option value="0">Выберите элемент содержащийся в удобрении</option>
                        <?php
                      } ?>
                      <?php

                      while ($row = $elementList->fetch()) { ?>
                        <option value="<?php echo $row['id_element']; ?>"<?php
                        if ($row['id_element'] == $idElement)
                          echo ' selected'; ?>><?php echo $row['name_rus']; ?> (<?php echo $row['chemformulation']; ?>)</option>
                        <?php
                      } ?>
                    </select>
                  </div>
                </div>
            <?php
            } ?>

            <?php
            if ($fertiliserList) { ?>
            <div class="row">
                <table class="striped">
                    <tr>
                        <th>Удобрение</th>
                        <th>Производитель</th>
                        <th><?php if (isset($idElement) && $idElement) {
                                echo "Содержание элемента ({$element['chemformulation']})";
                            } else {
                                echo 'Элементы';
                            } ?></th>
                    </tr>
                <?php
                while ($row = $fertiliserList->fetch()) { ?>
                    <tr>
                        <td><a href="<?php echo PATH; ?>/fertiliser/id-<?php echo $row['id_fertiliser']; ?>"><?php echo $row['name_fertiliser']; ?></a></td>
                        <td><?php echo $row['name_manufacture_rus']; ?></td>
                        <td><?php if (isset($idElement) && $idElement) {
                                echo $row['concentration'];
                            } else {
                                echo $row['elementList'];
                            } ?></td>
                    </tr>
                    <?php
                } ?>
            </table>
            <?php
            } else { ?>
                <div class="row">
                    <p>Данных по выбранным критериям нет</p>
                </div>
                <?php
            } ?>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>