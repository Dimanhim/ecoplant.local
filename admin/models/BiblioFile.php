<?php

class BiblioFile
{
    public static function add($fileName) {
        $db = Db::getConnection();
        
        $sql = 'INSERT INTO `biblio_file`(`biblio_file_name`) VALUES(:biblio_file_name);';
        $result = $db->prepare($sql);
        $result->bindParam(':biblio_file_name', $fileName, PDO::PARAM_STR);
        
        $result->execute();
        return $db->lastInsertId();
    }
}