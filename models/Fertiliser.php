<?php

class Fertiliser {
  public static function add($idManufacture, $idFertiliserGroup, $idAlphabetRus, $name, $idCountrycode, $idProductTara) {
    $db = Db::getConnection();

    $sql = 'INSERT INTO `fertiliser`(`id_manufacture`, `id_grfertiliser`, 
                            `id_alphabet_rus`, `name_fertiliser`, `id_countrycode`, `id_product_tara`) 
                VALUES(:id_manufacture, :id_grfertiliser, :id_alphabet_rus, 
                       :name, :idCountrycode, :idProductTara);';
    $result = $db->prepare($sql);
    $result->bindParam(':id_manufacture', $idManufacture, PDO::PARAM_INT);
    $result->bindParam(':id_grfertiliser', $idFertiliserGroup, PDO::PARAM_INT);
    $result->bindParam(':id_alphabet_rus', $idAlphabetRus, PDO::PARAM_INT);
    $result->bindParam(':name', $name, PDO::PARAM_STR);
    $result->bindParam(':idCountrycode', $idCountrycode, PDO::PARAM_INT);
    $result->bindParam(':idProductTara', $idProductTara, PDO::PARAM_INT);

    if ($result->execute()) {
      return $db->lastInsertId();
    }

    return false;
  }

  public static function get($idFertiliser) {
    $db = Db::getConnection();

    $sql = 'SELECT `fertiliser`.`name_fertiliser`, `fertiliser`.`id_manufacture`, `manufacture`.`name_manufacture_rus`, 
                       `fertiliser`.`condition`, `fertiliser`.`color`, `fertiliser_desc`.`description`,
                       `fertiliser`.`id_product_tara`, `product_tara`.`tara`, `product_tara`.`pack`
                FROM `fertiliser`
                LEFT JOIN `manufacture` ON `manufacture`.`id_manufacture` = `fertiliser`.`id_manufacture`
                LEFT JOIN `fertiliser_desc` ON `fertiliser_desc`.`id_fertiliser` = `fertiliser`.`id_fertiliser`
                LEFT JOIN `product_tara` ON `product_tara`.`id_product_tara` = `fertiliser`.`id_product_tara`
                WHERE `fertiliser`.`id_fertiliser` = :id_fertiliser 
                LIMIT 1;';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
    $result->execute();

    if ($result->rowCount()) {
      return $result->fetch();
    }

    return false;
  }

  public static function getList() {
    $db = Db::getConnection();

    $sql = 'SELECT * FROM `fertiliser`;';
    $result = $db->prepare($sql);
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }

  public static function getListByManufacture($idManufacture) {
    $db = Db::getConnection();

    $sql = 'SELECT * FROM `fertiliser` WHERE `id_manufacture` = :id_manufacture;';
    $result = $db->prepare($sql);
    $result->bindParam(':id_manufacture', $idManufacture, PDO::PARAM_INT);
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }

  // Список удобрений по группе и классу удобрений
  public static function getListByGroupAndClass($idFertiliserGroup, $idFertiliserClass) {
    $db = Db::getConnection();

    $sql = 'SELECT `fertiliser`.`id_fertiliser`, `fertiliser`.`name_fertiliser`, `manufacture`.`name_manufacture_rus`, table1.elementList
                FROM `fertiliser`, `fertiliser_group`, `fertiliser_and_clfertiliser`, `fertiliser_class`, `manufacture`,
                (SELECT `fertiliser`.`id_fertiliser`, GROUP_CONCAT(DISTINCT `element`.`name_rus` ORDER BY `element`.`name_rus` ASC SEPARATOR \', \') as "elementList"
                FROM `fertiliser`, `fertiliser_and_clfertiliser`, `clfertiliser_and_element`, `fertiliser_and_element`, `element`
                WHERE `fertiliser`.`id_fertiliser` = `fertiliser_and_clfertiliser`.`id_fertiliser`
                AND `fertiliser_and_clfertiliser`.`id_clfertiliser` =  `clfertiliser_and_element`.`id_clfertiliser`
                AND `clfertiliser_and_element`.`id_element` = `fertiliser_and_element`.`id_element`
                AND `fertiliser_and_element`.`id_element` = `element`.`id_element`
                AND `fertiliser_and_element`.`id_fertiliser` = `fertiliser`.`id_fertiliser`
				AND `fertiliser_and_clfertiliser`.`id_clfertiliser` = :id_clfertiliser
                GROUP BY `fertiliser`.`id_fertiliser`) as table1
                
                WHERE `fertiliser`.`id_grfertiliser` = `fertiliser_group`.`id_grfertiliser`
                AND `fertiliser_and_clfertiliser`.`id_fertiliser` = `fertiliser`.`id_fertiliser`
                AND `fertiliser_and_clfertiliser`.`id_clfertiliser` = `fertiliser_class`.`id_clfertiliser`
                AND `fertiliser`.`id_fertiliser` = table1.id_fertiliser
                AND `fertiliser`.`id_manufacture` = `manufacture`.`id_manufacture`
                AND `fertiliser_group`.`id_grfertiliser` = :id_grfertiliser
                AND `fertiliser_class`.`id_clfertiliser` = :id_clfertiliser
                ORDER BY `fertiliser`.`name_fertiliser`';
    $result = $db->prepare($sql);
    $result->bindParam(':id_grfertiliser', $idFertiliserGroup, PDO::PARAM_INT);
    $result->bindParam(':id_clfertiliser', $idFertiliserClass, PDO::PARAM_INT);
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }

  // Список удобрений по группе, классу удобрений и содержащемуся в удобрении элементу
  public static function getListByGroupAndClassAndElement($idFertiliserGroup, $idFertiliserClass, $idElement) {
    $db = Db::getConnection();

    $sql = 'SELECT `fertiliser`.`id_fertiliser`, `fertiliser`.`name_fertiliser`, `manufacture`.`name_manufacture_rus`, `fertiliser_and_element`.`concentration`
                FROM `fertiliser`, `fertiliser_group`, `fertiliser_and_clfertiliser`, `fertiliser_class`, `manufacture`, `fertiliser_and_element`, `element`
                
                WHERE `fertiliser`.`id_grfertiliser` = `fertiliser_group`.`id_grfertiliser`
                AND `fertiliser_and_clfertiliser`.`id_fertiliser` = `fertiliser`.`id_fertiliser`
                AND `fertiliser_and_clfertiliser`.`id_clfertiliser` = `fertiliser_class`.`id_clfertiliser`
                AND `fertiliser`.`id_manufacture` = `manufacture`.`id_manufacture`
                AND `fertiliser_and_element`.`id_fertiliser` = `fertiliser`.`id_fertiliser`
                AND `fertiliser_and_element`.`id_element` = `element`.`id_element`
                AND `fertiliser_group`.`id_grfertiliser` = :id_grfertiliser
                AND `fertiliser_class`.`id_clfertiliser` = :id_clfertiliser
                AND `element`.`id_element` = :id_element
                ORDER BY `fertiliser_and_element`.`concentration` DESC';
    $result = $db->prepare($sql);
    $result->bindParam(':id_grfertiliser', $idFertiliserGroup, PDO::PARAM_INT);
    $result->bindParam(':id_clfertiliser', $idFertiliserClass, PDO::PARAM_INT);
    $result->bindParam(':id_element', $idElement, PDO::PARAM_INT);
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }

  public static function addFertiliserClass($idFertiliser, $idFertiliserClass) {
    $db = Db::getConnection();

    $sql = 'INSERT INTO `fertiliser_and_clfertiliser`(`id_fertiliser`, `id_clfertiliser`) 
                VALUES(:id_fertiliser, :id_clfertiliser);';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
    $result->bindParam(':id_clfertiliser', $idFertiliserClass, PDO::PARAM_INT);

    return $result->execute();
  }

  public static function addAndElement($idFertiliser, $idElement, $concentration, $idSubstanceUnit) {
    $db = Db::getConnection();

    $sql = 'INSERT INTO `fertiliser_and_element`(`id_fertiliser`, `id_element`, `concentration`, `id_substance_unit`) 
                VALUES(:id_fertiliser, :id_element, :concentration, :id_substance_unit);';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
    $result->bindParam(':id_element', $idElement, PDO::PARAM_INT);
    $result->bindParam(':concentration', $concentration, PDO::PARAM_STR);
    $result->bindParam(':id_substance_unit', $idSubstanceUnit, PDO::PARAM_INT);

    return $result->execute();
  }

  public static function addRegData($idFertiliser, $idCulture, $minRate, $maxRate, $reglament) {
    $db = Db::getConnection();

    $sql = 'INSERT INTO `fertiliser_regdata`(`id_fertiliser`, `id_culture`, `min_rate`, `max_rate`, `description`) 
                VALUES(:id_fertiliser, :id_culture, :min_rate, :max_rate, :description);';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
    $result->bindParam(':id_culture', $idCulture, PDO::PARAM_INT);
    $result->bindParam(':min_rate', $minRate, PDO::PARAM_STR);
    $result->bindParam(':max_rate', $maxRate, PDO::PARAM_STR);
    $result->bindParam(':description', $reglament, PDO::PARAM_STR);

    return $result->execute();
  }

  public static function addDecs($idFertiliser, $desc) {
    $db = Db::getConnection();

    $sql = 'INSERT INTO `fertiliser_desc`(`id_fertiliser`, `description`) 
                VALUES(:id_fertiliser, :description);';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
    $result->bindParam(':description', $desc, PDO::PARAM_STR);

    return $result->execute();
  }

  public static function addDecsAdv($idFertiliser, $descAdv) {
    $db = Db::getConnection();

    $sql = 'INSERT INTO `fertiliser_desc_adv`(`id_fertiliser`, `desc_advantage`) VALUES(:id_fertiliser, :desc_advantage);';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
    $result->bindParam(':desc_advantage', $descAdv, PDO::PARAM_STR);

    return $result->execute();
  }

  public static function getDescAdvList($idFertiliser) {
    $db = Db::getConnection();

    $sql = 'SELECT * FROM `fertiliser_desc_adv` WHERE `id_fertiliser` = :id_fertiliser;';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }

  public static function deleteDescAdv($idFertiliser) {
    $db = Db::getConnection();

    $sql = 'DELETE FROM `fertiliser_desc_adv` WHERE `id_fertiliser` = :id_fertiliser;';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);

    return $result->execute();
  }

  public static function getRegDataList($idFertiliser) {
    $db = Db::getConnection();

    $sql = 'SELECT `fertiliser_regdata`.`id_fertregdata`, 
                       `fertiliser_regdata`.`id_culture`, `culture`.`name_rus` as "culture", 
                       `fertiliser_regdata`.`min_rate`, `fertiliser_regdata`.`max_rate`, 
                       `fertiliser_regdata`.`description`
                FROM `fertiliser_regdata`, `culture`
                WHERE `fertiliser_regdata`.`id_culture` = `culture`.`id_culture`
                AND `fertiliser_regdata`.`id_fertiliser` = :id_fertiliser;';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }

  // Получить список упаково к удобрению
  public static function getPackAndTaraList($idFertiliser) {
    $db = Db::getConnection();

    $sql = 'SELECT `product_tara`.`id_product_tara`, `product_tara`.`pack_and_tara`
            FROM `fertiliser_and_tara`, `product_tara` 
            WHERE `id_fertiliser` = :id_fertiliser AND `id_fertiliser_tara` = `product_tara`.`id_product_tara`;';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }
}