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
                <canvas id="myChartYear"></canvas>
            </div>
        </div>
    </div>
    <script>
        var dataYearUsers = [<?php
            if ($statUserListSQL) {
                $statToday = $statUserListSQL->fetch();
                $statData = '';

                for ($i = 1; $i <= 12; $i++) {
                    $statData .= $statToday['m' . $i] . ', ';
                }

                echo trim($statData, ', ');
            } ?>];
        var dataYearViews = [<?php
            if ($statViewListSQL) {
                $statToday = $statViewListSQL->fetch();
                $statData = '';

                for ($i = 1; $i <= 12; $i++) {
                    $statData .= $statToday['m' . $i] . ', ';
                }

                echo trim($statData, ', ');
            } ?>];
    </script>

<?php include(ROOT . '/views/layout/footer.php'); ?>