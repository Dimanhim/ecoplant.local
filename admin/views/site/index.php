<?php include (ROOT . '/views/layout/header.php'); ?>

    <div class="row"><h5>Доступные функции</h5></div>
    <?php if (isset($_SESSION['accessDenied']) && $_SESSION['accessDenied']) {
        $_SESSION['accessDenied'] = false;
        unset($_SESSION['accessDenied']);
        ?>
        <blockquote class="error">У Вас нет доступа к запрашиваемой странице. <br>Пожалуйста, обратитесь к администратору.</blockquote>
        <?php
    } ?>
    <div class="row">
        <?php
        if (UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) { ?>
            <div class="col s12 m6">
                <div class="col s12"><h5>Препарат</h5></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/product/add">Добавить препарат</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/regdata/add">Добавить регистрацистрационные данные препарата</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/regdata/certification">Добавить свидетельства</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/biotarget/select">Добавить связку препарат и биотаргет</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/solution/add">Добавить препаративную форму</a></div>
            </div>
            <?php
        }

        if (UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) { ?>
            <div class="col s12 m6">
                <div class="col s12"><h5>Объект</h5></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/object/add">Добавить объект</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/object/group/add">Добавить группу объектов</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/object/image">Добавить фотографии объектов</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/object/desc">Редактирование описания объекта</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/species/add">Добавить вид</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/object/user-image">Пользовательские изображения<?php
                        if (isset($countUserObjectImage) && $countUserObjectImage) {
                            echo " <span class='red-text'>($countUserObjectImage)</span>";
                        } ?></a></div>
            </div>
            <?php
        }

        if (UserGroup::accessAdminBlockByIdUser(ACCESS_PRICE_FUNC, User::getId())) { ?>
            <div class="col s12 m6">
                <div class="col s12"><h5>Цены</h5></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/product/price">Внести (обновить) цены продуктов</a></div>
            </div>
            <?php
        }

        if (UserGroup::accessAdminBlockByIdUser(ACCESS_BIBLIO_FUNC, User::getId())) { ?>
            <div class="col s12 m6">
                <div class="col s12"><h5>Литература</h5></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/biblio/add">Добавить литературный источник</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/biblio/link/add">Добавить литературную ссылку</a></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/biblio/collection/add">Добавить журнал/сборник/книгу</a></div>
            </div>
            <?php
        }

        if (UserGroup::accessAdminBlockByIdUser(ACCESS_OTHER_FUNC, User::getId())) { ?>
            <div class="col s12 m6">
                <div class="col s12"><h5>Другое</h5></div>
                <div class="col s12"><a href="<?php echo PATH; ?>/manufacture/add">Добавить производителя</a></div>
            </div>
            <?php
        }

        if (UserGroup::accessAdminBlockByIdUser(ACCESS_FERTILISER, User::getId())) { ?>
        <div class="col s12 m6">
            <div class="col s12"><h5>Удобрения</h5></div>
            <div class="col s12"><a href="<?php echo PATH; ?>/fertiliser/add">Добавить удобрение</a></div>
            <div class="col s12"><a href="<?php echo PATH; ?>/element/add">Добавить элемент</a></div>
            <div class="col s12"><a href="<?php echo PATH; ?>/fertiliser/regdata/add">Добавить регистрационную информацию</a></div>
            <div class="col s12"><a href="<?php echo PATH; ?>/fertiliser/desc/add">Добавить описание удобрения</a></div>
            <div class="col s12"><a href="<?php echo PATH; ?>/fertiliser/descAdv/add">Добавить описание преимущества удобрения</a></div>
        </div>
        <?php
        }

        ?>
    </div>

<?php include (ROOT . '/views/layout/footer.php'); ?>