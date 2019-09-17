<?php

class Fertiliser {
  // TODO Обновить метод в модели в ~/models
  public static function add($idManufacture, $idFertiliserGroup, $idAlphabetRus, $name, $idCountrycode, $idProductTara = 0) {
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

  // Добавление связи "Удобрение-Упаковка"
  public static function addAndTara($idFertiliser, $idPackAndTara) {
    $db = Db::getConnection();
    
    $sql = 'INSERT INTO `fertiliser_and_tara`(`id_fertiliser`, `id_fertiliser_tara`) VALUES(:id_fertiliser, :id_fertiliser_tara);';
    $result = $db->prepare($sql);
    $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
    $result->bindParam(':id_fertiliser_tara', $idPackAndTara, PDO::PARAM_INT);
    
    return $result->execute();
  }
}