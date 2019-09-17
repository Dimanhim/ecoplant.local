<?php

// Производители
class Manufacture {

    public static function getListSQL($orderField = false) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_manufacture`, `name_manufacture_rus` FROM `manufacture`';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `name_manufacture_rus`;';
        }
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByExistProductAndProductCulture($idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `manufacture`.`id_manufacture`, `name_manufacture_rus` 
                  FROM `manufacture`
                  JOIN `product` ON `manufacture`.`id_manufacture` = `product`.`id_manufacture` 
                  WHERE `id_clproduct` = :idProductClass 
                  GROUP BY `id_manufacture`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getById($idManufacture) {
        $db = Db::getConnection();

        $sql = 'SELECT `name_manufacture_rus`, `file_manufacture_logo` 
                  FROM `manufacture`  
                  JOIN `manufacture_logo` ON `manufacture`.`id_manufacture` = `manufacture_logo`.`id_manufacture`
                  WHERE `manufacture` .`id_manufacture` = :idManufacture 
                  LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idManufacture', $idManufacture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getByIdProductSQL($idProduct) {
        $db = Db::getConnection();

        $sql = 'SELECT `name_manufacture_rus`, `file_manufacture_logo`, `name_importer_rus`
                FROM `product` JOIN `manufacture` JOIN `manufacture_logo` JOIN `importer` JOIN `manufacture_and_importer` 
                ON `product`.id_manufacture = `manufacture`.id_manufacture 
                AND `manufacture`.id_manufacture = `manufacture_logo`.id_manufacture AND `manufacture`.id_manufacture = `manufacture_and_importer`.id_manufacture 
                AND `manufacture_and_importer`.id_importer = `importer`.id_importer 
                WHERE `product`.id_product = :idProduct
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getListContainFertiliser()
    {
        $db = Db::getConnection();

        $sql = 'SELECT `manufacture`.`id_manufacture`, `manufacture`.`name_manufacture_rus` 
                FROM `fertiliser`, `manufacture`
                WHERE `fertiliser`.`id_manufacture` = `manufacture`.`id_manufacture`
                GROUP BY `manufacture`.`id_manufacture`';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}