<?php

class BiotargetController
{
    public function actionSelect() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        require_once(ROOT . '/views/biotarget/select.php');
        return true;
    }
    
    public function actionAddToProduct($idBiotargetClass) {
        Admin::checkSignInAccess();

        $errors = false;
        $success = false;

        if (isset($_POST['product']) && isset($_POST['link']) &&
            isset($_POST['culture']) && isset($_POST['target']) &&
            isset($_POST['rate']) && isset($_POST['efficacy'])) {

            $idProduct = $_POST['product'];
            $idBiblioLink = $_POST['link'];
            $idCulture = $_POST['culture'];
            $idBiotarget = $_POST['target'];
            $rate = $_POST['rate'];
            $efficacy = $_POST['efficacy'];

            if (Product::addAndBiotarget($idProduct, $idBiblioLink, $idCulture, $idBiotarget, $idBiotargetClass, $rate, $efficacy)) {
                $success[] = 'Связка успешно добавлена';
            } else {
                $errors[] = 'Ошибка добавления данных в базу данных';
            }

        } else {

        }

        $productListSQL = Product::getListSQL('name');
        $biblioLinkListSQL = Biblio::getListLinkSQL();
        $cultureListSQL = Culture::getListSQL();

        $biotargetListSQL = false;
        switch($idBiotargetClass) {
            case 1:
                $biotargetListSQL = ObjectGroup::getListSQL('name');
                break;
            case 2:
                $biotargetListSQL = Object::getListSQL('name');
                break;
            case 3:
                $biotargetListSQL = Species::getListSQL('name');
                break;
        }

        require_once(ROOT . '/views/biotarget/addToProduct.php');
        return true;
    }
}