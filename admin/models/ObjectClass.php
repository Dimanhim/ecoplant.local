<?php

// Класс объекта
class ObjectClass
{
    public static function getListSQL()
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_clobject`, `name_clobject_rus` FROM `object_class`';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}