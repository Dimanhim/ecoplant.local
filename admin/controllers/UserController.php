<?php

class UserController {
    // Авторизация пользователя
    public function actionSignIn() {
        $errors = false;

        $login = false;
        $password = false;

        if (isset($_POST['login']) && isset($_POST['password'])) {
            $login = $_POST['login'];
            $password = $_POST['password'];

            // Проверка логина
            if (!Check::strLength($login, 4)) {
                $errors[] = 'Логин должен быть более 4 символов';
            }
            // Проверка пароля
            if (!Check::strLength($password, 4)) {
                $errors[] = 'Пароль должен быть более 4 символов';
            }

            if (!$errors) {
                // Получаем ID пользователя
                $idUser = User::checkUserData($login, $password);
                if ($idUser) {
                    User::signIn($idUser);

                } else {
                    $errors[] = 'Неверно указан логин или пароль';
                }
            }
        }

        require_once(ROOT . '/views/user/signin.php');
        return true;
    }
    // Выход пользователя
    public function actionSignOut() {
        User::signOut();
        return true;
    }
}