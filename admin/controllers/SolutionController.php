<?php

class SolutionController
{
    public function actionAdd() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $name = false;
        $shortName = false;

        $success = false;
        $errors = false;

        if (isset($_POST['action'])) {
            if (isset($_POST['name_product_solution']) && isset($_POST['short_name_product_solution']) &&
                $_POST['name_product_solution'] != '' && $_POST['short_name_product_solution'] != '') {
                $name = $_POST['name_product_solution'];
                $shortName = $_POST['short_name_product_solution'];

                Solution::add($name, $shortName);

                $success[] = "Форма \"$name\" успешно добавлена";

                $name = false;
                $shortName = false;
            } else {
                $errors[] = 'Не все поля заполнены';
            }
        }

        $solutionListSQL = Solution::getListSQL();

        require_once(ROOT . '/views/solution/add.php');
        return true;
    }
    
    public function actionDelete() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_PRODUCT_FUNC, User::getId())) {
            die;
        }

        $idSolution = false;

        if (isset($_POST['idSolution'])) {
            $idSolution = $_POST['idSolution'];

            if (Solution::delete($idSolution)) {
                echo 'ok';
            }
        }

        return true;
    }
}