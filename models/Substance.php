<?php

class Substance
{
    public static function getListByIdProduct($idProduct)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * 
                  FROM `product_and_substance`
                  JOIN `substance` JOIN `substance_unit`  
                  ON `product_and_substance`.`id_substance` = `substance`.`id_substance` 
                  AND `product_and_substance`.`id_substance_unit` = `substance_unit`.`id_substance_unit` 
                  WHERE `product_and_substance`.`id_product` = :idProduct;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getById($idSubstance) {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `substance` WHERE `id_substance` = :idSubstance LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idSubstance', $idSubstance, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function searchByQuery($query)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_substance`, `name_rus` 
                FROM `substance` 
                WHERE `name_rus` 
                LIKE :query 
                LIMIT 5;';
        $result = $db->prepare($sql);
        $query .= '%';
        $result->bindParam(':query', $query, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}