<?php

class RegData
{
    public static function getListByIdProductContainCulture($idProduct)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `regdata`.`id_culture`, `regdata`.`id_regdata`, `culture`.`name_rus`, `min_rate`, `max_rate`, `description`, `waiting_period`, `maxtimes`, `date4machine`, `date4people`
                FROM `product_and_regdata`
                JOIN `regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `culture` ON `culture`.`id_culture` = `regdata`.`id_culture`
                WHERE `product_and_regdata`.`id_product` = :idProduct
                GROUP BY `regdata`.`id_culture`, `regdata`.`id_regdata`, `culture`.`name_rus`, `min_rate`, `max_rate`, `description`, `waiting_period`, `maxtimes`, `date4machine`, `date4people`';
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

    public static function getListByIdProductAndIdCultureContainObject($idProduct, $idCulture, $idRegdata)
    {
        $db = Db::getConnection();

        $sql = 'SELECT GROUP_CONCAT(DISTINCT `object_group`.`grobject_name_rus` ORDER BY `object_group`.`grobject_name_rus` ASC SEPARATOR ", ") as "names"
                FROM `product_and_regdata`
                JOIN `regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `regdata_and_grobject` ON `regdata_and_grobject`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `object_group` ON `object_group`.`id_grobject` = `regdata_and_grobject`.`id_grobject`
                WHERE `product_and_regdata`.`id_product` = :idProduct AND `regdata`.`id_culture` = :idCulture AND `regdata_and_grobject`.`id_regdata` = :idRegdata;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idRegdata', $idRegdata, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['names'];
        }

        return false;
    }
    public static function getListByIdProductAndIdCultureContainGroupObject($idProduct, $idCulture, $idRegdata)
    {
        $db = Db::getConnection();

        $sql = 'SELECT GROUP_CONCAT(DISTINCT `object`.`rnameobject` ORDER BY `object`.`rnameobject` ASC SEPARATOR ", ") as "names"
                FROM `object`
                JOIN `regdata_and_object` ON `regdata_and_object`.`id_object` = `object`.`id_object`
                JOIN `regdata` ON `regdata_and_object`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `product_and_regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                WHERE `product_and_regdata`.`id_product` = :idProduct AND `regdata`.`id_culture` = :idCulture AND `regdata_and_object`.`id_regdata` = :idRegdata';
/*
                FROM `product_and_regdata`
                JOIN `regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `regdata_and_object` ON `regdata_and_object`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `object` ON `object`.`id_object` = `regdata_and_object`.`id_object`
                WHERE `product_and_regdata`.`id_product` = :idProduct AND `regdata`.`id_culture` = :idCulture AND `regdata`.`id_regdata` = `regdata_and_object`.`id_regdata`';
*/
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idRegdata', $idRegdata, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['names'];
        }

        return false;
    }
    public static function getNumberToString($number)
    {
        $length = strlen($number);
        if($length > 9) {
            $num_start = substr($number, 0,$length - 9);
            $num = substr($number, -9);
        }
        elseif($length > 6) {
            $num_start = substr($number, 0,$length - 6);
            $num = substr($number, -6);
        }
        elseif($length > 3) {
            $num_start = substr($number, 0,$length - 3);
            $num = substr($number, -3);
        }
        else $num = $number;

        $match_1 = array("/000/", "тыс.");
        $match_2 = array("/000000/", "млн.");
        $match_3 = array("/000000000/", "млрд.");
        if(preg_match($match_3[0], $num)) {
            return $num_start." ".preg_replace($match_3[0], $match_3[1], $num);
        }
        if(preg_match($match_2[0], $num)) {
            return $num_start." ".preg_replace($match_2[0], $match_2[1], $num);
        }
        if(preg_match($match_1[0], $num)) {
            return $num_start." ".preg_replace($match_1[0], $match_1[1], $num);
        }
        return $number;
    }
/*
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
*/


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