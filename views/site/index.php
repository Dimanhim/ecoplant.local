<?php include (ROOT . '/views/layout/header.php'); ?>
    <div class="row"></div>
    <div class="row card-container">
        <div class="col s12 m6 l3">
            <div class="card card-hover blue-grey lighten-5" onclick="location.href='object';">
                <div class="card-content">
                    <span class="card-title">Вредные объекты</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="card card-hover blue-grey lighten-5" onclick="location.href='pesticide';">
                <div class="card-content">
                    <span class="card-title">Защита растений</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="card card-hover blue-grey lighten-5" onclick="location.href='fertiliser';">
                <div class="card-content">
                    <span class="card-title">Удобрения</span>
                </div>
            </div>
        </div>
        <div class="col s12 m6 l3">
            <div class="card blue-grey lighten-5">
                <div class="card-content">
                    <span class="card-title">Сорта и гибриды</span>
                </div>
            </div>
        </div>
    </div>
    <div class="row card-container">
        <div class="col s12 m4 l3">
            <div class="card blue-grey lighten-5">
                <div class="card-content">
                    <span class="card-title">База Данных содержит:</span>
                    <p class="title-name-product">Пестициды (<?php echo $productCount; ?>)</p>
                    <ul>
                        <li>протравители (<?php echo $productCountSeedTr;?>)</li>
                        <li>гербициды (<?php echo $productCountHerb;?>)</li>
                        <li>фунгициды (<?php echo $productCountFungic;?>)</li>
                        <li>инсектициды (<?php echo $productCountInsectic;?>)</li>
                        <li>акарициды (<?php echo $productCountAcaricid;?>)</li>
                        <li>регуляторы роста (<?php echo $productCountRegulator;?>)</li>
                    </ul>
                    <p class="title-name-product">Вредные объекты (<?php echo $objectCount; ?>)</p>
                    <ul>
                        <li>микопатогены (<?php echo $objectCountMycor;?>)</li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col s12 m8 l9">
            <div class="card blue-grey lighten-5">
                <div class="card-content">
                    <span class="card-title">Описание проекта EcoPlant Агро:</span>
                    <p>Описание последних добавлений</p>
                </div>
            </div>
        </div>
    </div>

<?php include (ROOT . '/views/layout/footer.php'); ?>