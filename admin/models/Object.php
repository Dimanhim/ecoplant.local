<?php

class Object {
    const COUNT_MAX_PHOTO = 10;

    public static function getListSQL($orderField = false) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_object`, `rnameobject` FROM `object`';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `rnameobject`;';
        }
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function add($nameObjectRus, $nameObjectEng, $idObjectClass) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `object`(`rnameobject`, `engnameobject`, `id_clobject`) 
                VALUES (:nameObjectRus, :nameObjectEng, :idObjectClass);';
        $result = $db->prepare($sql);
        $result->bindParam(':nameObjectRus', $nameObjectRus, PDO::PARAM_STR);
        $result->bindParam(':nameObjectEng', $nameObjectEng, PDO::PARAM_STR);
        $result->bindParam(':idObjectClass', $idObjectClass, PDO::PARAM_INT);

        return $result->execute();
    }
    public static function getListByIdProductClassSQL($idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_object`, `id_grobject`, `rnameobject` 
                FROM `object` 
                WHERE `id_clobject` = :idProductClass;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getId($nameObjectRus, $nameObjectEng, $idObjectClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_object` 
                FROM `object` 
                WHERE `rnameobject` = :nameObjectRus AND `engnameobject` = :nameObjectEng
                AND `id_clobject` = :idObjectClass
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':nameObjectRus', $nameObjectRus, PDO::PARAM_STR);
        $result->bindParam(':nameObjectEng', $nameObjectEng, PDO::PARAM_STR);
        $result->bindParam(':idObjectClass', $idObjectClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['id_object'];
        }

        return false;
    }

    public static function addAndAlphabetRus($idObject, $idLetterRus) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `object_and_alphabet_rus`(`id_object`, `id_alphabet_rus`) 
                VALUES(:idObject, :idLetterRus);';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':idLetterRus', $idLetterRus, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function addAndCulture($idObject, $idCulture) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `object_and_culture`(`id_object`, `id_culture`) 
                VALUES(:idObject, :idCulture);';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function addAndObjectGroup($idObject, $idObjectGroup) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `object_and_grobject`(`id_object`, `id_grobject`) 
                VALUES(:idObject, :idObjectGroup);';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':idObjectGroup', $idObjectGroup, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function addAndImage($idObject, $fileName) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `object_and_image`(`id_object`, `filename`) 
                VALUES(:idObject, :fileName);';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':fileName', $fileName, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function getAndImage($idObject) {
        $db = Db::getConnection();

        $sql = 'SELECT `id`, `filename`, `desc`, `id_culture`, `show`
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

    public static function getAndImageIdAvatar($idObject, $idCulture = 0) {
        $db = Db::getConnection();

        $sql = 'SELECT `id` 
                FROM `object_and_image` 
                WHERE `id_object` = :idObject';
        if ($idCulture != 0) {
            $sql .= ' AND `id_culture` = :idCulture';
        }
        $sql .= ' AND `is_avatar` = "1";';
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

    public static function updateAndImageAvatar($avatar, $idObject, $idImage = false) {
        $db = Db::getConnection();

        $sql = 'UPDATE `object_and_image` 
                SET `is_avatar` = :avatar 
                WHERE `id_object` = :idObject';
        if ($idImage) {
            $sql .= ' AND `id` = :idImage;';
        }
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        if ($idImage) {
            $result->bindParam(':idImage', $idImage, PDO::PARAM_INT);
        }
        $result->bindParam(':avatar', $avatar, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function updateAndImageAvatarByIdCulture($avatar, $idObject, $idCulture) {
        $db = Db::getConnection();

        $sql = 'UPDATE `object_and_image` 
                SET `is_avatar` = :avatar 
                WHERE `id_object` = :idObject AND `id_culture` = :idCulture';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':avatar', $avatar, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function updateAndImageDesc($idObject, $idImage, $desc) {
        $db = Db::getConnection();

        $sql = 'UPDATE `object_and_image` 
                SET `desc` = :desc
                WHERE `id` = :idImage AND `id_object` = :idObject 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':idImage', $idImage, PDO::PARAM_INT);
        $result->bindParam(':desc', $desc, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function updateAndImageIdCulture($idObject, $idImage, $idCulture) {
        $db = Db::getConnection();

        $sql = 'UPDATE `object_and_image` 
                SET `id_culture` = :idCulture
                WHERE `id` = :idImage AND `id_object` = :idObject 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':idImage', $idImage, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function countAndImage($idObject) {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) as "count" 
                FROM `object_and_image` 
                WHERE `id_object` = :idObject;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['count'];
        }

        return false;
    }

    // Кол-во неопубликованных изображений
    public static function countAndImageNotShow() {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) as "count" 
                FROM `object_and_image` 
                WHERE `show` = "0";';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['count'];
        }

        return false;
    }

    // Список неопубликованных изображений
    public static function getAndImageNotShowList() {
        $db = Db::getConnection();

        $sql = 'SELECT `object_and_image`.`id`, `object_and_image`.`filename`, 
                       `object_and_image_info`.`name`, `object_and_image_info`.`email`,
                       `object`.`id_object`, `object`.`rnameobject`, 
                       `culture`.`id_culture`, `culture`.`name_rus`
                FROM `object_and_image` 
                LEFT JOIN `object_and_image_info` ON `object_and_image_info`.`idObjectAndImage` = `object_and_image`.`id`
                LEFT JOIN `object` ON `object`.`id_object` = `object_and_image`.`id_object`
                LEFT JOIN `culture` ON `culture`.`id_culture` = `object_and_image`.`id_culture`
                WHERE `object_and_image`.`show` = "0";';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    // Получение названия файла изображения
    public static function getFileNameByIdAndImage($idObjectAndImage) {
        $db = Db::getConnection();

        $sql = 'SELECT `filename` 
                FROM `object_and_image` 
                WHERE `id` = :id 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $idObjectAndImage, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['filename'];
        }

        return false;
    }

    public static function publishAndImage($idImage) {
        $db = Db::getConnection();

        $sql = 'UPDATE `object_and_image` 
                SET `show` = "1" 
                WHERE `id` = :id 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id', $idImage, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function getAndImageInfo($idObjectAndImage) {
        $db = Db::getConnection();

        $sql = 'SELECT `name`, `email` 
                FROM `object_and_image_info` 
                WHERE `idObjectAndImage` = :idObjectAndImage 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObjectAndImage', $idObjectAndImage, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function deleteAndImage($idImage, $idObject) {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `object_and_image` 
                WHERE `id` = :idImage AND `id_object` = :idObject 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idImage', $idImage, PDO::PARAM_INT);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function deleteAndImageInfo($idObjectAndImage) {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `object_and_image_info` 
                WHERE `idObjectAndImage` = :idObjectAndImage 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObjectAndImage', $idObjectAndImage, PDO::PARAM_INT);

        return $result->execute();
    }

    public static function getCountMaxPhoto() {
        return Object::COUNT_MAX_PHOTO;
    }

    // *********************
    // Описания объектов
    // *********************

    // Сохранение описания биологии объекта
    public static function saveDescBiology($idObject, $idBiblioLink, $desc) {
        $nameTable = 'object_desc_biology';
        return self::saveDesc($nameTable, $idObject, $idBiblioLink, $desc);
    }
    public static function delDescBiology($idObject) {
        $nameTable = 'object_desc_biology';
        return self::delDesc($nameTable, $idObject);
    }

    // Сохранение описания развития поражения
    public static function saveDescDevelopment($idObject, $idBiblioLink, $desc) {
        $nameTable = 'object_desc_development';
        return self::saveDesc($nameTable, $idObject, $idBiblioLink, $desc);
    }
    public static function delDescDevelopment($idObject) {
        $nameTable = 'object_desc_development';
        return self::delDesc($nameTable, $idObject);
    }

    // Сохранение описания экономического значения
    public static function saveDescSignificance($idObject, $idBiblioLink, $desc) {
        $nameTable = 'object_desc_significance';
        return self::saveDesc($nameTable, $idObject, $idBiblioLink, $desc);
    }
    public static function delDescSignificance($idObject) {
        $nameTable = 'object_desc_significance';
        return self::delDesc($nameTable, $idObject);
    }

    // Сохранение описания симптомов
    public static function saveDescSymptoms($idObject, $idBiblioLink, $desc) {
        $nameTable = 'object_desc_symptoms';
        return self::saveDesc($nameTable, $idObject, $idBiblioLink, $desc);
    }
    public static function delDescSymptoms($idObject) {
        $nameTable = 'object_desc_symptoms';
        return self::delDesc($nameTable, $idObject);
    }

    // Сохранение описания в таблицу описания объекта ($nameDesc - название таблицы в бд)
    public static function saveDesc($nameDesc, $idObject, $idBiblioLink, $desc) {
        return self::addDesc($nameDesc, $idObject, $idBiblioLink, $desc);
    }

    // Добавление описания в таблицу описания объекта ($nameDesc - название таблицы в бд)
    public static function addDesc($nameDesc, $idObject, $idBiblioLink, $desc) {
        $db = Db::getConnection();

        $sql = 'INSERT INTO `' . $nameDesc . '`(`id_object`, `id_biblio_link`, `text_rus`)
                VALUES(:idObject, :idBiblioLink, :desc);';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':idBiblioLink', $idBiblioLink, PDO::PARAM_INT);
        $result->bindParam(':desc', $desc, PDO::PARAM_STR);

        return $result->execute();
    }

    // Обновление описания в таблице описания объекта ($nameDesc - название таблицы в бд)
    public static function updDesc($nameDesc, $idObject, $idBiblioLink, $desc) {
        $db = Db::getConnection();

        $sql = 'UPDATE `' . $nameDesc . '` 
                SET `id_biblio_link` = :idBiblioLink, `text_rus` = :desc
                WHERE `id_object` = :idObject 
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':idBiblioLink', $idBiblioLink, PDO::PARAM_INT);
        $result->bindParam(':desc', $desc, PDO::PARAM_STR);

        return $result->execute();
    }

    // Имеется ли описание в таблице описания объекта ($nameDesc - название таблицы в бд)
    public static function existsDesc($nameDesc, $idObject) {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `' . $nameDesc . '` WHERE `id_object` = :idObject LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return true;
        }

        return false;
    }

    // Удаление имеющихся описаний по названию описания объекта ($nameDesc - название таблицы в бд)
    public static function delDesc($nameDesc, $idObject) {
        $db = Db::getConnection();

        $sql = 'DELETE FROM `' . $nameDesc . '` WHERE `id_object` = :idObject;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);

        return $result->execute();
    }

    // Получение полной информации о описаниях объекта (массив)
    public static function getDescFull($idObject) {
        $descArray = array();

        $descBiology = self::getDescBiology($idObject);
        if ($descBiology) {
            while ($row = $descBiology->fetch()) {
                $descArray['descBiologyText'][] = $row['text_rus'];
                $descArray['descBiologyIdBiblioLink'][] = $row['id_biblio_link'];
            }
        }
        $descDevelopment = self::getDescDevelopment($idObject);
        if ($descDevelopment) {
            while ($row = $descDevelopment->fetch()) {
                $descArray['descDevelopmentText'][] = $row['text_rus'];
                $descArray['descDevelopmentIdBiblioLink'][] = $row['id_biblio_link'];
            }
        }
        $descSignificance = self::getDescSignificance($idObject);
        if ($descSignificance) {
            while ($row = $descSignificance->fetch()) {
                $descArray['descSignificanceText'][] = $row['text_rus'];
                $descArray['descSignificanceIdBiblioLink'][] = $row['id_biblio_link'];
            }
        }
        $descSymptoms = self::getDescSymptoms($idObject);
        if ($descSymptoms) {
            while ($row = $descSymptoms->fetch()) {
                $descArray['descSymptomsText'][] = $row['text_rus'];
                $descArray['descSymptomsIdBiblioLink'][] = $row['id_biblio_link'];
            }
        }

        return $descArray;
    }

    // Получение описания биологии объекта
    public static function getDescBiology($idObject) {
        $nameTable = 'object_desc_biology';
        return self::getDesc($nameTable, $idObject);
    }

    // Получение описания развития поражения
    public static function getDescDevelopment($idObject) {
        $nameTable = 'object_desc_development';
        return self::getDesc($nameTable, $idObject);
    }

    // Получение описания экономического значения
    public static function getDescSignificance($idObject) {
        $nameTable = 'object_desc_significance';
        return self::getDesc($nameTable, $idObject);
    }

    // Получение описания симптомов
    public static function getDescSymptoms($idObject) {
        $nameTable = 'object_desc_symptoms';
        return self::getDesc($nameTable, $idObject);
    }

    // Получение описания из таблицы
    public static function getDesc($nameDesc, $idObject) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_biblio_link`, `text_rus` FROM `' . $nameDesc . '` WHERE `id_object` = :idObject;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}