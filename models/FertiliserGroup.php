<?php

class FertiliserGroup
{
    public static function getList()
    {
        $db = Db::getConnection();
        
        $sql = 'SELECT * FROM `fertiliser_group`;';
        $result = $db->prepare($sql);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }
        
        return false;
    }

    public static function get($idFertiliserGroup) {
        $db = Db::getConnection();
        
        $sql = 'SELECT * FROM `fertiliser_group` WHERE `id_grfertiliser` = :id_grfertiliser LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_grfertiliser', $idFertiliserGroup, PDO::PARAM_INT);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result->fetch();
        }
        
        return false;
    }
}