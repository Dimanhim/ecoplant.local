<?php

class RegData
{
    public static function getListByIdProductSQL($idProduct, $orderField = false)
    {
        $db = Db::getConnection();

        $sql = "SELECT `regdata`.`id_regdata`, `name_rus`, `min_rate`, `max_rate`, `description` 
                FROM `product_and_regdata` JOIN `regdata` JOIN `culture`
                ON `product_and_regdata`.id_regdata = `regdata`.id_regdata AND `regdata`.id_culture = `culture`.id_culture 
                WHERE `product_and_regdata`.id_product = :idProduct";
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `name_rus`;';
        }
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function add($idCulture, $minPrim, $maxPrim, $desc, $waitingPeriod = '',
                               $maxTimes = '', $date4people = '', $date4machine = '') {

        $db = Db::getConnection();

        $sql = "INSERT INTO `regdata`(`id_culture`, `min_rate`, `max_rate`, `description`, 
                                      `waiting_period`, `maxtimes`, `date4people`, `date4machine`) 
                VALUES (:idCulture, :minPrim, :maxPrim, :desc, :waitingPeriod,
                        :maxTimes, :date4people, :date4machine);";
        $result = $db->prepare($sql);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':minPrim', $minPrim, PDO::PARAM_STR);
        $result->bindParam(':maxPrim', $maxPrim, PDO::PARAM_STR);
        $result->bindParam(':desc', $desc, PDO::PARAM_STR);
        $result->bindParam(':waitingPeriod', $waitingPeriod, PDO::PARAM_STR);
        $result->bindParam(':maxTimes', $maxTimes, PDO::PARAM_STR);
        $result->bindParam(':date4people', $date4people, PDO::PARAM_STR);
        $result->bindParam(':date4machine', $date4machine, PDO::PARAM_STR);

        if ($result->execute()) {
            return $db->lastInsertId();
        } else {
            print_r($result->errorInfo());
        }

        return false;
    }

    public static function addAndObjectGroup($idRegData, $idObjectGroup)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `regdata_and_grobject`(`id_regdata`, `id_grobject`) 
                VALUES (:idRegData, :idObjectGroup)';
        $result = $db->prepare($sql);
        $result->bindParam(':idRegData', $idRegData, PDO::PARAM_INT);
        $result->bindParam(':idObjectGroup', $idObjectGroup, PDO::PARAM_INT);

        return $result->execute();
    }
    public static function addAndObjectGroup2($idRegData, $idObject)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `regdata_and_object`(`id_regdata`, `id_object`) 
                VALUES (:idRegData, :idObject)';
        $result = $db->prepare($sql);
        $result->bindParam(':idRegData', $idRegData, PDO::PARAM_INT);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);

        return $result->execute();
    }
    public static function deleteAndObjectGroupAll($idRegData)
    {
        $db = Db::getConnection();

        $sql = "DELETE FROM `regdata_and_grobject` WHERE `id_regdata` = :idRegData;";
        $result = $db->prepare($sql);
        $result->bindParam(':idRegData', $idRegData, PDO::PARAM_INT);

        return $result->execute();
    }
    public static function getAndObjectGroup($idRegData)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_grobject` FROM `regdata_and_grobject` WHERE `id_regdata` = :idRegData;';
        $result = $db->prepare($sql);
        $result->bindParam(':idRegData', $idRegData, PDO::PARAM_INT);

        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function addRegCertificate($fileTmpName, $fileName)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `regcertificate`(`file_regcertif`, `filename_regcertif`) 
                VALUES (:fileTmpName, :fileName);';
        $result = $db->prepare($sql);
        $result->bindParam(':fileTmpName', $fileTmpName, PDO::PARAM_STR);
        $result->bindParam(':fileName', $fileName, PDO::PARAM_STR);

        if ($result->execute()) {
            return $db->lastInsertId();
        }

        return false;
    }
}