<?php

class ManufactureController
{
    public function actionAdd()
    {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OTHER_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        $nameManufactureRus = false;
        $idLetter = false;

        if (isset($_POST['id_letter']) && isset($_POST['name_manufacture_rus'])) {
            $nameManufactureRus = $_POST['name_manufacture_rus'];
            $idLetter = $_POST['id_letter'];

            $idManufacture = Manufacture::add($nameManufactureRus, $idLetter);
            if ($idManufacture) {
                if ($_FILES) {
                    $uploaddir = ROOT . '/../template/img/manufacture_logo/';

                    $arrayFileName = explode('.', $_FILES['photo']['name']);
                    $formatFile = $arrayFileName[count($arrayFileName) - 1];

                    $fileName = basename(substr(md5($_FILES['photo']['name'] . time()), 8) . '.' . $formatFile);

                    $uploadfile = $uploaddir . $fileName;
                    move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile);

                    Manufacture::addLogo($idManufacture, $fileName);
                }

                $success[] = "Производитель успешно добавлен \"$nameManufactureRus\"";
            } else {
                $errors[] = 'Возникла неизвестная ошибка. Обратитесь к администратору';
            }

            $nameManufactureRus = false;
            $idLetter = false;
        }

        $rusLetterListSQL = Letter::getRusListSQL();
        $manufactureListSQL = Manufacture::getListSQL('name_manufacture_rus');

        require_once(ROOT . '/views/manufacture/add.php');
        return true;
    }

    public function actionDelete() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OTHER_FUNC, User::getId())) {
            die;
        }

        $idManufacture = false;

        if (isset($_POST['idManufacture'])) {
            $idManufacture = $_POST['idManufacture'];

            if (Manufacture::delete($idManufacture)) {
                echo 'ok';
            }
        }

        return true;
    }
}