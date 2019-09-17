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
                            <a href="<?php echo PATH; ?>/fertiliser/id-manufacture-<?php echo $fertiliser['id_manufacture']; ?>" class="breadcrumb"><?php echo $fertiliser['name_manufacture_rus']; ?></a>
                            <a href="javascript:void(0);" class="breadcrumb">Удобрение</a>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="row">
                <h5 class="center"><?php echo $fertiliser['name_fertiliser']; ?></h5>
            </div>
            <div class="row">
                <?php
                // Установление соединения с таблицой Производитель. Вывод названия и логотипа Производителя .
                if ($manufacture) {
                    $rnamemanufacture = $manufacture["name_manufacture_rus"];
                    $manufacturelogo = $manufacture["file_manufacture_logo"];
                } ?>
                <ul class="collection">
                    <li class="collection-item">
                        <div class="row margin-none">
                            <div class="col s9">Производитель: <?php echo $rnamemanufacture; ?></div>
                            <div class="col s3"><?php
                                $filePath = 'template/img/manufacture_logo/' . $manufacturelogo;
                                if (file_exists($filePath)) {
                                    $size = getimagesize($filePath);
                                    echo '<img class="right" style="max-width: 68px; max-height: 68px;" src=' . PATH . '/' . $filePath . '>';
                                } ?></div>
                        </div></li>
                </ul>
            </div>
            <div class="row title">
                <p>Содержание элементов</p>
            </div>
            <div class="row">
                <table class="striped">
                    <tr>
                        <th>Элемент</th>
                        <th>Содержание, %</th>
                    </tr>
                    <?php
                        if ($fertiliserElementList) {
                            while ($row = $fertiliserElementList->fetch()) { ?>
                                <tr>
                                    <td><?php echo $row['name_rus']; ?></td>
                                    <td><?php echo $row['concentration']; ?></td>
                                </tr>
                                <?php
                            }
                        } ?>
                </table>
            </div>
            <div class="row title">
                <p>Описание удобрения</p>
            </div>
            <div class="row">
                <p><?php echo $fertiliser['description']; ?></p>
            </div>
            <div class="row title">
                <p>Преимущества удобрения</p>
            </div>
            <div class="row">
                <?php
                    if ($fertiliserDescAdv) { ?>
                        <ul class="collection">
                        <?php
                        while ($row = $fertiliserDescAdv->fetch()) { ?>
                            <li class="collection-item"><?php echo $row['desc_advantage']; ?></li>
                            <?php
                        } ?>
                        </ul>
                        <?php
                    } ?>
            </div>

            <?php
                if ($fertiliserRegDataList) { ?>
                <div class="row title"><p>Регламенты применения</p></div>
                <div class="row">
                    <table class="striped">
                        <tr>
                            <th class="center">Культура</th>
                            <th class="center">Мин.</th>
                            <th class="center">Макс.</th>
                            <th class="center">Описание регламента</th>
                        </tr>
                <?php
                    while ($row = $fertiliserRegDataList->fetch()) { ?>
                        <tr>
                            <td class="center"><?php echo $row["culture"]; ?></td>
                            <td class="center"><?php echo $row["min_rate"]; ?></td>
                            <td class="center"><?php echo $row["max_rate"]; ?></td>
                            <td class="center"><?php echo $row["description"]; ?></td>
                        </tr>
                        <?php
                    } ?>
                    </table>
                </div>
                <?php
            } ?>

            <?php if (isset($fertiliser["condition"]) || isset($fertiliser["color"])) { ?>
                <div class="row title"><p>Другая информация:</p></div>
                <div class="row">
                    <ul class="collection">
                        <li class="collection-item">
                            <?php if (isset($fertiliser["condition"])) { ?>
                                <div class="row info">
                                    <div class="col s6">Внешний вид:</div>
                                    <div class="col s6"><?php echo $fertiliser["condition"]; ?></div>
                                </div>
                                <?php
                            } ?>
                            <?php if (isset($fertiliser["color"])) { ?>
                                <div class="row info">
                                    <div class="col s6">Цвет:</div>
                                    <div class="col s6"><?php echo $fertiliser["color"]; ?></div>
                                </div>
                                <?php
                            } ?>
                        </li>
                    </ul>
                </div>
            <?php
            } ?>

            <div class="row title"><p>Упаковка:</p></div>
            <div class="row">
                <ul class="collection">
                    <li class="collection-item">
                      <?php if ($fertiliserPackAndTara) {
                        while ($row = $fertiliserPackAndTara->fetch()) { ?>
                          <div class="row info">
                            <div class="col s12"><?php echo $row["pack_and_tara"]; ?></div>
                          </div>
                          <?php
                        }
                      } ?>
                    </li>
                </ul>
            </div>
        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>