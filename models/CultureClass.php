<?php

class CultureClass {
    /**
     * Старая функция, осуществляемая возвращение классов культур продуктов,
     * для которых внесены регистрационные данные ранее на сайт, до новой формы в админ панели
     * @param $idProductClass - Класс продукта (напр. Протравители)
     * @return bool|PDOStatement
     */
    public static function getListByIdProductClassSQL($idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `culture_class`.`id_culture_class`, `name_culture_class_rus` 
                  FROM `culture_class` 
                  JOIN `culture` JOIN `product_and_culture`
                  JOIN `product` ON `culture`.`id_culture_class` = `culture_class`.`id_culture_class` 
                  AND `culture`.`id_culture` = `product_and_culture`.`id_culture` AND `product_and_culture`.`id_product` = `product`.`id_product` 
                  WHERE `product`.`id_clproduct` = :idProductClass
                  GROUP BY `culture_class`.`id_culture_class`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    /**
     * Новая функция, осуществляемая возвращение классов культур продуктов,
     * для которых внесены регистрационные данные через новую форму админ панели
     * @param $idProductClass - Класс продукта (напр. Протравители)
     * @return bool|PDOStatement
     */
    public static function getListByIdProductClassContainRegDataSQL($idProductClass)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `culture_class`.`id_culture_class`, `culture_class`.`name_culture_class_rus`
                FROM `regdata`
                JOIN `product_and_regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `culture` ON `culture`.`id_culture` = `regdata`.`id_culture`
                JOIN `culture_class` ON `culture_class`.`id_culture_class` = `culture`.`id_culture_class`
                JOIN `product` ON `product`.`id_product` = `product_and_regdata`.`id_product`
                WHERE `product`.`id_clproduct` = :idProductClass
                GROUP BY `culture_class`.`id_culture_class`';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    /**
     * Функция, объединяющая вывод старой и новой функции возвращения классов культур продуктов,
     * для которых внесены регистрационные данные через новую форму админ панели
     * @param $idProductClass - Класс продукта (напр. Протравители)
     * @return bool|PDOStatement
     */
    public static function getListByIdProductClassMerged($idProductClass) {
        $db = Db::getConnection();

        $sql = '(SELECT `culture_class`.`id_culture_class`, `name_culture_class_rus` 
                  FROM `culture_class` 
                  JOIN `culture` JOIN `product_and_culture`
                  JOIN `product` ON `culture`.`id_culture_class` = `culture_class`.`id_culture_class` 
                  AND `culture`.`id_culture` = `product_and_culture`.`id_culture` AND `product_and_culture`.`id_product` = `product`.`id_product` 
                  WHERE `product`.`id_clproduct` = :idProductClass
                  GROUP BY `culture_class`.`id_culture_class`)
                UNION
                (SELECT `culture_class`.`id_culture_class`, `culture_class`.`name_culture_class_rus`
                FROM `regdata`
                JOIN `product_and_regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `culture` ON `culture`.`id_culture` = `regdata`.`id_culture`
                JOIN `culture_class` ON `culture_class`.`id_culture_class` = `culture`.`id_culture_class`
                JOIN `product` ON `product`.`id_product` = `product_and_regdata`.`id_product`
                WHERE `product`.`id_clproduct` = :idProductClass
                GROUP BY `culture_class`.`id_culture_class`)';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListContainObject()
    {
        $db = Db::getConnection();

        $sql = 'SELECT `culture_class`.`id_culture_class`, `name_culture_class_rus`
                FROM `object`, `object_and_culture`, `culture`, `culture_class`
                WHERE `object`.`id_object` = `object_and_culture`.`id_object` AND 
                      `object_and_culture`.`id_culture` = `culture`.`id_culture` AND
                      `culture`.`id_culture_class` = `culture_class`.`id_culture_class`
                GROUP BY `culture_class`.`id_culture_class`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}