<?php

// Упаковки
class PackAndTara
{
    public static function getListByIdProduct($idProduct) {
        $db = Db::getConnection();

        $sql = 'SELECT `product_tara`.`pack`, `product_tara`.`tara`
                 FROM `product_and_tara`, `product`, `product_tara` 
                 WHERE `product`.`id_product` = `product_and_tara`.`id_product` 
                 AND `product_tara`.`id_product_tara` = `product_and_tara`.`id_product_tara` 
                 AND `product_and_tara`.`id_product` = :idProduct;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}