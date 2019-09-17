<?php

class FertiliserGroup
{
    public static function getList()
    {
        $db = Db::getConnection();
        
        $sql = 'SELECT * FROM `fertiliser_group`;';
        $result = $db->prepare($sql);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }
        
        return false;
    }
}