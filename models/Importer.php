<?php

class Importer
{
    public static function getListImporterAndDateByIdManufacture($idManufacture) {
        $db = Db::getConnection();

        $sql = 'SELECT DISTINCT `importer` .`name_importer_rus`, `date` .`date`, `importer`.`id_importer`  
                  FROM `date`  
                  JOIN `importer`  JOIN `product_and_price` JOIN `product`  
                  ON `date` .`id_date` = `product_and_price`.`id_date` 
                  AND `importer` .`id_importer` = `product_and_price`.`id_importer` 
                  AND `product` .`id_product` = `product_and_price`.`id_product` 
                  WHERE `product` .`id_manufacture` = :idManufacture AND `product_and_price`.`actuality` = "1";';
        $result = $db->prepare($sql);
        $result->bindParam(':idManufacture', $idManufacture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdProduct($idProduct) {
        $db = Db::getConnection();

        $sql = 'SELECT * 
                FROM `product` JOIN `manufacture` JOIN `manufacture_logo` JOIN `importer` JOIN `manufacture_and_importer`
                ON `product`.id_manufacture = `manufacture`.id_manufacture 
                AND `manufacture`.id_manufacture = `manufacture_logo`.id_manufacture AND `manufacture`.id_manufacture = `manufacture_and_importer`.id_manufacture 
                AND `manufacture_and_importer`.id_importer = `importer`.id_importer 
                WHERE `product`.id_product = :idProduct LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}