<?php

class Culture
{
    public static function getNameById($idCulture)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `name_rus` FROM `culture` WHERE `id_culture` = :idCulture LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['name_rus'];
        }

        return false;
    }
    public static function getListByExistObject() {
        $db = Db::getConnection();

        $sql = 'SELECT `culture_group`.`id_culture_group`, `culture_group`.`name_culture_group_rus`
                FROM `object`, `object_and_culture`, `culture`, `culture_group`
                WHERE `object`.`id_object` = `object_and_culture`.`id_object` AND `object_and_culture`.`id_culture` = `culture`.`id_culture` AND
                      `culture`.`id_culture_group` = `culture_group`.`id_culture_group`
                GROUP BY `culture_group`.`id_culture_group`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListByIdCultureGroup($idCultureGroup) {
        $db = Db::getConnection();

        $sql = 'SELECT `culture`.`id_culture`, `culture`.`name_rus`
                FROM `object`, `object_and_culture`, `culture`, `culture_group`
                WHERE `object`.`id_object` = `object_and_culture`.`id_object` AND `object_and_culture`.`id_culture` = `culture`.`id_culture` AND
                      `culture`.`id_culture_group` = `culture_group`.`id_culture_group` AND `culture_group`.`id_culture_group` = :idCultureGroup
                GROUP BY `culture`.`id_culture`;';

        $result = $db->prepare($sql);
        $result->bindParam(':idCultureGroup', $idCultureGroup, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListWithoutCultureGroup() {
        $db = Db::getConnection();

        $sql = 'SELECT `culture`.`id_culture`, `culture`.`name_rus`
                FROM `object`, `object_and_culture`, `culture`
                WHERE `object`.`id_object` = `object_and_culture`.`id_object` 
                AND `object_and_culture`.`id_culture` = `culture`.`id_culture` 
                AND `culture`.`id_culture_group` = "0"
                GROUP BY `culture`.`id_culture`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdObjectSQL($idObject) {
        $db = Db::getConnection();

        $sql = 'SELECT `culture`.`id_culture`, `culture`.`name_rus` 
                FROM `culture`, `object_and_culture` 
                WHERE `culture`.`id_culture` = `object_and_culture`.`id_culture` 
                AND `object_and_culture`.`id_object` = :idObject;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdCultureGroupAndIdProductClassWithRegData($idCultureGroup, $idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `culture`.`id_culture`, `culture`.`name_rus`
                FROM `regdata`
                JOIN `product_and_regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `culture` ON `culture`.`id_culture` = `regdata`.`id_culture`
                JOIN `product` ON `product`.`id_product` = `product_and_regdata`.`id_product`
                WHERE `product`.`id_clproduct` = :idProductClass AND `culture`.`id_culture_group` = :idCultureGroup
                GROUP BY `culture`.`id_culture`';
        $result = $db->prepare($sql);
        $result->bindParam(':idCultureGroup', $idCultureGroup, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdCultureGroupAndIdProductClass($idCultureGroup, $idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT DISTINCT `culture`.`id_culture` 
                  FROM `culture`  
                  JOIN `product`  JOIN `product_and_culture`  
                  ON `culture` .`id_culture` = `product_and_culture` .id_culture 
                  AND `product_and_culture` .`id_product` = `product` .`id_product`
                  WHERE `culture` .`id_culture_group` = :idCultureGroup AND `product` .`id_clproduct` = :idProductClass;';
        $result = $db->prepare($sql);
        $result->bindParam(':idCultureGroup', $idCultureGroup, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdProduct($idProduct)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * 
                FROM `product_and_culture` 
                JOIN `culture` ON `product_and_culture`.`id_culture` = `culture`.`id_culture` 
                WHERE `product_and_culture`.`id_product` = :idProduct;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdCultureClass($idCultureClass)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `culture`.`id_culture`, `culture`.`name_rus`
             FROM `object`, `object_and_culture`, `culture`, `culture_class`
             WHERE `object`.`id_object` = `object_and_culture`.`id_object` AND 
                   `object_and_culture`.`id_culture` = `culture`.`id_culture` AND
                   `culture`.`id_culture_class` = `culture_class`.`id_culture_class` AND
                   `culture_class`.`id_culture_class` = :idCultureClass
             GROUP BY `culture`.`id_culture`';
        $result = $db->prepare($sql);
        $result->bindParam(':idCultureClass', $idCultureClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    // ID культур включащих вредный объект
    public static function getListContainBiotarget($idObject)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `culture`.`id_culture`
                FROM `product_and_biotarget`
                JOIN `biblio_link`
                JOIN `object`
                JOIN `product`
                JOIN `culture`
                ON `product_and_biotarget`.`id_biotarget` = `object`.`id_object`
                AND `product_and_biotarget`.`id_product` = `product`.`id_product`
                AND `product_and_biotarget`.`id_biblio_link` = `biblio_link`.`id_biblio_link`
                AND `product_and_biotarget`.`id_biotarget_class` = "2"
                AND `product_and_biotarget`.`id_culture` = `culture`.`id_culture`
                AND `object`.`id_object` = :idObject
                GROUP BY `culture`.`id_culture`';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}