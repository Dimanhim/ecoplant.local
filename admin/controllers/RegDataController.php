<?php

class RegDataController
{
    public function actionGetAndObjectGroup() {

        if (isset($_POST['idRegData'])) {
            $idRegData = $_POST['idRegData'];

            $regDataAndObjectGroupSQL = RegData::getAndObjectGroup($idRegData);

            $regDataAndObjectGroup = array();
            while ($row = $regDataAndObjectGroupSQL->fetch()) {
                $regDataAndObjectGroup[] = $row['id_grobject'];
            }

            echo json_encode($regDataAndObjectGroup);
        }

        return true;
    }
    
    public function actionAdd() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        $idProduct = false;
        $idCultureList = false;
        $idObjectList = false;
        $min_prim = false;
        $max_prim = false;
        $desc = false;
        $waitingPeriod = false;
        $date4people = false;
        $date4machine = false;
        $maxTimes = false;

        $fileName = false;
        $number = false;
        $day = false;
        $month = false;
        $year = false;

        if (isset($_POST['action'])) {
            // ID выбранного препарата
            if (!isset($_POST['product']) || $_POST['product'] == '') {
                $errors[] = 'Препарат не был выбран';
            } else {
                $idProduct = $_POST['product'];
            }

            if (!isset($_POST['product-autocomplete']) || $_POST['product-autocomplete'] == '') {
                $errors[] = 'Препарат не был выбран';
            }

            // ID выбранных культур
            if (!isset($_POST['selectCulture']) || !is_array($_POST['selectCulture']) || count($_POST['selectCulture']) == 0) {
                $errors[] = 'Не одна культура не была выбрана';
            } else {
                $idCultureList = $_POST['selectCulture'];
            }

            // ID выбранных вредных объектов
            if (isset($_POST['selectObject']) && is_array($_POST['selectObject'])) {
                $idObjectList = $_POST['selectObject'];
            }

            // Нормы примененеия
            if (!isset($_POST['min_prim']) || $_POST['min_prim'] == ''||
                !isset($_POST['max_prim']) || $_POST['max_prim'] == '') {
                $errors[] = 'Блок "Нормы применения препарата" не был заполнен';
            } else {
                $min_prim = $_POST['min_prim'];
                $max_prim = $_POST['max_prim'];
            }

            // Способ, время, особенности пременения
            if (!isset($_POST['description']) || $_POST['description'] == '') {
                $errors[] = 'Блок "Способ, время, особенности пременения" не был заполнен';
            } else {
                $desc = $_POST['description'];
            }

            // Сроки ожидания
            if (!isset($_POST['waiting_period']) || $_POST['waiting_period'] == '') {
                $errors[] = 'Блок "Сроки ожидания" не был заполнен';
            } else {
                $waitingPeriod = $_POST['waiting_period'];
            }

            // Сроки выхода для
            $date4error = false;
            if (!isset($_POST['date4machine']) || $_POST['date4machine'] == '') {
                $date4error = true;
            } else {
                $date4machine = $_POST['date4machine'];
            }
            if (!isset($_POST['date4people']) || $_POST['date4people'] == '') {
                $date4error = true;
            } else {
                $date4 = true;
                $date4people = $_POST['date4people'];
            }
            if ($date4error) {
                $errors[] = 'Блок "Сроки выхода для" не был заполен';
            }

            // Кратность обработок
            if (!isset($_POST['maxtimes']) || $_POST['maxtimes'] == '') {
                $errors[] = 'Блок "Кратность обработок" не был заполен';
            } else {
                $maxTimes = $_POST['maxtimes'];
            }

            // Дополнительные поля
            if (isset($_POST['fileName']) && isset($_POST['number']) &&
                isset($_POST['day']) && isset($_POST['month']) &&
                isset($_POST['year'])) {
                $fileName = $_POST['fileName'];
                if (is_array($fileName)) {
                    foreach ($fileName as $fileNameRow) {
                        if (trim($fileNameRow) == '') {
                            $errors[] = 'Не все поля "Название файла" были заполнены в дополнительных полях';
                            break;
                        }
                    }
                }
                $number = $_POST['number'];
                if (is_array($number)) {
                    foreach ($number as $numberRow) {
                        if (trim($numberRow) == '') {
                            $errors[] = 'Не все поля "Номер свидетельства" были заполнены в дополнительных полях';
                            break;
                        }
                    }
                }

                $day = $_POST['day'];
                if (is_array($day)) {
                    foreach ($day as $dayRow) {
                        if (trim($dayRow) == '') {
                            $errors[] = 'Не все поля "День" были заполнены в дополнительных полях';
                            break;
                        }
                    }
                }

                $month = $_POST['month'];
                if (is_array($month)) {
                    foreach ($month as $monthRow) {
                        if (trim($monthRow) == '') {
                            $errors[] = 'Не все поля "Месяц" были заполнены в дополнительных полях';
                            break;
                        }
                    }
                }
                $year = $_POST['year'];
                if (is_array($year)) {
                    foreach ($year as $yearRow) {
                        if (trim($yearRow) == '') {
                            $errors[] = 'Не все поля "Год" были заполнены в дополнительных полях';
                            break;
                        }
                    }
                }

                if (isset($_FILES) || count($_FILES['file']['name']) == count($number)) {
                    for ($h = 0; $h < count($_FILES['file']['name']); $h++) {
                        if (trim($_FILES['file']['name'][$h]) == '') {
                            $errors[] = 'Не все файлы были выбраны в дополнительных полях';
                        }
                    }
                } else {
                    $errors[] = 'Не все файлы были выбраны в дополнительных полях';
                }
            }

            if (!$errors) {
                for ($i = 0; $i < count($idCultureList); $i++) {
                    $idRegData = RegData::add($idCultureList[$i], $min_prim, $max_prim, $desc,
                                              $waitingPeriod, $maxTimes, $date4people, $date4machine);

                    // Добавление регистрационных данных к препарату и выбранным вредным объектам
                    if ($idRegData) {
                        Product::addAndRegData($idProduct, $idRegData);

                        if ($idObjectList) {
                            for ($j = 0; $j < count($idObjectList); $j++) {
                                RegData::addAndObjectGroup($idRegData, $idObjectList[$j]);
                            }
                        }
                    }
                }

                $k = 0;
                if (!empty($_FILES) &&
                    count($fileName) > 0 &&
                    count($number) > 0 &&
                    count($day) > 0 &&
                    count($month) > 0 &&
                    count($year) > 0) {

                    $uploadDir = ROOT . "/../template/img/regcertificates/";
                    foreach ($_FILES as $file) {
                        for ($m = 0; $m < count($file['name']); $m++) {
                            if ($file['name'][$m] == '')
                                continue;

                            $extension = explode(".", $file['name'][$m])[1];
                            $file_tmp_name = "{$fileName[$k]}.$extension";

                            if (move_uploaded_file($file['tmp_name'][$m], $uploadDir . $file_tmp_name)) {
                                $idRegCert = RegData::addRegCertificate($file_tmp_name, $fileName[$k]);
                                if ($idRegCert) {
                                    $date = "$year[$k]-$month[$k]-$day[$k]";
                                    Product::addAndRegCertificate($idProduct, $idRegCert, $number[$k], $date);
                                }
                            } else {
                                echo "error";
                            }

                            $k++;
                        }
                    }
                } else {
                    $errors[] = 'Не все дополнительные поля заполнены';
                }

                $success[] = 'Регистрационные данные успешно добавлены';
            }
        }

