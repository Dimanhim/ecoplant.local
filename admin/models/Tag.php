<?php

class Tag {
    public static function getListByIdImageSQL($idImage) {
        $db = Db::getConnection();

        $sql = 'SELECT `text` FROM `tag` WHERE `id_image` = :idImage;';
        $result = $db->prepare($sql);
        $result->bindParam(':idImage', $idImage, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListForSelectSQL()
    {
        $db = Db::getConnection();

        $sql = 'SELECT `text` FROM `tag` GROUP BY `text` ORDER BY text;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function add($idImage, $text)
    {
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO `tag`(`id_image`, `text`) VALUES(:idImage, :text);';
        $result = $db->prepare($sql);
        $result->bindParam(':idImage', $idImage, PDO::PARAM_INT);
        $result->bindParam(':text', $text, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function deleteByIdImage($idImage)
    {
        $db = Db::getConnection();
        
        $sql = 'DELETE FROM `tag` WHERE `id_image` = :idImage;';
        $result = $db->prepare($sql);
        $result->bindParam(':idImage', $idImage, PDO::PARAM_INT);

        return $result->execute();
    }
}