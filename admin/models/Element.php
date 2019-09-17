<?php

class Element {
  public static function getList() {
    $db = Db::getConnection();

    $sql = 'SELECT * FROM `element`;';
    $result = $db->prepare($sql);
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }

  // Получаем список элементов конкретного класса удобрений
  public static function getListByFertiliserClassArray($idFertiliserClassArray) {
    $db = Db::getConnection();

    $sql = 'SELECT `element`.`id_element`, `element`.`name_rus`, `element`.`chemformulation`
                FROM `element`, `clfertiliser_and_element`
                WHERE `clfertiliser_and_element`.`id_element` = `element`.`id_element`
                AND `clfertiliser_and_element`.`id_clfertiliser` IN (';

    $idFertiliserClass = '';
    for ($i = 0; $i < count($idFertiliserClassArray); $i++) {
      $idFertiliserClass .= $idFertiliserClassArray[$i] . ', ';
    }
    $sql .= trim($idFertiliserClass, ', ');
    $sql .= ');';

    $result = $db->prepare($sql);
    echo $sql;
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }

  public static function add($name, $chemFormula) {
    $db = Db::getConnection();

    $sql = 'INSERT INTO `element`(`name_rus`, `chemformulation`) VALUES(:name_rus, :chemformulation);';
    $result = $db->prepare($sql);
    $result->bindParam(':name_rus', $name, PDO::PARAM_STR);
    $result->bindParam(':chemformulation', $chemFormula, PDO::PARAM_STR);

    return $result->execute();
  }

  public static function getByName($name) {
    $db = Db::getConnection();

    $sql = 'SELECT `id_element` FROM `element` WHERE `name_rus` = :name_rus LIMIT 1;';
    $result = $db->prepare($sql);
    $result->bindParam(':name_rus', $name, PDO::PARAM_STR);
    $result->execute();

    if ($result->rowCount()) {
      return $result->fetch()['id_element'];
    }

    return false;
  }

  public static function getByChemFormula($chemFormula) {
    $db = Db::getConnection();

    $sql = 'SELECT `id_element` FROM `element` WHERE `chemformulation` = :chemformulation LIMIT 1;';
    $result = $db->prepare($sql);
    $result->bindParam(':chemformulation', $chemFormula, PDO::PARAM_STR);
    $result->execute();

    if ($result->rowCount()) {
      return $result->fetch()['id_element'];
    }

    return false;
  }
}