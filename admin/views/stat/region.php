<?php include(ROOT . '/views/layout/header.php'); ?>

    <div class="row"><h5>Статистика сайта</h5></div>
    <div class="row">
        <div class="col s12">
            <?php include(ROOT . '/views/layout/stat_tabs.php'); ?>
        </div>
    </div>
    <div class="row">
        <div class="col s5 center-align">Количество посетителей по регионам</div>
        <div class="col s1"></div>
        <div class="col s6"></div>
        <div id="data" class="col s12">
            <div class="row">
                <div class="col s5">
                    <canvas id="myChartRegion"></canvas>
                </div>
                <div class="col s1"></div>
                <div class="col s6">
                    <ul class="collection">
                        <?php
                        for ($i = 0; $i < count($regionList) && $i < 10; $i++) { ?>
                            <li class="collection-item"><?php echo $regionList[$i]['region']; ?><span class="right"><?php echo $regionList[$i]['count']; ?></span></li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php
        if (count($regionList) > 10) { ?>
            <div class="col s12">Не вошедшие в 10 популярных регионов</div>
            <div class="col s12">
                <ul class="collection">
                    <?php
                    for ($i = 10; $i < count($regionList); $i++) { ?>
                        <li class="collection-item"><?php echo $regionList[$i]['region']; ?><span class="right"><?php echo $regionList[$i]['count']; ?></span></li>
                        <?php
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
        ?>
    </div>
    <script>
        var configCharRegion = {
            type: 'pie',
            data: {
                datasets: [{
                    data: [<?php
                        $dataCount = '';

                        for ($i = 0; $i < count($regionList) && $i < 10; $i++) {
                            $dataCount .= $regionList[$i]['count'] . ', ';
                        }

                        echo trim($dataCount, ', ');
                        ?>],
                    backgroundColor: [
                        '#e57373',
                        '#f06292',
                        '#ba68c8',
                        '#9575cd',
                        '#7986cb',
//                    '#64b5f6',
                        '#4fc3f7',
//                    '#4dd0e1',
                        '#4db6ac',
                        '#81c784',
                        '#aed581',
//                    '#dce775',
                        '#fff176'
                    ],
                    label: '10 наиболее популряных регионов посетителей'
                }],
                labels: [<?php
                    $dataName = '';

                    for ($i = 0; $i < count($regionList) && $i < 10; $i++) {
                        $dataName .= "'" . $regionList[$i]['region'] . '\', ';
                    }

                    echo trim($dataName, ', ');
                    ?>]
            },
            options: {
                responsive: true
            }
        };
    </script>

<?php include(ROOT . '/views/layout/footer.php'); ?>