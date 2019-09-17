<?php

class Importer
{
    public static function getListSQL($orderField = false)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_importer`, `short_name` 
                FROM `importer`';
        if ($orderField == 'name') {
            $sql .= ' ORDER BY `short_name`;';
        }
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}