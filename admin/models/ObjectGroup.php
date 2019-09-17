<?php

class ObjectGroup
{
    public static function getListSQL($orderField = false) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_grobject`, `grobject_name_rus` FROM `object_group`';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `grobject_name_rus`;';
        }
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListByIdProductSQL($idProduct, $orderField = false)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `object_group`.`id_grobject`, `grobject_name_rus` 
                FROM `object_group` 
                JOIN `product` JOIN `product_and_regdata` ON `product_and_regdata`.`id_product` = `product`.`id_product`
                AND `product`.`id_clproduct` = `object_group`.`id_clproduct` WHERE `product_and_regdata`.`id_product` = :idProduct 
                GROUP BY `object_group`.`id_grobject`';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `grobject_name_rus`;';
        }
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdProductClassSQL($idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_grobject`, `grobject_name_rus` 
                FROM `object_group` 
                WHERE `id_clproduct` = :idProductClass;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function add($idProductClass, $nameRus, $nameEng)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `object_group`(`id_clproduct`, `grobject_name_rus`, `grobject_name_eng`) 
                VALUES (:idProductClass, :nameRus, :nameEng)';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->bindParam(':nameRus', $nameRus, PDO::PARAM_STR);
        $result->bindParam(':nameEng', $nameEng, PDO::PARAM_STR);

        return $result->execute();
    }
    public static function getId($idProductClass, $nameRus, $nameEng)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_grobject` 
                FROM `object_group` 
                WHERE `id_clproduct` = :idProductClass 
                AND `grobject_name_rus` = :nameRus AND `grobject_name_eng` = :nameEng
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->bindParam(':nameRus', $nameRus, PDO::PARAM_STR);
        $result->bindParam(':nameEng', $nameEng, PDO::PARAM_STR);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['id_grobject'];
        }

        return false;
    }
}