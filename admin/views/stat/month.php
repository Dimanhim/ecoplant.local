<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"><h5>Статистика сайта</h5></div>
    <div class="row">
        <div class="col s12">
            <?php include(ROOT . '/views/layout/stat_tabs.php'); ?>
        </div>
    </div>
    <div class="row">
        <div id="data" class="col s12">
            <div class="row" style="height: 500px;">
                <canvas id="myChartMonth"></canvas>
            </div>
        </div>
    </div>
    <script>
        var dataMonthUsers = [<?php
            $maxDays = date('t');

            if ($statUserListSQL) {
                $statUser = $statUserListSQL->fetch();
                $statData = '';

                for ($i = 1; $i <= $maxDays; $i++) {
                    $statData .= $statUser['d' . $i] . ', ';
                }

                echo trim($statData, ', ');
            }
            ?>];
        var dataMonthViews = [<?php
            if ($statViewListSQL) {
                $statView = $statViewListSQL->fetch();
                $statData = '';

                for ($i = 1; $i <= $maxDays; $i++) {
                    $statData .= $statView['d' . $i] . ', ';
                }

                echo trim($statData, ', ');
            }
            ?>];
    </script>

<?php include(ROOT . '/views/layout/footer.php'); ?>