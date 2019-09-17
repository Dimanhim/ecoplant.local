<?php

// Типы препарата
class ProductClass
{
    public static function getListWithDescSQL() {
        $db = Db::getConnection();

        $sql = 'SELECT `product_class`.`id_clproduct`, `definition_rus`, `name_clproduct_rus` 
                  FROM `product_class_def_rus`
                  JOIN `product_class` 
                  ON `product_class`.`id_clproduct` = `product_class_def_rus`.`id_clproduct` 
                  ORDER BY `page_position`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getById($idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_clproduct`, `name_clproduct_rus`
                FROM `product_class` 
                WHERE `id_clproduct` = :idProductClass 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getByIdProductAndIdProductAndIdCulture($idProduct, $idProductClass, $idCulture) {
        $db = Db::getConnection();

        $sql = 'SELECT * 
                FROM `product_class` JOIN `product` JOIN `product_and_regdata` JOIN `regdata` JOIN `culture` 
                ON `product`.id_clproduct = `product_class`.id_clproduct AND `product`.id_product = `product_and_regdata`.id_product 
                AND `product_and_regdata`.id_regdata = `regdata`.id_regdata AND `regdata`.id_culture = `culture`.id_culture  
                WHERE `product_class`.id_clproduct = :idProductClass AND `product`.id_product = :idProduct 
                AND `culture`.id_culture = :idCulture;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getByIdProduct($idProduct) {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `product_class` 
                JOIN `product` JOIN `manufacture` 
                ON `product`.`id_clproduct` = `product_class`.`id_clproduct`
                AND `product`.`id_manufacture` = `manufacture`.`id_manufacture`
                WHERE `product`.`id_product` = :idProduct LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getListByIdSubstanceAndIdCulture($idSubstance, $idCulture)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `product_class`.`id_clproduct`, `product_class`.`name_clproduct_rus` 
                  FROM `substance`
                  JOIN `product_and_substance` JOIN `product` JOIN `product_and_price`
                  JOIN `product_and_culture` JOIN `product_class` 
                  ON `substance`.`id_substance` = `product_and_substance`.`id_substance`
                  AND `product_and_substance`.`id_product` = `product`.`id_product`
                  AND `product`.`id_product` = `product_and_culture`.`id_product`
                  AND `product`.`id_product` = `product_and_price`.`id_product`
                  AND `product`.`id_clproduct` = `product_class`.`id_clproduct`
                  WHERE `substance`.`id_substance` = :idSubstance
                  AND `product_and_culture`.`id_culture` = :idCulture AND `product_and_price`.`actuality` = "1" 
                  GROUP BY `product_class`.`id_clproduct`
                  ORDER BY `product_class`.`page_position`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idSubstance', $idSubstance, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdManufactureAndIdImporter($idManufacture, $idImporter) {
        $db = Db::getConnection();

        $sql = 'SELECT `product_class`.`name_clproduct_rus`, `product_class`.`id_clproduct` 
                  FROM `product_class` JOIN `product` JOIN `product_and_price`
                  ON `product_class`.`id_clproduct` = `product`.`id_clproduct` AND `product`.`id_product` = `product_and_price`.`id_product`
                  WHERE `product`.`id_manufacture` = :idManufacture AND `product_and_price`.`id_importer` = :idImporter
                  GROUP BY `product_class`.`id_clproduct` 
                  ORDER BY `product_class`.`page_position`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idManufacture', $idManufacture, PDO::PARAM_INT);
        $result->bindParam(':idImporter', $idImporter, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}