<?php

// Типы препарата
class ProductClass
{
    public static function getListSQL($orderField = false)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_clproduct`, `name_clproduct_rus` FROM `product_class`';
        if ($orderField) {
            $sql .= ' ORDER BY :orderField;';
        }
        $result = $db->prepare($sql);
        if ($orderField) {
            $result->bindParam(':orderField', $orderField, PDO::PARAM_STR);
        }
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListPesticideSQL($orderField = false)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `product_type`';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getNameById($idProductClass)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `name_clproduct_rus` 
                FROM `product_class`
                WHERE `id_clproduct` = :idProductClass';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_STR);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['name_clproduct_rus'];
        }

        return false;
    }
}