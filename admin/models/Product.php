<?php

// Препараты
class Product
{
    public static function getListSQL($orderField = false)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_product`, `name_product_rus`, `id_clproduct` 
                FROM `product`';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `name_product_rus`;';
        }
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListByIdProductClassSQL($idProductClass, $orderField = false)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_product`, `name_product_rus` 
                FROM `product` 
                WHERE `id_clproduct` = :idProductClass';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `name_product_rus`;';
        }
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_STR);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function add($idManufacture, $idClProduct, $nameProductRus, $idProductSolution, $idAlphabetRus)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `product` (id_manufacture, id_clproduct, name_product_rus, id_product_solution, id_alphabet_rus) 
                VALUES (:idManufacture, :idClProduct, :nameProductRus, :idProductSolution, :idAlphabetRus);';
        $result = $db->prepare($sql);
        $result->bindParam(':idManufacture', $idManufacture, PDO::PARAM_INT);
        $result->bindParam(':idClProduct', $idClProduct, PDO::PARAM_INT);
        $result->bindParam(':nameProductRus', $nameProductRus, PDO::PARAM_STR);
        $result->bindParam(':idProductSolution', $idProductSolution, PDO::PARAM_INT);
        $result->bindParam(':idAlphabetRus', $idAlphabetRus, PDO::PARAM_INT);

        return $result->execute();
    }
    public static function getId($idManufacture, $idClProduct, $nameProductRus, $idProductSolution, $idAlphabetRus)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_product` 
                        FROM `product` 
                        WHERE `id_manufacture` = :idManufacture AND `id_clproduct` = :idClProduct
                        AND `name_product_rus` = :nameProductRus AND `id_product_solution` = :idProductSolution
                        AND `id_alphabet_rus` = :idAlphabetRus
                        LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idManufacture', $idManufacture, PDO::PARAM_INT);
        $result->bindParam(':idClProduct', $idClProduct, PDO::PARAM_INT);
        $result->bindParam(':nameProductRus', $nameProductRus, PDO::PARAM_STR);
        $result->bindParam(':idProductSolution', $idProductSolution, PDO::PARAM_INT);
        $result->bindParam(':idAlphabetRus', $idAlphabetRus, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['id_product'];
        }

        return false;
    }

    public static function getIdProductClassByIdProduct($idProduct)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_clproduct` 
                FROM `product` 
                WHERE `id_product` = :idProduct 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['id_clproduct'];
        }

        return false;
    }

    public static function addAndBiotarget($idProduct, $idBiblioLink, $idCulture, $idBiotarget, $idBiotargetClass, $rate, $efficacy) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `product_and_biotarget`(`id_product`, `id_biblio_link`, `id_culture`, 
                                                    `id_biotarget`, `id_biotarget_class`, `rate`, `efficacy`) 
                VALUES(:idProduct, :idBiblioLink, :idCulture, 
                       :idBiotarget, :idBiotargetClass, :rate, :efficacy);';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idBiblioLink', $idBiblioLink, PDO::PARAM_STR);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idBiotarget', $idBiotarget, PDO::PARAM_INT);
        $result->bindParam(':idBiotargetClass', $idBiotargetClass, PDO::PARAM_INT);
        $result->bindParam(':rate', $rate, PDO::PARAM_STR);
        $result->bindParam(':efficacy', $efficacy, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function getListAndPriceSQL($idProduct, $idDate) {
        $db = Db::getConnection();
        
        $sql = 'SELECT `price_rub`, `price_usd`, `id_importer`, `actuality` 
                FROM `product_and_price` 
                WHERE `id_product` = :idProduct AND `id_date` = :idDate
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idDate', $idDate, PDO::PARAM_INT);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function addAndPrice($idProduct, $idImporter, $idDate, $actuality, $priceRub, $priceUsd)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `product_and_price`(`id_product`, `id_importer`, `id_date`, `actuality`, `price_rub`, `price_usd`)
                VALUES(:idProduct, :idImporter, :idDate, :actuality, :priceRub, :priceUsd);';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idImporter', $idImporter, PDO::PARAM_INT);
        $result->bindParam(':idDate', $idDate, PDO::PARAM_INT);
        $result->bindParam(':actuality', $actuality, PDO::PARAM_STR);
        $result->bindParam(':priceRub', $priceRub, PDO::PARAM_STR);
        $result->bindParam(':priceUsd', $priceUsd, PDO::PARAM_STR);

        return $result->execute();
    }
    public static function updateAndPrice($idProduct, $idImporter, $idDate, $actuality, $priceRub, $priceUsd) {
        $db = Db::getConnection();

        $sql = 'UPDATE `product_and_price` 
                SET `id_importer` = :idImporter, `actuality` = :actuality, 
                    `price_rub` = :priceRub, `price_usd` = :priceUsd 
                WHERE `id_product` = :idProduct AND `id_date` = :idDate 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idDate', $idDate, PDO::PARAM_INT);
        $result->bindParam(':idImporter', $idImporter, PDO::PARAM_INT);
        $result->bindParam(':actuality', $actuality, PDO::PARAM_STR);
        $result->bindParam(':priceRub', $priceRub, PDO::PARAM_STR);
        $result->bindParam(':priceUsd', $priceUsd, PDO::PARAM_STR);

        if (!$result->execute())
            print_r($result->errorInfo());
    }
    public static function setActualityAndPrice($idProduct, $idImporter)
    {
        $db = Db::getConnection();

        $sql = 'UPDATE `product_and_price` 
                SET `actuality` = "0" 
                WHERE `id_product` = :idProduct AND `id_importer` = :idImporter
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idImporter', $idImporter, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function addAndRegData($idProduct, $idRegData) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `product_and_regdata`(`id_regdata`,`id_product`) 
                VALUES (:idRegData, :idProduct);';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idRegData', $idRegData, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function addAndRegCertificate($idProduct, $idRegCert, $regCertNumber, $finishDate) {
        $db = Db::getConnection();

        $sql = "INSERT INTO `product_and_regcertif`(`id_product`, `id_regcertif`, `regcertif_number`, `finishdate`) 
                VALUES (:idProduct, :idRegCert, :regCertNumber, :finishDate)";
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idRegCert', $idRegCert, PDO::PARAM_INT);
        $result->bindParam(':regCertNumber', $regCertNumber, PDO::PARAM_STR);
        $result->bindParam(':finishDate', $finishDate, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function addAndSubstance($idProduct, $idSubstance, $idSubstanceUnit, $conversation) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `product_and_substance`(`id_product`, `id_substance`, `concentration`, `id_substance_unit`)
                VALUES (:idProduct, :idSubstance, :conversation, :idSubstanceUnit);';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idSubstance', $idSubstance, PDO::PARAM_INT);
        $result->bindParam(':idSubstanceUnit', $idSubstanceUnit, PDO::PARAM_INT);
        $result->bindParam(':conversation', $conversation, PDO::PARAM_STR);

        return $result->execute();
    }

}