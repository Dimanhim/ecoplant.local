<?php

class RegData
{
    public static function getListByIdProductContainCulture($idProduct)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `regdata`.`id_culture`, `culture`.`name_rus`, `min_rate`, `max_rate`, `description`, `waiting_period`, `maxtimes`, `date4machine`, `date4people`
                FROM `product_and_regdata`
                JOIN `regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `culture` ON `culture`.`id_culture` = `regdata`.`id_culture`
                WHERE `product_and_regdata`.`id_product` = :idProduct
                GROUP BY `regdata`.`id_culture`, `culture`.`name_rus`, `min_rate`, `max_rate`, `description`, `waiting_period`, `maxtimes`, `date4machine`, `date4people`';
/*
//------------Убрал из запроса последнюю строку и заработало
GROUP BY `regdata`.`id_culture`;
*/
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdProductAndIdCultureContainObject($idProduct, $idCulture)
    {
        $db = Db::getConnection();

        $sql = 'SELECT GROUP_CONCAT(DISTINCT `object_group`.`grobject_name_rus` ORDER BY `object_group`.`grobject_name_rus` ASC SEPARATOR ", ") as "names"
                FROM `product_and_regdata`
                JOIN `regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `regdata_and_grobject` ON `regdata_and_grobject`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `object_group` ON `object_group`.`id_grobject` = `regdata_and_grobject`.`id_grobject`
                WHERE `product_and_regdata`.`id_product` = :idProduct AND `regdata`.`id_culture` = :idCulture;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['names'];
        }

        return false;
    }

    public static function getListByIdProductAndIdCultureSQL($idProduct, $idCulture) {
        $db = Db::getConnection();

        $sql = 'SELECT * 
                FROM `product_and_regdata`
                JOIN `regdata`
                ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata` 
                WHERE `product_and_regdata`.`id_product` = :idProduct
                AND `regdata`.`id_culture` = :idCulture
                GROUP BY `regdata`.`id_culture`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getRegCertificateByIdProduct($idProduct)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * 
               FROM `product`
               JOIN `regcertificate`
               JOIN `product_and_regcertif`
               ON `product`.id_product = `product_and_regcertif`.id_product
               AND `product_and_regcertif`.id_regcertif = `regcertificate`.id_regcertif  
               WHERE `product`.id_product = :idProduct;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}