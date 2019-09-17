<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"></div>
    <div class="row">
<?php include (ROOT . '/views/layout/leftmenu4pest.php'); ?>
    <div class="col s12 m9 content-row">
        <div class="row">
            <nav class="breadcrumb-nav">
                <div class="nav-wrapper">
                    <div class="col s12">
                        <a href="<?php echo PATH; ?>/" class="breadcrumb">Главная</a>
                        <a href="<?php echo PATH; ?>/fertiliser" class="breadcrumb">Удобрения</a>
                        <a href="javascript:void(0);" class="breadcrumb"><?php echo $manufacture['name_manufacture_rus']; ?></a>
                    </div>
                </div>
            </nav>
        </div>
        <h5 class="center"><?php
            if ($manufacture) {
                $manufacturelogo = $manufacture["file_manufacture_logo"];
                echo 'Удобрения компании ' . $manufacture["name_manufacture_rus"] . ' на ' . date("Y") . ' г.';
            }
            ?></h5>
        <div class="row"></div>
        <div class="row center">
            <?php
            $filePath = 'template/img/manufacture_logo/' . $manufacturelogo;
            if (file_exists($filePath)) {
                echo '<img style="max-width: 128px; max-height: 128px;" src=' . PATH . '/' . $filePath . '>';
            }
            ?>
        </div>
        <div class="row title"><p>Список удобрений:</p></div>
        <div class="row">
            <?php
                if ($fertiliserList) { ?>
                    <table>
                        <tr>
                            <th>Название</th>
                        </tr>
                    <?php
                        while ($row = $fertiliserList->fetch()) { ?>
                            <tr>
                                <td><a href="<?php echo PATH; ?>/fertiliser/id-<?php echo $row['id_fertiliser']; ?>"><?php echo $row['name_fertiliser']; ?></a></td>
                            </tr>
                            <?php
                        } ?>
                    </table>
                    <?php
                } ?>

        </div>
    </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>