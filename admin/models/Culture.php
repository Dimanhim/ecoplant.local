<?php

class Culture
{
    public static function getListSQL($orderField = false) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_culture`, `name_rus` FROM `culture`';
        if ($orderField) {
            $sql .= 'ORDER BY :orderField;';
        }
        $result = $db->prepare($sql);
        if ($orderField) {
            $result->bindParam(':orderField', $orderField, PDO::PARAM_STR);
        }
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    // Получаем список культур у указанного объекта
    public static function getListByIdObject($idObject)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `culture`.`id_culture`, `culture`.`name_rus`
                FROM `object`, `object_and_culture`, `culture`, `culture_class`
                WHERE `object`.`id_object` = `object_and_culture`.`id_object` AND 
                      `object_and_culture`.`id_culture` = `culture`.`id_culture` AND
                      `culture`.`id_culture_class` = `culture_class`.`id_culture_class` AND 
                      `object`.`id_object` = :idObject
                      GROUP BY `id_culture`';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function get($idCulture)
    {
        $db = Db::getConnection();
        
        $sql = 'SELECT `name_rus` FROM `culture` WHERE `id_culture` = :id_culture LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_culture', $idCulture, PDO::PARAM_INT);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result->fetch();
        }
        
        return false;
    }
}