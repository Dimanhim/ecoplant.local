<?php

class ProductController {
    public function actionAdd() {

        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        $idLetter = false;
        $nameProductRus = false;
        $idClProduct = false;
        $idManufacture = false;
        $idProductSolution = false;
        $idLetter = false;

        if (isset($_POST['name_product_rus']) && isset($_POST['ProductClass']) &&
            isset($_POST['manufacture']) && isset($_POST['solution']) &&
            isset($_POST['id_letter'])) {

            $nameProductRus = $_POST['name_product_rus'];
            $idProductClass = $_POST['ProductClass'];
            $idManufacture = $_POST['manufacture'];
            $idTypePesticide = $_POST['PesticideClass'];
            $idProductSolution = $_POST['solution'];
            $idPackAndTaraList = $_POST['tara_ids'];
            $idLetter = $_POST['id_letter'];

            if (Product::add($idManufacture, $idProductClass, $nameProductRus, $idProductSolution, $idLetter, $idTypePesticide)) {
                $idProduct = Product::getId($idManufacture, $idProductClass, $nameProductRus, $idProductSolution, $idLetter, $idTypePesticide);

                if ($idProduct) {
                    for ($i = 0; $i < count($idPackAndTaraList); $i++) {
                        PackAndTara::addToProduct($idProduct, $idPackAndTaraList[$i]);
                    }

                    $_SESSION['idProduct'] = $idProduct;
                    $_SESSION['nameProductRus'] = $nameProductRus;
                    header('Location: ' . PATH . '/substance/addToProduct');
                    $success[] = 'Препарат "' . $nameProductRus . '" успешно добавлен.';
                } else {
                    $errors[] = 'Ошибка ввода данных. Напишите Администратору.';
                }
            } else {
                $errors[] = 'Ошибка ввода данных. Напишите Администратору.';
            }
        }

        $manufactureListSQL = Manufacture::getListSQL();
        $productClassListSQL = ProductClass::getListSQL();
        $pesticideListSQL = ProductClass::getListPesticideSQL();
        $rusLetterListSQL = Letter::getRusListSQL();
        $solutionListSQL = Solution::getListSQL();
        $packAndTaraListSQL = PackAndTara::getListSQL();

        require_once(ROOT . '/views/product/add.php');
        return true;
    }

    public function actionPrice() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRICE_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        $priceRubAdd = false;
        $priceUsdAdd = '0.00';
        $date = false;
        $idProduct = false;
        $idImporter = false;
        $actualityAdd = 1;
        $actualitySave = 1;

        // Добавление цены
        if (isset($_POST['actionAdd'])) {
            $idProduct = $_POST['idProductAdd'];
            $priceRubAdd = $_POST['price_rub'];
            if ($priceRubAdd == '')
                $errors[] = 'Не заполнено поле "Цена в рублях" при добавлении новой цены';

            $priceUsdAdd = $_POST['price_usd'];
            if ($priceUsdAdd == '')
                $errors[] = 'Не заполнено поле "Цена в долларах" при добавлении новой цены';

            if (isset($_POST['date']))
                $date = $_POST['date'];
            else
                $errors[] = 'Не заполнено поле "Дата" при добавлении новой цены';

            if (isset($_POST['idImporter']))
                $idImporter = $_POST['idImporter'];
            else
                $errors[] = 'Не заполнено поле "Импортер" при добавлении новой цены';

            if (isset($_POST['actualityAdd']))
                $actualityAdd = 1;
            else
                $actualityAdd = 0;

            if (!$errors) {
                if ($actualityAdd == 1) {
                    Product::setActualityAndPrice($idProduct, $idImporter);
                }

                $idDate = Date::getId($date);
                if (!$idDate) {
                    if (Date::add($date)) {
                        $idDate = Date::getId($date);
                    }
                }

                Product::addAndPrice($idProduct, $idImporter, $idDate, $actualityAdd, $priceRubAdd, $priceUsdAdd);

                $success[] = 'Цена успешно добавлена';
            }
        }

