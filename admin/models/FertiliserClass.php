<?php

class FertiliserClass
{
    public static function getList()
    {
        $db = Db::getConnection();
        
        $sql = 'SELECT * FROM `fertiliser_class`;';
        $result = $db->prepare($sql);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }
        
        return false;
    }

    // Получаем список классов установленных для удобрения
    public static function getListByIdFertiliser($idFertiliser) {
        $db = Db::getConnection();

        $sql = 'SELECT `fertiliser_class`.`id_clfertiliser`, `fertiliser_class`.`name_clfertilizer_rus` 
                FROM `fertiliser`, `fertiliser_and_clfertiliser`, `fertiliser_class`
                WHERE `fertiliser`.`id_fertiliser` = `fertiliser_and_clfertiliser`.`id_fertiliser`
                AND `fertiliser_and_clfertiliser`.`id_clfertiliser` = `fertiliser_class`.`id_clfertiliser`
                AND `fertiliser`.`id_fertiliser` = :id_fertiliser;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}