<?php

class Species
{
    public static function getListSQL($orderField = false)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_species`, `name_lat` FROM `species`';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `name_lat`;';
        }
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListWithoutSynonymSQL($orderField = false)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_species`, `name_lat` FROM `species` WHERE `id_synonym` = "0"';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `name_lat`;';
        }
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function add($nameSpeciesLat, $idLetter, $actuality, $idSynonym) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `species`(`name_lat`, `id_alphabet_lat`, `actuality`, `id_synonym`) 
                VALUES (:nameSpeciesLat, :idLetter, :actuality, :idSynonym);';
        $result = $db->prepare($sql);
        $result->bindParam(':nameSpeciesLat', $nameSpeciesLat, PDO::PARAM_STR);
        $result->bindParam(':idLetter', $idLetter, PDO::PARAM_INT);
        $result->bindParam(':actuality', $actuality, PDO::PARAM_INT);
        $result->bindParam(':idSynonym', $idSynonym, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function getId($nameSpeciesLat, $idLetter, $actuality, $idSynonym) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_species` 
                FROM `species`
                WHERE `name_lat` = :nameSpeciesLat AND `id_alphabet_lat` = :idLetter 
                AND `actuality` = :actuality AND `id_synonym` = :idSynonym
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':nameSpeciesLat', $nameSpeciesLat, PDO::PARAM_STR);
        $result->bindParam(':idLetter', $idLetter, PDO::PARAM_INT);
        $result->bindParam(':actuality', $actuality, PDO::PARAM_INT);
        $result->bindParam(':idSynonym', $idSynonym, PDO::PARAM_INT);

        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['id_species'];
        }

        return false;
    }

    public static function addAndObject($idSpecies, $idObject) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `species_and_object` (`id_species`, `id_object`)
                VALUES (:idSpecies, :idObject);';
        $result = $db->prepare($sql);
        $result->bindParam(':idSpecies', $idSpecies, PDO::PARAM_INT);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);

        return $result->execute();
    }
}