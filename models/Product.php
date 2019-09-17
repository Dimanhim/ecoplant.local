<?php

// Препараты
class Product
{
    public static function getCount() {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) as "count" FROM `product`;';
        $result = $db->prepare($sql);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['count'];
        }

        return false;
    }
    public static function getCountByIdProductClass($idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT COUNT(*) as "count" FROM `product` WHERE `id_clproduct` = :idProductClass;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch()['count'];
        }

        return false;
    }

    public static function getListByIdObject($idObject) {
        $db = Db::getConnection();

        $sql = 'SELECT `product`.`id_product`, `product`.`name_product_rus`,
                       `manufacture`.`id_manufacture`, `manufacture`.`name_manufacture_rus`,
                       `regdata`.`min_rate`, `regdata`.`max_rate`
                FROM `product`, `regdata`, `product_and_regdata`, `regdata_and_grobject`, `object_and_grobject`, `manufacture`
                WHERE `product`.`id_manufacture` = `manufacture`.`id_manufacture` AND 
                      `product`.`id_product` = `product_and_regdata`.`id_product` AND `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata` AND
                      `regdata_and_grobject`.`id_regdata` = `regdata`.`id_regdata` AND 
                      `regdata_and_grobject`.`id_grobject` = `object_and_grobject`.`id_grobject` AND 
                      `object_and_grobject`.`id_object` = :idObject;';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }


    /**
     * Старая функция вывода продуктов по букве алфавита и класс продукта
     * @param $idAlphabet
     * @param $idProductClass
     * @return bool|PDOStatement
     */
    public static function getListByIdAlphabetAndProductClass($idAlphabet, $idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `product`.`id_product`, `product`.`name_product_rus`, `manufacture` .`name_manufacture_rus`, 
                  GROUP_CONCAT(DISTINCT `culture`.`name_rus` ORDER BY `culture`.`name_rus` ASC SEPARATOR ", ") AS "nameculture" 
                  FROM `product` 
                  JOIN `manufacture`  JOIN `product_and_culture` JOIN `culture`
                  ON `product`.`id_manufacture` = `manufacture` .`id_manufacture`
                  AND `product`.`id_product` = `product_and_culture`.`id_product`
                  AND `product_and_culture`.`id_culture` = `culture`.`id_culture`
                  WHERE `product`.`id_alphabet_rus` = :idAlphabet
                  AND `product`.`id_clproduct` = :idProductClass
                  GROUP BY `product`.`id_product`
                  ORDER BY `product`.`name_product_rus`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idAlphabet', $idAlphabet, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    /**
     * Новая функция вывода продуктов по букве алфавита и класс продукта
     * @param $idAlphabet
     * @param $idProductClass
     * @return bool|PDOStatement
     */
    public static function getListByIdAlphabetAndProductClassContainRegData($idAlphabet, $idProductClass)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `product`.`id_product`, `product`.`name_product_rus`, `manufacture` .`name_manufacture_rus`,
                GROUP_CONCAT(DISTINCT `culture`.`name_rus` ORDER BY `culture`.`name_rus` ASC SEPARATOR ", ") AS "nameculture"
                FROM `regdata`
                JOIN `product_and_regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `culture` ON `culture`.`id_culture` = `regdata`.`id_culture`
                JOIN `product` ON `product`.`id_product` = `product_and_regdata`.`id_product`
                JOIN `manufacture` ON `manufacture`.`id_manufacture` = `product`.`id_manufacture`
                WHERE `product`.`id_alphabet_rus` = :idAlphabet AND `product`.`id_clproduct` = :idProductClass
                GROUP BY `product`.`id_product`';
        $result = $db->prepare($sql);
        $result->bindParam(':idAlphabet', $idAlphabet, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    /**
     * Функция объединяющая вывод старой и новой функции
     * @param $idAlphabet
     * @param $idProductClass
     * @return bool|PDOStatement
     */
    public static function getListByIdAlphabetAndProductClassMerged($idAlphabet, $idProductClass)
    {
        $db = Db::getConnection();

        $sql = '(SELECT `product`.`id_product`, `product`.`name_product_rus`, `manufacture` .`name_manufacture_rus`, 
                  GROUP_CONCAT(DISTINCT `culture`.`name_rus` ORDER BY `culture`.`name_rus` ASC SEPARATOR ", ") AS "nameculture" 
                  FROM `product` 
                  JOIN `manufacture`  JOIN `product_and_culture` JOIN `culture`
                  ON `product`.`id_manufacture` = `manufacture` .`id_manufacture`
                  AND `product`.`id_product` = `product_and_culture`.`id_product`
                  AND `product_and_culture`.`id_culture` = `culture`.`id_culture`
                  WHERE `product`.`id_alphabet_rus` = :idAlphabet
                  AND `product`.`id_clproduct` = :idProductClass
                  GROUP BY `product`.`id_product`
                  ORDER BY `product`.`name_product_rus`)
                  UNION
                  (SELECT `product`.`id_product`, `product`.`name_product_rus`, `manufacture` .`name_manufacture_rus`,
                GROUP_CONCAT(DISTINCT `culture`.`name_rus` ORDER BY `culture`.`name_rus` ASC SEPARATOR ", ") AS "nameculture"
                FROM `regdata`
                JOIN `product_and_regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `culture` ON `culture`.`id_culture` = `regdata`.`id_culture`
                JOIN `product` ON `product`.`id_product` = `product_and_regdata`.`id_product`
                JOIN `manufacture` ON `manufacture`.`id_manufacture` = `product`.`id_manufacture`
                WHERE `product`.`id_alphabet_rus` = :idAlphabet AND `product`.`id_clproduct` = :idProductClass
                GROUP BY `product`.`id_product`)';
        $result = $db->prepare($sql);
        $result->bindParam(':idAlphabet', $idAlphabet, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);

        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdCultureAndProductClassWithRegData($idCulture, $idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `product`.`id_product`, MAX(`regdata`.`min_rate`) as "min_rate", MAX(`regdata`.`max_rate`) as "max_rate", `product`.`name_product_rus`, `manufacture`.`name_manufacture_rus`, GROUP_CONCAT(DISTINCT `modeaction`.`short_name_modeaction` ORDER BY `modeaction` .`short_name_modeaction` ASC SEPARATOR "+") AS "namemod"
                FROM `regdata`
                JOIN `product_and_regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `product` ON `product`.`id_product` = `product_and_regdata`.`id_product`
                JOIN `manufacture` ON `manufacture`.`id_manufacture` = `product`.`id_manufacture`
                
                JOIN `product_and_substance` ON `product_and_substance`.`id_product` = `product`.`id_product`
                JOIN `substance` ON `substance`.`id_substance` = `product_and_substance`.`id_substance`
                JOIN `substance_and_modeaction` ON `substance_and_modeaction`.`id_substance` = `substance`.`id_substance`
                JOIN `modeaction` ON `modeaction`.`id_modeaction` = `substance_and_modeaction`.`id_modeaction`
                
                WHERE `product`.`id_clproduct` = :idProductClass AND `regdata`.`id_culture` = :idCulture
                GROUP BY `product` .`id_product` ORDER BY namemod, `product`.`name_product_rus`';
        $result = $db->prepare($sql);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    /**
     * Старая функция
     * @param $idCulture
     * @param $idProduct
     * @return bool|mixed
     */
    public static function getListAndCultureSQL($idCulture, $idProduct) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_product`, `min_rate`, `max_rate`
                  FROM product_and_culture 
                  WHERE id_culture = :idCulture AND id_product = :idProduct;';
        $result = $db->prepare($sql);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    /**
     * Новая функция, учитывая регистрационные данные добавленные через форму в админ-панели
     * @param $idCulture
     * @param $idProduct
     * @return bool|PDOStatement
     */
    public static function getListAndCultureContainRegDataSQL($idCulture, $idProduct) {
        $db = Db::getConnection();

        $sql = 'SELECT `product_and_regdata`.`id_product`, `regdata`.`min_rate`, `regdata`.`max_rate`
                FROM `regdata`
                JOIN `product_and_regdata` ON `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata`
                JOIN `culture` ON `culture`.`id_culture` = `regdata`.`id_culture`
                WHERE `product_and_regdata`.`id_product` = :idProduct AND `culture`.`id_culture` = :idCulture
                ORDER BY `regdata`.`id_regdata` DESC LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }
    public static function getListAndPriceByIdProductSQL($idProduct) {
        $db = Db::getConnection();

        $sql = 'SELECT * 
                FROM product_and_price 
                WHERE id_product = :idProduct AND actuality = 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getListByIdCultureAndProductClass($idCulture, $idProductClass)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `modeaction` .`id_modeaction`, `modeaction` .`short_name_modeaction`, `modeaction` .`modeaction_description_rus` 
                  FROM `product`  
                  JOIN `product_and_culture`  JOIN `product_and_substance`  JOIN `substance`  JOIN `substance_and_modeaction`  
                  JOIN `modeaction`  JOIN `manufacture`  
                  ON `product` .`id_product` = `product_and_culture` .id_product AND `product` .`id_product`=`product_and_substance` .`id_product` 
                  AND `product_and_substance` .`id_substance` = `substance` .`id_substance` AND `substance` .`id_substance` = `substance_and_modeaction` .`id_substance` 
                  AND `substance_and_modeaction` .`id_modeaction` = `modeaction` .`id_modeaction` AND `product` .`id_manufacture` = `manufacture` .`id_manufacture`
                  WHERE `product_and_culture` .`id_culture` = :idCulture AND `product` .`id_clproduct` = :idProductClass 
                  GROUP BY `modeaction` .`id_modeaction` ORDER BY `short_name_modeaction`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdManufactureAndIdImporterAndIdProductClass($idManufacture, $idImporter, $idProductClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `product`.`id_product`, `product`.`name_product_rus`, `product_and_price`.`price_rub`, `product_and_price`.`price_usd`,  
                GROUP_CONCAT(DISTINCT `culture` .`name_rus` ORDER BY `culture` .`name_rus` ASC SEPARATOR ", ") AS "nameculture"
                FROM `product`  JOIN `product_and_price` JOIN `product_and_regdata` JOIN `regdata` JOIN `culture`  
                ON `product` .`id_product` = `product_and_price`.`id_product` AND `product` .`id_product` = `product_and_regdata`.`id_product` 
                AND `product_and_regdata`.`id_regdata` = `regdata`.`id_regdata` AND `regdata`.`id_culture` = `culture` .`id_culture` 
                WHERE `product` .`id_clproduct` = :idProductClass AND `product` .`id_manufacture` = :idManufacture 
                AND `product_and_price`.`id_importer` = :idImporter AND `product_and_price`.`actuality` = "1" 
                GROUP BY `product`.`id_product` 
                ORDER BY `product`.`name_product_rus`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idManufacture', $idManufacture, PDO::PARAM_INT);
        $result->bindParam(':idImporter', $idImporter, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListAndPriceByIdProductAndIdCulture($idProduct, $idCulture) {
        $db = Db::getConnection();

        $sql = 'SELECT `product_and_price`.price_rub, `regdata`.min_rate, `regdata`.max_rate 
                  FROM `product_and_price` JOIN `product_and_regdata` JOIN `regdata` 
                  ON `product_and_price`.id_product = `product_and_regdata`.id_product AND `product_and_regdata`.id_regdata = `regdata`.id_regdata 
                  WHERE `product_and_price`.id_product = :idProduct AND `regdata`.id_culture = :idCulture
                  AND `product_and_price`.actuality = "1";';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListAndBioTargetByIdProductAndIdCulture($idProduct, $idCulture) {
        $db = Db::getConnection();

        $sql = 'SELECT `id_biotarget_class` 
                FROM `product_and_biotarget`
                WHERE `product_and_biotarget`.`id_product` = :idProduct
                AND `product_and_biotarget`.`id_culture` = :idCulture
                GROUP BY `id_biotarget_class`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListAndBioTargetWithObjectGroup($idProduct, $idCulture, $idBioTargetClass) {
        $db = Db::getConnection();
        
        $sql = 'SELECT * 
                FROM `product_and_biotarget`
                JOIN `biblio_link` JOIN `object_group` 
                ON `product_and_biotarget`.`id_biotarget` = `object_group`.`id_grobject` 
                AND `product_and_biotarget`.`id_biblio_link` = `biblio_link`.`id_biblio_link` 
                WHERE `product_and_biotarget`.`id_product` = :idProduct
                AND `product_and_biotarget`.`id_culture` = :idCulture
                AND `product_and_biotarget`.`id_biotarget_class` = :idBioTargetClass;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idBioTargetClass', $idBioTargetClass, PDO::PARAM_INT);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }
        
        return false;
    }
    public static function getListAndBioTargetWithObject($idProduct, $idCulture, $idBioTargetClass)
    {
        $db = Db::getConnection();

        $sql = 'SELECT *
                FROM `product_and_biotarget`
                JOIN `biblio_link`
                JOIN `object`
                ON `product_and_biotarget`.`id_biotarget` = `object`.`id_object`
                AND `product_and_biotarget`.`id_biblio_link` = `biblio_link`.`id_biblio_link`
                WHERE `product_and_biotarget`.`id_product` = :idProduct
                AND `product_and_biotarget`.`id_culture` = :idCulture
                AND `product_and_biotarget`.`id_biotarget_class` = :idBioTargetClass;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idBioTargetClass', $idBioTargetClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
    public static function getListAndBioTargetWithSpecies($idProduct, $idCulture, $idBioTargetClass)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * 
                FROM `product_and_biotarget` JOIN `biblio_link` JOIN `species` 
                ON `product_and_biotarget`.`id_biotarget` = `species`.`id_species` 
                AND `product_and_biotarget`.`id_biblio_link` = `biblio_link`.`id_biblio_link` 
                WHERE `product_and_biotarget`.`id_product` = :idProduct 
                AND `product_and_biotarget`.`id_culture` = :idCulture 
                AND `product_and_biotarget`.`id_biotarget_class` = :idBioTargetClass;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idBioTargetClass', $idBioTargetClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListAndPriceMinRateWithRegData($idProduct) {
        $db = Db::getConnection();

        $sql = 'SELECT `product_and_price`.price_rub, `product_and_price`.price_usd, `regdata`.min_rate
                 FROM `product_and_price`
                 JOIN `product_and_regdata`
                 JOIN `regdata` ON `product_and_price`.id_product = `product_and_regdata`.id_product 
                 AND `product_and_regdata`.id_regdata = `regdata`.id_regdata 
                 WHERE `product_and_price`.id_product = :idProduct AND `product_and_price`.actuality = "1" 
                 ORDER BY `regdata`.min_rate LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getListAndPriceMaxRateWithRegData($idProduct)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `regdata`.max_rate
                 FROM `product_and_price`
                 JOIN `product_and_regdata`
                 JOIN `regdata` ON `product_and_price`.id_product = `product_and_regdata`.id_product 
                 AND `product_and_regdata`.id_regdata = `regdata`.id_regdata 
                 WHERE `product_and_price`.id_product = :idProduct AND `product_and_price`.actuality = "1" 
                 ORDER BY `regdata`.max_rate DESC LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
    }

    public static function getListContainSubstance($idSubstance) {
        $db = Db::getConnection();

        $sql = 'SELECT `product`.`id_product`, `product`.`name_product_rus`, `manufacture`.`name_manufacture_rus`, 
                GROUP_CONCAT(DISTINCT `culture`.`name_rus` ORDER BY `culture`.`name_rus` ASC SEPARATOR ", ") AS "nameculture"
                FROM `substance` JOIN `product_and_substance` JOIN `product` JOIN `manufacture` JOIN `product_and_culture` JOIN `culture` 
                ON `substance`.`id_substance` = `product_and_substance`.`id_substance` AND `product_and_substance`.`id_product` = `product`.`id_product` 
                AND `product`.`id_manufacture` = `manufacture`.`id_manufacture` AND `product`.`id_product` = `product_and_culture`.`id_product` 
                AND `product_and_culture`.`id_culture` = `culture`.`id_culture` 
                WHERE `substance`.`id_substance` = :idSubstance
                GROUP BY `product`.`name_product_rus` 
                ORDER BY `product`.`name_product_rus`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idSubstance', $idSubstance, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListByIdSubstanceAndIdCultureAndIdProductClass($idSubstance, $idCulture, $idProductClass)
    {
        $db = Db::getConnection();

        $sql = 'SELECT product.id_product, product.name_product_rus, manufacture.name_manufacture_rus, product_and_culture.min_rate, product_and_culture.max_rate, product_and_price.price_rub,
                product_and_culture.min_rate * product_and_substance.concentration AS minconcentr, product_and_culture.max_rate * product_and_substance.concentration AS maxconcentr 
                FROM substance  JOIN product_and_substance JOIN product JOIN manufacture JOIN product_and_culture JOIN product_and_price 
                ON substance.id_substance = product_and_substance.id_substance AND product_and_substance.id_product = product.id_product 
                AND product.id_manufacture = manufacture.id_manufacture AND product.id_product = product_and_culture.id_product 
                AND product.id_product = product_and_price.id_product 
                WHERE substance.id_substance = :idSubstance AND product_and_culture.id_culture = :idCulture AND product_and_price.actuality = "1" 
                AND product.id_clproduct = :idProductClass 
                GROUP BY product.name_product_rus 
                ORDER BY minconcentr;';
        $result = $db->prepare($sql);
        $result->bindParam(':idSubstance', $idSubstance, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListAndPriceByIdManufactureAndIdImporter($idManufacture, $idImporter, $idProductClass)
    {
        $db = Db::getConnection();

        $sql = 'SELECT * 
                  FROM `product_class` 
                  JOIN `manufacture` JOIN `product` JOIN `product_and_price` JOIN `product_solution` JOIN `product_tara`
                  ON `manufacture`.`id_manufacture` = `product`.`id_manufacture` AND `product`.`id_product` = `product_and_price`.`id_product` 
                  AND `product`.`id_clproduct` = `product_class`.`id_clproduct` AND `product`.`id_product_solution` = `product_solution`.`id_product_solution` 
                  AND `product`.`id_product_tara` = `product_tara`.`id_product_tara` 
                  WHERE `manufacture`.`id_manufacture` = :idManufacture AND `product_class`.`id_clproduct` = :idProductClass 
                  AND `product_and_price`.`id_importer` = :idImporter AND `product_and_price`.`actuality` = "1" 
                  ORDER BY `product`.`name_product_rus`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idManufacture', $idManufacture, PDO::PARAM_INT);
        $result->bindParam(':idImporter', $idImporter, PDO::PARAM_INT);
        $result->bindParam(':idProductClass', $idProductClass, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function searchByQuery($query)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `id_product`, `name_product_rus` 
                FROM `product` 
                WHERE `name_product_rus` 
                LIKE :query 
                LIMIT 5;';
        $result = $db->prepare($sql);
        $query .= '%';
        $result->bindParam(':query', $query, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }

    public static function getListContainBiotarget($idObject, $idCulture)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `product`.`name_product_rus`, `product_and_biotarget`.`rate`, `product_and_biotarget`.`efficacy`, `culture`.`name_rus`, `biblio_link`.`name_link`
                FROM `product_and_biotarget`
                JOIN `biblio_link`
                JOIN `object`
                JOIN `product`
                JOIN `culture`
                ON `product_and_biotarget`.`id_biotarget` = `object`.`id_object`
                AND `product_and_biotarget`.`id_product` = `product`.`id_product`
                AND `product_and_biotarget`.`id_biblio_link` = `biblio_link`.`id_biblio_link`
                AND `product_and_biotarget`.`id_biotarget_class` = "2"
                AND `product_and_biotarget`.`id_culture` = `culture`.`id_culture`
                AND `object`.`id_object` = :idObject
                AND `culture`.`id_culture` = :idCulture
                GROUP BY `product`.`id_product` + `product_and_biotarget`.`rate` + `product_and_biotarget`.`efficacy`';
        $result = $db->prepare($sql);
        $result->bindParam(':idObject', $idObject, PDO::PARAM_INT);
        $result->bindParam(':idCulture', $idCulture, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}