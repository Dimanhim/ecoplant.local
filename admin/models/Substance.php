<?php

class Substance
{
    public static function getListSQL($orderField = false)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_substance`, `name_rus` 
                FROM `substance`';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `name_rus`;';
        }
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getUnitListSQL($orderField = false)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_substance_unit`, `name_substance_unit_rus` 
                FROM `substance_unit`';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `name_substance_unit_rus`;';
        }
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getNameById($idSubstance)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `name_rus` FROM `substance` WHERE `id_substance` = :idSubstance LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idSubstance', $idSubstance, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['name_rus'];
        }

        return false;
    }

    public static function add($nameSubstance)
    {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `substance`(`name_rus`) VALUES(:nameSubstance);';
        $result = $db->prepare($sql);
        $result->bindParam(':nameSubstance', $nameSubstance, PDO::PARAM_STR);

        return $result->execute();
    }
}