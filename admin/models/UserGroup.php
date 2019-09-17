<?php

class UserGroup
{
    public static function get($idUserGroup) {
        $db = Db::getConnection();

        $sql = 'SELECT `name` FROM `user_group` WHERE `id` = :id LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $idUserGroup, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }
    // Вывод списка групп
    public static function getList()
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `user_group`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    // Добавление группы пользователей
    public static function add($name, $accessAdminBlockFuncArray)
    {
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO `user_group`(`name`) VALUES(:name);';
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        
        $result->execute();
        $idUserGroup = $db->lastInsertId();

        if ($accessAdminBlockFuncArray && is_array($accessAdminBlockFuncArray)) {
            for ($i = 0; $i < count($accessAdminBlockFuncArray); $i++) {
                $sql = 'INSERT INTO `user_group_access`(`id_user_group`, `id_admin_block_func`) 
                        VALUES(:id_user_group, :id_admin_block_func);';
                $result = $db->prepare($sql);
                $result->bindParam(':id_user_group', $idUserGroup, PDO::PARAM_INT);
                $result->bindParam(':id_admin_block_func', $accessAdminBlockFuncArray[$i], PDO::PARAM_INT);
                
                $result->execute();
            }
        }

        return $idUserGroup;
    }
    // Обновление группы пользователей
    public static function update($idUserGroup, $name, $accessAdminBlockFuncArray)
    {
        $db = Db::getConnection();

        $sql = 'UPDATE `user_group` SET `name` = :name WHERE `id` = :id LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $idUserGroup, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);

        $result->execute();

        $sql = 'DELETE FROM `user_group_access` WHERE `id_user_group` = :id_user_group;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_user_group', $idUserGroup, PDO::PARAM_INT);
        
        $result->execute();

        if ($accessAdminBlockFuncArray && is_array($accessAdminBlockFuncArray)) {
            for ($i = 0; $i < count($accessAdminBlockFuncArray); $i++) {
                $sql = 'INSERT INTO `user_group_access`(`id_user_group`, `id_admin_block_func`) 
                        VALUES(:id_user_group, :id_admin_block_func);';
                $result = $db->prepare($sql);
                $result->bindParam(':id_user_group', $idUserGroup, PDO::PARAM_INT);
                $result->bindParam(':id_admin_block_func', $accessAdminBlockFuncArray[$i], PDO::PARAM_INT);

                $result->execute();
            }
        }

        return true;
    }
    // Удаление группы пользователей и информации о доступе к блокам функций
    public static function delete($idUserGroup)
    {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `user_group` WHERE `id` = :id LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $idUserGroup, PDO::PARAM_INT);

        if ($result->execute()) {

            $db = Db::getConnection();

            $sql = 'DELETE FROM `user_group_access` WHERE `id_user_group` = :id_user_group LIMIT 1;';
            $result = $db->prepare($sql);
            $result->bindParam(':id_user_group', $idUserGroup, PDO::PARAM_INT);

            if ($result->execute()) {
                return true;
            }
        }

        return false;
    }

    // Проверка на доступ к блоку функций по группе пользователей
    public static function accessAdminBlockFunc($idAdminBlockFunc, $idUserGroup) {
        $db = Db::getConnection();

        $sql = 'SELECT `id` 
                FROM `user_group_access` 
                WHERE `id_user_group` = :id_user_group AND `id_admin_block_func` = :id_admin_block_func
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_user_group', $idUserGroup, PDO::PARAM_INT);
        $result->bindParam(':id_admin_block_func', $idAdminBlockFunc, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return true;
        }

        return false;
    }
    // Проверка на доступ к блоку функций по пользователю
    public static function accessAdminBlockByIdUser($idAdminBlock, $idUser) {
        $db = Db::getConnection();

        $sql = 'SELECT `user_group_access`.`id` 
                FROM `user_group_access`, `user_group`, `user`
                WHERE `user`.`id_user` = :id_user AND `user_group_access`.`id_admin_block_func` = :id_admin_block_func AND
                `user`.`id_user_group` = `user_group`.`id` AND `user_group_access`.`id_user_group` = `user_group`.`id`';
        $result = $db->prepare($sql);
        $result->bindParam(':id_user', $idUser, PDO::PARAM_INT);
        $result->bindParam(':id_admin_block_func', $idAdminBlock, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['id'];
        }

        return false;
    }
}