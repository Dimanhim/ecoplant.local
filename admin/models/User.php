<?php

class User
{
    // Получение ID авторизованного пользователя
    public static function getId()
    {
        if (isset($_SESSION['user']) && $_SESSION['user'] != 0) {
            return $_SESSION['user'];
        }

        return false;
    }

    // Авторизация администратора
    public static function signIn($userId) {
        $_SESSION['user'] = $userId;

        $db = Db::getConnection();

        $sql = 'SELECT `access` FROM `user` WHERE `id_user` = :userId LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':userId', $userId, PDO::PARAM_STR);
        $result->execute();

        if ($result->rowCount()) {
            $user = $result->fetch();

            $_SESSION['admin'] = 0;

            if ($user['access'] == 1) {
                $_SESSION['admin'] = 1;
            }
        }

        header('Location: ' . PATH);
    }
    // Выход администратора
    public static function signOut() {
        unset($_SESSION['user']);
        unset($_SESSION['admin']);

        if (PATH != '')
            header('Location: ' . PATH);
        else
            header('Location: /');
    }
    // Получение имени авторизованного пользователя
    public static function getUserName()
    {
        $db = Db::getConnection();

        $sql = 'SELECT `username` FROM `user` WHERE `id_user` = :userId LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':userId', $_SESSION['user'], PDO::PARAM_STR);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['username'];
        }

        return false;
    }
    // Проверка данных пользователя
    public static function checkUserData($login, $password)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_user`, `password` FROM `user` WHERE `username` = :login LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':login', $login, PDO::PARAM_STR);
        $result->execute();

        if ($result->rowCount()) {
            $user = $result->fetch();

            if ($password == $user['password']) {
                return $user['id_user'];
            }
        }

        return false;
    }
    
    // Проверка на наличие группы пользователей
    public static function getIdUserGroup($idUser) {
        $db = Db::getConnection();
        
        $sql = 'SELECT `id_user_group` FROM `user` WHERE `id_user` = :id_user LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_user', $idUser, PDO::PARAM_INT);
        $result->execute();
        
        if ($result->rowCount()) {
            $idUserGroup = $result->fetch()['id_user_group'];
            if ($idUserGroup != 0) {
                return $idUserGroup;
            }
        }
        
        return false;
    }

    // Получение списка пользователей
    public static function getList() {
        $db = Db::getConnection();

        $sql = 'SELECT * 
                FROM `user`, `user_group` 
                WHERE `user`.`id_user_group` = `user_group`.`id`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    // Получение информации о пользователе
    public static function get($idUser)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `username`, `password`, `id_user_group` FROM `user` WHERE `id_user` = :id_user LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_user', $idUser, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }
    // Добавление нового пользователя
    public static function add($idUserGroup, $username, $pass) {
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO `user`(`id_user_group`, `username`, `password`) 
                VALUES(:id_user_group, :username, :password);';
        $result = $db->prepare($sql);
        $result->bindParam(':id_user_group', $idUserGroup, PDO::PARAM_STR);
        $result->bindParam(':username', $username, PDO::PARAM_STR);
        $result->bindParam(':password', $pass, PDO::PARAM_STR);
        
        $result->execute();
        return $db->lastInsertId();
    }
    // Обновление группы пользователей у конкретного пользователя
    public static function updateUserGroup($idUser, $idUserGroup) {
        $db = Db::getConnection();

        $sql = 'UPDATE `user` 
                SET `id_user_group` = :id_user_group 
                WHERE `id_user` = :id_user 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_user', $idUser, PDO::PARAM_INT);
        $result->bindParam(':id_user_group', $idUserGroup, PDO::PARAM_INT);

        return $result->execute();
    }
    // Обновление пароля пользователя у конкретного пользователя
    public static function updatePass($idUser, $pass) {
        $db = Db::getConnection();

        $sql = 'UPDATE `user` SET `password` = :password WHERE `id_user` = :id_user LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_user', $idUser, PDO::PARAM_INT);
        $result->bindParam(':password', $pass, PDO::PARAM_STR);

        return $result->execute();
    }
    // Удаление пользователя
    public static function delete($idUser)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `user` WHERE `id_user` = :id_user LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_user', $idUser, PDO::PARAM_INT);

        return $result->execute();
    }
}