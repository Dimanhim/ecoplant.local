<?php

class AdminBlockFunc
{
    public static function getList() {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `admin_block_func`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdUserGroup($idUserGroup)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `admin_block_func`.`id` 
                FROM `admin_block_func`, `user_group_access` 
                WHERE `user_group_access`.`id_user_group` = :idUserGroup AND 
                      `user_group_access`.`id_admin_block_func` = `admin_block_func`.`id`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idUserGroup', $idUserGroup, PDO::PARAM_INT);
        $result->execute();

        $array = array();
        if ($result->rowCount()) {
            while ($row = $result->fetch()) {
                $array[$row['id']] = $row['id'];
            }

            return $array;
        }

        return false;
    }
}