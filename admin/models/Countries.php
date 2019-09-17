<?php

class Countries
{
    public static function getList()
    {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `countries`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}