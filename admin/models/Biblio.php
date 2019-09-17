<?php

class Biblio
{
    public static function getListSQL($orderField = false) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_biblio_collection`, `name_collection` 
                FROM `biblio_collection`';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `name_collection`;';
        }
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListYearSQL() {
        $db = Db::getConnection();

        $sql = 'SELECT `id_year`, `year` FROM `year` 
                WHERE `id_year` > 101 AND `id_year` < 169;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListLinkSQL()
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_biblio_link`, `name_link` FROM `biblio_link`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListVolumeSQL()
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_biblio_volume`, `biblio_volume` FROM `biblio_volume`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListNumberSQL()
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_biblio_number`, `biblio_number` FROM `biblio_number`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }
        return false;
    }
    public static function getListAuthorSQL() {
        $db = Db::getConnection();

        $sql = 'SELECT `id_biblio_author`, `surname`, `firstname_short`, `patronymic_short` FROM `biblio_author`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function add($idBiblioCollection, $idBiblioWork, $idBiblioYear, $idBiblioVolume, $idBiblioNumber, $pages) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `biblio`(`id_biblio_collection`, `id_biblio_work`, `id_year`, `id_biblio_volume`, `id_biblio_number`, `pages`) 
                VALUES (:idBiblioCollection, :idBiblioWork, :idBiblioYear, :idBiblioVolume, :idBiblioNumber, :pages)';
        $result = $db->prepare($sql);
        $result->bindParam(':idBiblioCollection', $idBiblioCollection, PDO::PARAM_INT);
        $result->bindParam(':idBiblioWork', $idBiblioWork, PDO::PARAM_INT);
        $result->bindParam(':idBiblioYear', $idBiblioYear, PDO::PARAM_INT);
        $result->bindParam(':idBiblioVolume', $idBiblioVolume, PDO::PARAM_INT);
        $result->bindParam(':idBiblioNumber', $idBiblioNumber, PDO::PARAM_INT);
        $result->bindParam(':pages', $pages, PDO::PARAM_STR);

        return $result->execute();
    }
    public static function updateLinkByIdBiblioWork($idBiblioWork, $idBiblioLink) {
        $db = Db::getConnection();

        $sql = 'UPDATE `biblio` 
                SET `id_biblio_link` = :idBiblioLink 
                WHERE `id_biblio_work` = :idBiblioWork 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idBiblioWork', $idBiblioWork, PDO::PARAM_INT);
        $result->bindParam(':idBiblioLink', $idBiblioLink, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function addCollection($nameCollectionRus, $nameCollectionEng, $namePublishHouseRus, $namePublishHouseEng) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `biblio_collection`(`name_collection`, `name_collection_eng`, `name_publish_house`, `name_publish_house_eng`) 
                VALUES(:nameCollectionRus, :nameCollectionEng, :namePublishHouseRus, :namePublishHouseEng);';
        $result = $db->prepare($sql);
        $result->bindParam(':nameCollectionRus', $nameCollectionRus, PDO::PARAM_STR);
        $result->bindParam(':nameCollectionEng', $nameCollectionEng, PDO::PARAM_STR);
        $result->bindParam(':namePublishHouseRus', $namePublishHouseRus, PDO::PARAM_STR);
        $result->bindParam(':namePublishHouseEng', $namePublishHouseEng, PDO::PARAM_STR);

        return $result->execute();
    }
    
    public static function addWork($nameRus, $nameEng) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `biblio_work`(`name_work`, `name_work_eng`) VALUES(:nameRus, :nameEng);';
        $result = $db->prepare($sql);
        $result->bindParam(':nameRus', $nameRus, PDO::PARAM_STR);
        $result->bindParam(':nameEng', $nameEng, PDO::PARAM_STR);

        return $result->execute();
    }
    public static function getWorkId($nameRus, $nameEng)
    {
        $db = Db::getConnection();
        
        $sql = 'SELECT `id_biblio_work` 
                FROM `biblio_work` 
                WHERE `name_work` = :nameRus AND `name_work_eng` = :nameEng 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':nameRus', $nameRus, PDO::PARAM_INT);
        $result->bindParam(':nameEng', $nameEng, PDO::PARAM_INT);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result->fetch()['id_biblio_work'];
        }

        return false;
    }

    public static function addAuthor($surname, $surnameEng, $firstnameShort, $firstnameShortEng, $patronymicShort, $patronymicShortEng) {
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO `biblio_author`(`surname`, `surname_eng`, `firstname_short`, 
                                            `firstname_short_eng`, `patronymic_short`, `patronymic_short_eng`) 
                VALUES(:surname, :surnameEng, :firstnameShort, 
                       :firstnameShortEng, :patronymicShort, :patronymicShortEng);';
        $result = $db->prepare($sql);
        $result->bindParam(':surname', $surname, PDO::PARAM_STR);
        $result->bindParam(':surnameEng', $surnameEng, PDO::PARAM_STR);
        $result->bindParam(':firstnameShort', $firstnameShort, PDO::PARAM_STR);
        $result->bindParam(':firstnameShortEng', $firstnameShortEng, PDO::PARAM_STR);
        $result->bindParam(':patronymicShort', $patronymicShort, PDO::PARAM_STR);
        $result->bindParam(':patronymicShortEng', $patronymicShortEng, PDO::PARAM_STR);

        return $result->execute();
    }
    public static function addAuthorToWork($idBiblioWork, $idBiblioAuthor) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `biblio_authorwork`(`id_biblio_author`, `id_biblio_work`) 
                VALUES(:idBiblioAuthor, :idBiblioWork);';
        $result = $db->prepare($sql);
        $result->bindParam(':idBiblioAuthor', $idBiblioAuthor, PDO::PARAM_INT);
        $result->bindParam(':idBiblioWork', $idBiblioWork, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function addLink($nameLinkRus, $nameLinkEng, $elink = false, $idBiblioFile = false) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `biblio_link`(`name_link`, `name_link_eng`, `elink`, `id_biblio_file`) 
                VALUES(:nameLinkRus, :nameLinkEng, :elink, :idBiblioFile);';
        $result = $db->prepare($sql);
        $result->bindParam(':nameLinkRus', $nameLinkRus, PDO::PARAM_STR);
        $result->bindParam(':nameLinkEng', $nameLinkEng, PDO::PARAM_STR);
        $result->bindParam(':elink', $elink, PDO::PARAM_STR);
        $result->bindParam(':idBiblioFile', $idBiblioFile, PDO::PARAM_INT);

        return $result->execute();
    }
    public static function getLinkId($nameLinkRus, $nameLinkEng) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_biblio_link` 
                FROM `biblio_link` 
                WHERE `name_link` = :nameLinkRus AND `name_link_eng` = :nameLinkEng 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':nameLinkRus', $nameLinkRus, PDO::PARAM_STR);
        $result->bindParam(':nameLinkEng', $nameLinkEng, PDO::PARAM_STR);

        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['id_biblio_link'];
        }
        return false;
    }
}