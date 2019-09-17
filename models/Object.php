<?php

class Object
{
    const COUNT_MAX_PHOTO = 10;

    public static function getCount() {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) as "count" FROM `object`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['count'];
        }

        return false;
    }
    public static function getCountByIdObjectClass($idObjectClass) {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) as "count" FROM `object` WHERE `id_clobject` = :idObjectClass;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObjectClass', $idObjectClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['count'];
        }

        return false;
    }

    public static function getListByIdAlphabetSQL($idAlphabet) {
        $db = Db::getConnection();

        $sql = 'SELECT `object`.`id_object`, `object`.`rnameobject` 
               FROM `object`, `object_and_alphabet_rus`, `alphabet_rus` 
               WHERE `object`.`id_object` = `object_and_alphabet_rus`.`id_object` 
               AND `alphabet_rus`.`id_alphabet_rus` = `object_and_alphabet_rus`.`id_alphabet_rus` 
               AND `alphabet_rus`.`id_alphabet_rus` = :idAlphabet;';
        $result = $db->prepare($sql);
        $result->bindParam(':idAlphabet', $idAlphabet, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdCultureAndIdObjectClassSQL($idCulture, $idObject) {
        $db = Db::getConnection();
        
        $sql = 'SELECT `object`.`id_object`, `object`.`rnameobject` 
                   FROM `object`, `object_and_culture`, `culture`, `culture_group` 
                   WHERE `object`.`id_object` = `object_and_culture`.`id_object` 
                   AND `object_and_culture`.`id_culture` = `culture`.`id_culture` 
                   AND `culture`.`id_culture_group` = `culture_group`.`id_culture_group` 
                   AND `culture`.`id_culture` = :idCulture AND `object`.`id_clobject` = :idObject
                   AND `object`.`rnameobject` != ""';
        $result = $db->prepare($sql);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }
        
        return false;
    }

    public static function getListByIdCultureWithoutCultureGroupSQL($idCulture) {
        $db = Db::getConnection();

        $sql = 'SELECT `object`.`id_object`, `object`.`rnameobject`
                  FROM `object`, `object_and_culture`, `culture` 
                  WHERE `object`.`id_object` = `object_and_culture`.`id_object` 
                  AND `object_and_culture`.`id_culture` = `culture`.`id_culture` 
                  AND `object_and_culture`.`id_culture` = :idCulture 
                  AND `culture`.`id_culture_group` = "0";';
        $result = $db->prepare($sql);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getById($idObject) {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `object` WHERE `id_object` = :idObject LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getCountAndImage($idObject, $idCulture = 0)
    {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) as "count" 
                FROM `object_and_image` 
                WHERE `id_object` = :idObject AND `show` = "1"';
        if ($idCulture != 0) {
            $sql .= ' AND `id_culture` = :idCulture;';
        }
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        if ($idCulture != 0) {
            $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        }
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['count'];
        }

        return false;
    }
    public static function getAndImage($idObject) {
        $db = Db::getConnection();

        $sql = 'SELECT `id`, `filename`, `desc`
                FROM `object_and_image` 
                WHERE `id_object` = :idObject 
                LIMIT ' . Object::COUNT_MAX_PHOTO . ';';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getAndImageByIdCulture($idObject, $idCulture) {
        $db = Db::getConnection();

        $sql = 'SELECT `id`, `filename`, `desc`
                FROM `object_and_image` 
                WHERE `id_object` = :idObject AND `show` = "1"';
        if ($idCulture != 0) {
            $sql .= ' AND `id_culture` = :idCulture';
        }
        $sql .= ' LIMIT ' . Object::COUNT_MAX_PHOTO . ';';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        if ($idCulture != 0) {
            $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        }
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    // Получение аватара объекта не зависимо от культуры
    public static function getAndImageAvatar($idObject)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id`, `filename`, `desc` 
                FROM `object_and_image` 
                WHERE `id_object` = :idObject AND `is_avatar` = "1";';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }
    // Получение аватара объекта в конкретной культуре
    public static function getAndImageAvatarByIdCulture($idObject, $idCulture)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id`, `filename`, `desc` 
                FROM `object_and_image` 
                WHERE `id_object` = :idObject AND `show` = "1"';
        if ($idCulture != 0) {
            $sql .= ' AND `id_culture` = :idCulture';
        }
        $sql .= ' AND `is_avatar` = "1" LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        if ($idCulture != 0) {
            $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        }
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getDescBiology($idObject)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `text_rus`, `biblio_link`.`name_link`, `biblio_file`.`biblio_file_name`
                   FROM `object_desc_biology` 
                   LEFT JOIN `biblio_link` ON `biblio_link`.`id_biblio_link` = `object_desc_biology`.`id_biblio_link`
                   LEFT JOIN `biblio_file` ON `biblio_file`.`id_biblio_file` = `biblio_link`.`id_biblio_file`
                   WHERE `object_desc_biology`.`id_object` = :idObject;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getDescDevelop($idObject)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `text_rus`, `biblio_link`.`name_link`, `biblio_file`.`biblio_file_name` 
                   FROM `object_desc_development` 
                   LEFT JOIN `biblio_link` ON `biblio_link`.`id_biblio_link` = `object_desc_development`.`id_biblio_link`
                   LEFT JOIN `biblio_file` ON `biblio_file`.`id_biblio_file` = `biblio_link`.`id_biblio_file`
                   WHERE `object_desc_development`.`id_object` = :idObject;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getDescSignif($idObject) {
        $db = Db::getConnection();

        $sql = 'SELECT `text_rus`, `biblio_link`.`name_link`, `biblio_file`.`biblio_file_name` 
                   FROM `object_desc_significance` 
                   LEFT JOIN `biblio_link` ON `biblio_link`.`id_biblio_link` = `object_desc_significance`.`id_biblio_link`
                   LEFT JOIN `biblio_file` ON `biblio_file`.`id_biblio_file` = `biblio_link`.`id_biblio_file`
                   WHERE `object_desc_significance`.`id_object` = :idObject;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getDescSymptoms($idObject)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `text_rus`, `biblio_link`.`name_link`, `biblio_file`.`biblio_file_name` 
                   FROM `object_desc_symptoms` 
                   LEFT JOIN `biblio_link` ON `biblio_link`.`id_biblio_link` = `object_desc_symptoms`.`id_biblio_link`
                   LEFT JOIN `biblio_file` ON `biblio_file`.`id_biblio_file` = `biblio_link`.`id_biblio_file`
                   WHERE `object_desc_symptoms`.`id_object` = :idObject;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getObjectClassListByIdCulture($idCulture) {
        $db = Db::getConnection();

        $sql = 'SELECT `object`.`id_clobject`, `object_class`.`name_clobject_rus`
                   FROM `object`, `object_and_culture`, `culture`, `culture_group`, `object_class`
                   WHERE `object`.`id_object` = `object_and_culture`.`id_object` 
                   AND `object_and_culture`.`id_culture` = `culture`.`id_culture` 
                   AND `culture`.`id_culture_group` = `culture_group`.`id_culture_group` 
                   AND `culture`.`id_culture` = :idCulture
                   AND `object`.`rnameobject` != "" AND `object`.`id_clobject` = `object_class`.`id_clobject`
                   GROUP BY `object`.`id_clobject`';
        $result = $db->prepare($sql);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function addAndImage($idObject, $idCulture, $fileName, $show = 1) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `object_and_image`(`id_object`, `filename`, `id_culture`, `show`) 
                VALUES(:idObject, :fileName, :idCulture, :show);';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':fileName', $fileName, PDO::PARAM_STR);
        $result->bindParam(':show', $show, PDO::PARAM_INT);

        $result->execute();
        return $db->lastInsertId();
    }

    public static function addAndImageInfo($idObjectAndImage, $name, $email) {
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO `object_and_image_info`(`idObjectAndImage`, `name`, `email`) 
                VALUES(:idObjectAndImage, :name, :email);';
        $result = $db->prepare($sql);
        $result->bindParam(':idObjectAndImage', $idObjectAndImage, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':email', $email, PDO::PARAM_STR);
        
        return $result->execute();
    }
}