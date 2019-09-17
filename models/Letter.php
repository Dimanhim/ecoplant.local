<?php

// Алфавиты
class Letter
{
    public static function getFirstLetterObjectListSQL() {
        $db = Db::getConnection();

        $sql = 'SELECT `alphabet_rus`.`id_alphabet_rus`, `alphabet_rus`.`letter` 
                  FROM `object`, `object_and_alphabet_rus`, `alphabet_rus` 
                  WHERE `object`.`id_object` = `object_and_alphabet_rus`.`id_object` AND `alphabet_rus`.`id_alphabet_rus` = `object_and_alphabet_rus`.`id_alphabet_rus` 
                  GROUP BY `alphabet_rus`.`id_alphabet_rus`';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getFirstLetterProductByIdProductClassListSQL($idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `alphabet_rus`.`id_alphabet_rus`, `alphabet_rus`.`letter`
                  FROM `product`
                  JOIN `alphabet_rus` ON `product`.`id_alphabet_rus` = `alphabet_rus`.`id_alphabet_rus` 
                  WHERE `product`.`id_clproduct` = :idProductClass
                  GROUP BY `alphabet_rus`.`id_alphabet_rus`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getRusById($idAlphabet)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `letter` 
                FROM `alphabet_rus` 
                WHERE id_alphabet_rus = :idAlphabet
                LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idAlphabet', $idAlphabet, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }
}