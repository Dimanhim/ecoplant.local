<?php

class FertiliserClass
{
    public static function getList() {
        $db = Db::getConnection();
        
        $sql = 'SELECT * FROM `fertiliser_class`;';
        $result = $db->prepare($sql);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }
        
        return false;
    }

    public static function getListContainGroup($idFertiliserGroup) {
        $db = Db::getConnection();
        
        $sql = 'SELECT `fertiliser_class`.`id_clfertiliser`, `fertiliser_class`.`name_clfertilizer_rus`
                FROM `fertiliser`, `fertiliser_group`, `fertiliser_and_clfertiliser`, `fertiliser_class`
                WHERE `fertiliser`.`id_grfertiliser` = `fertiliser_group`.`id_grfertiliser`
                AND `fertiliser_and_clfertiliser`.`id_fertiliser` = `fertiliser`.`id_fertiliser`
                AND `fertiliser_and_clfertiliser`.`id_clfertiliser` = `fertiliser_class`.`id_clfertiliser`
                AND `fertiliser_group`.`id_grfertiliser` = :id_grfertiliser
                GROUP BY `fertiliser_class`.`id_clfertiliser`';
        $result = $db->prepare($sql);
        $result->bindParam(':id_grfertiliser', $idFertiliserGroup, PDO::PARAM_INT);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }
        
        return false;
    }

    public static function get($idFertiliserClass) {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `fertiliser_class` WHERE `id_clfertiliser` = :id_clfertiliser LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_clfertiliser', $idFertiliserClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }
}