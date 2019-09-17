<?php

class UserGroupController
{
    public function actionIndex() {
        $userGroupList = UserGroup::getList();
        $userList = User::getList();

        require_once(ROOT . '/views/userGroup/index.php');
        return true;
    }
    
    public function actionAdd() {

        $adminBlockFuncList = AdminBlockFunc::getList();

        $errors = false;
        $name = false;

        if (isset($_POST['action'])) {
            if (isset($_POST['name'])) {
                $name = $_POST['name'];

                if (!Check::strLength($name, 3, 128)) {
                    $errors[] = 'Название должно быть более 3 и менее 128 символов';
                }

                $adminBlockFuncArray = array();
                if ($adminBlockFuncList) {
                    while ($row = $adminBlockFuncList->fetch()) {
                        if (isset($_POST['admin-block-func-' . $row['id']]) &&
                            $_POST['admin-block-func-' . $row['id']] == 'on') {
                            $adminBlockFuncArray[] = $row['id'];
                        }
                    }
                }
                if (count($adminBlockFuncArray) == 0) {
                    $errors[] = 'Для группы пользователей должен быть выбран хотя бы один блок функций';
                }

                if (!$errors) {
                    $idUserGroup = UserGroup::add($name, $adminBlockFuncArray);
                    if ($idUserGroup) {
                        header('Location: ' . PATH . '/userGroup/edit' . $idUserGroup);
                    }
                }
            } else {

            }
        }

        require_once(ROOT . '/views/userGroup/add.php');
        return true;
    }
    public function actionEdit($idUserGroup) {

        $adminBlockFuncList = AdminBlockFunc::getList();

        $errors = false;
        $success = false;

        if (isset($_POST['action'])) {
            if (isset($_POST['name'])) {
                $name = $_POST['name'];

                if (!Check::strLength($name, 3, 128)) {
                    $errors[] = 'Название должно быть более 3 и менее 128 символов';
                }

                $adminBlockFuncArray = array();
                if ($adminBlockFuncList) {
                    while ($row = $adminBlockFuncList->fetch()) {
                        if (isset($_POST['admin-block-func-' . $row['id']]) &&
                            $_POST['admin-block-func-' . $row['id']] == 'on') {
                            $adminBlockFuncArray[] = $row['id'];
                        }
                    }
                }
                if (count($adminBlockFuncArray) == 0) {
                    $errors[] = 'Для группы пользователей должен быть выбран хотя бы один блок функций';
                }

                if (!$errors) {
                    if (UserGroup::update($idUserGroup, $name, $adminBlockFuncArray)) {
                        $success[] = 'Изменения сохранены';
                    }
                }
            } else {

            }
        }

        $userGroup = UserGroup::get($idUserGroup);
        $adminBlockFuncArray = AdminBlockFunc::getListByIdUserGroup($idUserGroup);

        require_once(ROOT . '/views/userGroup/edit.php');
        return true;
    }
    public function actionDelete($idUserGroup) {

        // Невозможность удалить группу администраторы
        if ($idUserGroup == 1) {
            header('Location: ' . PATH . '/userGroup/edit/1');
        }

        if (isset($_POST['action'])) {
            if (UserGroup::delete($idUserGroup)) {
                header('Location: ' . PATH . '/userGroup');
            }
        }

        $userGroup = UserGroup::get($idUserGroup);

        require_once(ROOT . '/views/userGroup/delete.php');
        return true;
    }

    public function actionUserAdd() {

        $errors = false;
        $username = false;
        $pass = false;
        $idUserGroup = false;

        if (isset($_POST['action'])) {
            $username = $_POST['username'];
            $pass = $_POST['pass'];
            if (isset($_POST['idUserGroup'])) {
                $idUserGroup = $_POST['idUserGroup'];
            }

            if (!Check::isInt($idUserGroup)) {
                $errors[] = 'Выберите группу пользователей';
            }

            if (!Check::strLength($username, 5)) {
                $errors[] = 'Логин пользователя должен быть более 5 символов';
            } else {
                if (!Check::strLength($username, 5, 128)) {
                    $errors[] = 'Логин пользователя должен быть более 5 и не более 128 символов';
                }
            }

            if (!Check::strLength($pass, 6)) {
                $errors[] = 'Пароль пользователя должен быть более 6 символов';
            } else {
                if (!Check::strLength($pass, 6, 128)) {
                    $errors[] = 'Пароль пользователя должен быть более 6 и не более 128 символов';
                }
            }

            if (!$errors) {
                $idUser = User::add($idUserGroup, $username, $pass);
                if ($idUser) {
                    header('Location: '. PATH . '/userGroup/user/edit/' . $idUser);
                }
            }
        }

        $userGroupList = UserGroup::getList();

        require_once(ROOT . '/views/userGroup/user/add.php');
        return true;
    }
    public function actionUserEdit($idUser) {

        $errors = false;
        $success = false;

        $idUserGroup = false;
        $pass = false;

        if (isset($_POST['action'])) {
            if (isset($_POST['idUserGroup'])) {
                $idUserGroup = $_POST['idUserGroup'];

                $userIdUserGroup = User::get($idUser)['id_user_group'];
                if ($idUserGroup != $userIdUserGroup) {
                    if (!Check::isInt($idUserGroup)) {
                        $errors[] = 'Группа пользователя выбрана неверно';
                    }

                    if (!$errors && User::updateUserGroup($idUser, $idUserGroup)) {
                        $success[] = 'Группа пользователя была успешно изменена';
                    }
                }
            }

            if (isset($_POST['pass']) && $_POST['pass']) {
                $pass = $_POST['pass'];

                if (!Check::strLength($pass, 6)) {
                    $errors[] = 'Пароль пользователя должен быть более 6 символов';
                } else {
                    if (!Check::strLength($pass, 6, 128)) {
                        $errors[] = 'Пароль пользователя должен быть более 6 и не более 128 символов';
                    }
                }

                if (!$errors && User::updatePass($idUser, $pass)) {
                    $success[] = 'Пароль пользователя был успешно изменен';
                    $pass = false;
                }
            } else {

            }
        }

        $user = User::get($idUser);
        $userGroupList = UserGroup::getList();

        require_once(ROOT . '/views/userGroup/user/edit.php');
        return true;
    }
    public function actionUserDelete($idUser) {

        // Невозможность удалить группу администраторы
        if ($idUser == 1) {
            header('Location: ' . PATH . '/userGroup/user/edit/1');
        }

        if (isset($_POST['action'])) {
            if (User::delete($idUser)) {
                header('Location: ' . PATH . '/userGroup');
            }
        }

        $user = User::get($idUser);

        require_once(ROOT . '/views/userGroup/user/delete.php');
        return true;
    }
}