        $productListSQL = Product::getListSQL();
        $cultureListSQL = Culture::getListSQL();
        $objectGroupListSQL = ObjectGroup::getListByIdProductClassSQL(2);

        require_once(ROOT . '/views/regdata/add.php');
        return true;
    }
    
    public function actionSelectObject() {

        if (isset($_POST['idProduct'])) {
            $idProduct = $_POST['idProduct'];

            $idClProduct = Product::getIdProductClassByIdProduct($idProduct);
            if ($idClProduct) {
                $objectGroupListSQL = ObjectGroup::getListByIdProductClassSQL($idClProduct);
                while ($row = $objectGroupListSQL->fetch()) { ?>
                    <option value="<?php echo $row['id_grobject']; ?>"><?php
                        echo $row['grobject_name_rus'];
                        ?></option>
                    <?php
                }
            }
        }

        return true;
    }
    
    public function actionSelectProductCertificates() {
        
        if (isset($_POST['action']) && isset($_POST['product'])) {

            if (Check::isInt($_POST['product'])) {
                header('Location: ' . PATH . '/regdata/certification/add/' . $_POST['product']);
            }
        } else {
            
        }
        
        $productListSQL = Product::getListSQL();

        require_once(ROOT . '/views/regdata/certificates/selectProduct.php');
        return true;
    }
    public function actionAddCertificates($idProduct) {

        $errors = false;

        $number = false;

        $fileName = false;
        $number = false;
        $day = false;
        $month = false;
        $year = false;

        if (isset($_POST['fileName']) && isset($_POST['number']) &&
            isset($_POST['day']) && isset($_POST['month']) &&
            isset($_POST['year'])) {

            $fileName = $_POST['fileName'];
            if (is_array($fileName)) {
                foreach ($fileName as $fileNameRow) {
                    if (trim($fileNameRow) == '') {
                        $errors[] = 'Не все поля "Название файла" были заполнены в дополнительных полях';
                        break;
                    }
                }
            }
            $number = $_POST['number'];
            if (is_array($number)) {
                foreach ($number as $numberRow) {
                    if (trim($numberRow) == '') {
                        $errors[] = 'Не все поля "Номер свидетельства" были заполнены в дополнительных полях';
                        break;
                    }
                }
            }

            $day = $_POST['day'];
            if (is_array($day)) {
                foreach ($day as $dayRow) {
                    if (trim($dayRow) == '') {
                        $errors[] = 'Не все поля "День" были заполнены в дополнительных полях';
                        break;
                    }
                }
            }

            $month = $_POST['month'];
            if (is_array($month)) {
                foreach ($month as $monthRow) {
                    if (trim($monthRow) == '') {
                        $errors[] = 'Не все поля "Месяц" были заполнены в дополнительных полях';
                        break;
                    }
                }
            }
            $year = $_POST['year'];
            if (is_array($year)) {
                foreach ($year as $yearRow) {
                    if (trim($yearRow) == '') {
                        $errors[] = 'Не все поля "Год" были заполнены в дополнительных полях';
                        break;
                    }
                }
            }

            if (isset($_FILES) || count($_FILES['file']['name']) == count($number)) {
                for ($h = 0; $h < count($_FILES['file']['name']); $h++) {
                    if (trim($_FILES['file']['name'][$h]) == '') {
                        $errors[] = 'Не все файлы были выбраны в дополнительных полях';
                    }
                }
            } else {
                $errors[] = 'Не все файлы были выбраны в дополнительных полях';
            }

            if (!$errors) {
                $k = 0;
                if (!empty($_FILES) &&
                    count($fileName) > 0 &&
                    count($number) > 0 &&
                    count($day) > 0 &&
                    count($month) > 0 &&
                    count($year) > 0) {

                    $uploadDir = ROOT . "/../template/img/regcertificates/";
                    foreach ($_FILES as $file) {
                        for ($m = 0; $m < count($file['name']); $m++) {
                            if ($file['name'][$m] == '')
                                continue;

                            $extension = explode(".", $file['name'][$m])[1];
                            $file_tmp_name = "{$fileName[$k]}.$extension";

                            if (move_uploaded_file($file['tmp_name'][$m], $uploadDir . $file_tmp_name)) {
                                $idRegCert = RegData::addRegCertificate($file_tmp_name, $fileName[$k]);
                                if ($idRegCert) {
                                    $date = "$year[$k]-$month[$k]-$day[$k]";
                                    if (!Product::addAndRegCertificate($idProduct, $idRegCert, $number[$k], $date)) {
                                        $errors[] = 'Возникла ошибка при добавлении свидетельства к препарату';
                                    }
                                } else {
                                    $errors[] = 'Возникла ошибка при добавлении файла свидетельства';
                                }
                            } else {
                                echo "error";
                            }

                            $k++;
                        }
                    }

                    if (!$errors) {
                        $success[] = 'Все данные успешно сохранены';

                        $number = false;

                        $fileName = false;
                        $number = false;
                        $day = false;
                        $month = false;
                        $year = false;
                    }
                } else {
                    $errors[] = 'Не все дополнительные поля заполнены';
                }
            }
        }

        $productListSQL = Product::getListSQL();

        require_once(ROOT . '/views/regdata/certificates/add.php');
        return true;
    }
}