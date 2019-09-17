<?php

class Admin
{
    // Проверка авторизован ли администратор
    public static function checkSignIn() {
        if (isset($_SESSION['user']) && isset($_SESSION['admin'])) {
            if ($_SESSION['admin'] == 1)
                return true;
        }

        return false;
    }

    // Проверка на доступ к странице авторизованным пользователям
    public static function checkSignInAccess() {
        if (isset($_SESSION['user']) && isset($_SESSION['admin'])) {
            if ($_SESSION['admin'] == 1)
                return true;
        }

        header('Location: ' . PATH . '/signIn');
    }

    public static function accessDenied() {
        $_SESSION['accessDenied'] = true;
        header('Location: ' . PATH . '/');
    }
}