        // Сохранение цены
        if (isset($_POST['actionSave'])) {
            $idProduct = $_POST['idProductSave'];
            $idDate = $_POST['idDate'];

            $priceRubSave = $_POST['price_rub'];
            if ($priceRubSave == '')
                $errors[] = 'Не заполнено поле "Цена в рублях" при добавлении новой цены';

            $priceUsdSave = $_POST['price_usd'];
            if ($priceUsdSave == '')
                $errors[] = 'Не заполнено поле "Цена в долларах" при добавлении новой цены';

            if (isset($_POST['idImporter']))
                $idImporter = $_POST['idImporter'];
            else
                $errors[] = 'Не заполнено поле "Импортер" при добавлении новой цены';

            if (isset($_POST['actualitySave']))
                $actualitySave = 1;
            else
                $actualitySave = 0;

            if (!$errors) {
                if ($actualitySave == 1) {
                    Product::setActualityAndPrice($idProduct, $idImporter);
                }

                Product::updateAndPrice($idProduct, $idImporter, $idDate, $actualitySave, $priceRubSave, $priceUsdSave);
            }
        }

        $productListSQL = Product::getListSQL('name');
        $importerListSQL = Importer::getListSQL('name');

        require_once(ROOT . '/views/product/price.php');
        return true;
    }
    public function actionPriceDate() {
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRICE_FUNC, User::getId())) {
            die;
        }

        $dateArr = array();

        if (isset($_POST['idProduct'])) {
            $idProduct = $_POST['idProduct'];

            $dateListSQL = Date::getProductAndPriceListByIdProductSQL($idProduct);
            if ($dateListSQL) {
                $i = 0;
                while ($row = $dateListSQL->fetch()) {
                    $dateArr[$i]['id_date'] = $row['id_date'];
                    $dateArr[$i]['date'] = $row['date'];
                    $i++;
                }
            }
        }

        echo json_encode($dateArr);
        return true;
    }
    public function actionPriceInfo() {
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRICE_FUNC, User::getId())) {
            die;
        }

        $price = array();
        $price['price_rub'] = '';
        $price['price_usd'] = '';
        $price['id_importer'] = '';

        if (isset($_POST['idProduct']) && isset($_POST['idDate'])) {
            $idProduct = $_POST['idProduct'];
            $idDate = $_POST['idDate'];

            $productSQL = Product::getListAndPriceSQL($idProduct, $idDate);
            if ($productSQL) {
                $price = $productSQL->fetch();
            }
        }

        echo json_encode($price);
        return true;
    }
    
    public function actionAddAndCulture() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        if (isset($_POST['description']) && isset($_POST['min_rate']) &&
            isset($_POST['max_rate']) && isset($_POST['product']) &&
            isset($_POST['culture'])) {

            $description = $_POST['description'];
            $min_rate = $_POST['min_rate'];
            $max_rate = $_POST['max_rate'];

            $idProduct = $_POST['product'];
            $idCulture = $_POST['culture'];

            //$idCulture, $minPrim, $maxPrim, $desc, $waitingPeriod, $maxTimes, $date4people, $date4machine
            $idRegData = RegData::add($idCulture, $min_rate, $max_rate, $description);
            if ($idRegData) {
                if (Product::addAndRegData($idProduct, $idRegData)) {
                    header('Location: ' . PATH . '/substance/addToProductNext');
                } else {
                    $errors[] = 'Ошибка добавления данных в базу данных';
                }
            } else {
                $errors[] = 'Ошибка добавления данных в базу данных';
            }
        } else {
            $errors[] = 'Не все поля заполнены';
        }

        $productListSQL = Product::getListSQL('name');
        $cultureListSQL = Culture::getListSQL('name');

        require_once(ROOT . '/views/product/addAndCulture.php');
        return true;
    }

    public function actionAnalogSelect() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        if (isset($_POST['product'])) {
            $idProduct = $_POST['product'];

            header('Location: ' . PATH . '/product/analog/addAndCulture/' . $idProduct);
        }

        $productlistSQL = Product::getListSQL();
        require_once(ROOT . '/views/product/analog/select.php');
        return true;
    }
    public function actionAnalogAddAndCulture($idProduct) {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        if (isset($_POST['action'])) {
            if (isset($_POST['regdata']) && isset($_POST['product'])) {
                $idRegData = $_POST['regdata'];
                $idProductAnalog = $_POST['product'];

                if (Product::addAndRegData($idProductAnalog, $idRegData)) {
                    $success[] = 'Данные успешно добавлены';
                }
            } else {
                $errors[] = 'Не все данные заполнены';
            }
        }

        $regDataProductListSQL = RegData::getListByIdProductSQL($idProduct);
        $productListSQL = Product::getListSQL();

        require_once(ROOT . '/views/product/analog/addAndCulture.php');
        return true;
    }
}