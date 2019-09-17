<?php

class Date
{
    public static function getId($date)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_date` FROM `date` WHERE `date` = :date LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':date', $date, PDO::PARAM_STR);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['id_date'];
        }

        return false;
    }

    public static function getProductAndPriceListByIdProductSQL($idProduct)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `date`.`id_date`, `date`.`date` 
                FROM `product_and_price`, `date` 
                WHERE `id_product` = :idProduct AND `product_and_price`.`id_date` = `date`.`id_date`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function add($date)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `date`(`date`) VALUES(:date);';
        $result = $db->prepare($sql);
        $result->bindParam(':date', $date, PDO::PARAM_STR);

        return $result->execute();
    }
}