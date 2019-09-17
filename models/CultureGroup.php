<?php

class CultureGroup {
    /**
     * Старая функция, выполняющая вывод групп культур
     * @param $idCultureClass
     * @param $idProductClass
     * @return bool|PDOStatement
     */
    public static function getListByIdCultureClassAndIdProductClass($idCultureClass, $idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `culture`.`id_culture_group`, `name_culture_group_rus` 
                  FROM `culture` 
                  JOIN `culture_class` JOIN `culture_group`
                  JOIN `product_and_culture` JOIN `product`
                  ON `culture`.`id_culture_group` = `culture_group`.`id_culture_group` 
                  AND `culture`.`id_culture_class` = `culture_class`.`id_culture_class` 
                  AND `culture`.`id_culture` = `product_and_culture`.`id_culture` 
                  AND `product_and_culture`.`id_product` = `product`.`id_product` 
                  WHERE `culture_class`.`id_culture_class` = :idCultureClass
                  AND `product`.`id_clproduct` = :idProductClass
                  GROUP BY `culture_group`.`id_culture_group`
                  ORDER BY `culture_group`.`page_position`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idCultureClass', $idCultureClass, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    /**
     * Новая функция, выполняющая вывод групп культур согласно регистрационным данным
     * добавленным в новой форме админ-панели
     * @param $idCultureClass
     * @param $idProductClass
     * @return bool|PDOStatement
     */
    public static function getListByIdCultureClassAndIdProductClassContainRegData($idCultureClass, $idProductClass)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `culture_group`.`id_culture_group`, `culture_group`.`name_culture_group_rus`
                FROM `regdata`
                JOIN `product_and_regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `culture` ON `culture`.`id_culture` = `regdata`.`id_culture`
                JOIN `culture_group` ON `culture_group`.`id_culture_group` = `culture`.`id_culture_group`
                JOIN `product` ON `product`.`id_product` = `product_and_regdata`.`id_product`
                WHERE `product`.`id_clproduct` = :idProductClass AND `culture`.`id_culture_class` = :idCultureClass
                GROUP BY `culture_group`.`id_culture_group`';
        $result = $db->prepare($sql);
        $result->bindParam(':idCultureClass', $idCultureClass, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    /**
     * Функция объединяющая вывод старой и новой функции
     * @param $idCultureClass
     * @param $idProductClass
     * @return bool|PDOStatement
     */
    public static function getListByIdCultureClassAndIdProductClassMerged($idCultureClass, $idProductClass) {
        $db = Db::getConnection();

        $sql = '(SELECT `culture`.`id_culture_group`, `name_culture_group_rus` 
                  FROM `culture` 
                  JOIN `culture_class` JOIN `culture_group`
                  JOIN `product_and_culture` JOIN `product`
                  ON `culture`.`id_culture_group` = `culture_group`.`id_culture_group` 
                  AND `culture`.`id_culture_class` = `culture_class`.`id_culture_class` 
                  AND `culture`.`id_culture` = `product_and_culture`.`id_culture` 
                  AND `product_and_culture`.`id_product` = `product`.`id_product` 
                  WHERE `culture_class`.`id_culture_class` = :idCultureClass AND `product`.`id_clproduct` = :idProductClass
                  GROUP BY `culture_group`.`id_culture_group`
                  ORDER BY `culture_group`.`page_position`)
                  UNION
                  (SELECT `culture_group`.`id_culture_group`, `culture_group`.`name_culture_group_rus`
                FROM `regdata`
                JOIN `product_and_regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `culture` ON `culture`.`id_culture` = `regdata`.`id_culture`
                JOIN `culture_group` ON `culture_group`.`id_culture_group` = `culture`.`id_culture_group`
                JOIN `product` ON `product`.`id_product` = `product_and_regdata`.`id_product`
                WHERE `product`.`id_clproduct` = :idProductClass AND `culture`.`id_culture_class` = :idCultureClass
                GROUP BY `culture_group`.`id_culture_group`)';
        $result = $db->prepare($sql);
        $result->bindParam(':idCultureClass', $idCultureClass, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}