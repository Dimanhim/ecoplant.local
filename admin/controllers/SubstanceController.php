<?php

class SubstanceController
{
    public function actionAdd() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        if (isset($_POST['action'])) {
            if (isset($_POST['name_rus'])) {
                $nameSubstanceRus = $_POST['name_rus'];
                if (Substance::add($nameSubstanceRus)) {
                    header('Location: ' . PATH . '/substance/addToProduct');
                } else {
                    $errors[] = 'Ошибка добавления данных в базу данных';
                }
            } else {
                $errors[] = 'Не все поля заполнены';
            }
        }

        require_once(ROOT . '/views/substance/add.php');
        return true;
    }
    public function actionAddToProduct() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        if (isset($_POST['action'])) {
            if (isset($_POST['substance']) && isset($_POST['substance_unit']) && isset($_POST['concentration'])) {
                $idSubstance = $_POST['substance'];
                $idSubstanceUnit = $_POST['substance_unit'];
                $concentration = $_POST['concentration'];

                //Выполнение команды к таблице Базе Данных

                if (Product::addAndSubstance($_SESSION['idProduct'], $idSubstance, $idSubstanceUnit, $concentration)) {
                    $_SESSION['substanceName'] = Substance::getNameById($idSubstance);

                    header('Location: ' . PATH . '/substance/addToProductNext');
                } else {
                    $errors[] = 'Ошибка добавления данных в базу данных.';
                }
            } else {
                $errors[] = 'Не все поля были заполнены';
            }
        }

        $substanceListSQL = Substance::getListSQL('name');
        $substanceUnitListSQL = Substance::getUnitListSQL('name');

        require_once(ROOT . '/views/substance/addtoproduct.php');
        return true;
    }
    public function actionAddToProductNext() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        $substanceListSQL = Substance::getListSQL('name');
        $substanceUnitListSQL = Substance::getUnitListSQL('name');

        require_once(ROOT . '/views/substance/addtoproductnext.php');
        return true;
    }
}