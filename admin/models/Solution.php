<?php

// Препаративные формы
class Solution
{
    public static function getListSQL()
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_product_solution`, `short_name_product_solution` FROM `product_solution`';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function add($name, $shortName)
    {
        $db = Db::getConnection();

        $sql = "INSERT INTO `product_solution`(`name_product_solution`, `short_name_product_solution`)
                VALUES(:name, :shortName)";
        $result = $db->prepare($sql);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
        $result->bindParam(':shortName', $shortName, PDO::PARAM_STR);

        return $result->execute();
    }

    public static function delete($idSolution)
    {
        $db = Db::getConnection();

        $sql = "DELETE FROM `product_solution` WHERE `id_product_solution` = :idSolution LIMIT 1;";
        $result = $db->prepare($sql);
        $result->bindParam(':idSolution', $idSolution, PDO::PARAM_INT);

        return $result->execute();
    }
}