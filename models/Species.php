<?php

class Species
{
    public static function getListByIdObjectSQL($idObject)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `species`.`id_species`, `species`.`name_lat` 
                FROM `species`, `species_and_object` 
                WHERE `species`.`id_species` = `species_and_object`.`id_species` 
                AND `species_and_object`.`id_object` = :idObject;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getById($idSpecies)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `name_lat` 
                FROM `species` 
                WHERE `id_species` = :idSpecies 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idSpecies', $idSpecies, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getListSynonymByIdSpecies($idSpecies)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_species`, `name_lat` 
                FROM `species` 
                WHERE `id_synonym` = :idSpecies;';
        $result = $db->prepare($sql);
        $result->bindParam(':idSpecies', $idSpecies, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}