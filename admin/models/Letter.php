<?php

// Алфавиты
class Letter
{
    public static function getRusListSQL()
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_alphabet_rus`, `letter` FROM `alphabet_rus`';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getLatListSQL()
    {
        $db = Db::getConnection();
        
        $sql = 'SELECT `id_alphabet_lat`, `letter` FROM `alphabet_lat`;';
        $result = $db->prepare($sql);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}