<?php

// Препаративные формы
class Solution
{
    public static function getListByIdProduct($idProduct) {
        $db = Db::getConnection();

        $sql = 'SELECT * 
                 FROM `product_solution`
                 JOIN `product`
                 ON `product`.`id_product_solution` = `product_solution`.`id_product_solution` 
                 WHERE `product`.`id_product` = :idProduct;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}