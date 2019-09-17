<?php

// Производители
class Manufacture {
  public static function getListSQL($orderField = false) {
    $db = Db::getConnection();

    $sql = 'SELECT `id_manufacture`, `name_manufacture_rus` FROM `manufacture`';
    if ($orderField == 'name') {
      $sql .= ' ORDER BY `name_manufacture_rus`;';
    }
    $result = $db->prepare($sql);
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }

  public static function add($nameManufactureRus, $idLetter) {
    $db = Db::getConnection();

    $sql = "INSERT INTO `manufacture`(`name_manufacture_rus`, `id_alphabet`) VALUES (:nameManufactureRus, :idLetter);";
    $result = $db->prepare($sql);
    $result->bindParam(':nameManufactureRus', $nameManufactureRus, PDO::PARAM_STR);
    $result->bindParam(':idLetter', $idLetter, PDO::PARAM_INT);

    if ($result->execute()) {
      return $db->lastInsertId();
    }

    return false;
  }

  public static function delete($idManufacture) {
    $db = Db::getConnection();

    $sql = "DELETE FROM `manufacture` WHERE `id_manufacture` = :idManufacture LIMIT 1;";
    $result = $db->prepare($sql);
    $result->bindParam(':idManufacture', $idManufacture, PDO::PARAM_INT);

    return $result->execute();
  }

  public static function addLogo($idManufacture, $fileName) {
    $db = Db::getConnection();

    $sql = 'INSERT INTO `manufacture_logo`(`id_manufacture`, `file_manufacture_logo`) 
                VALUES(:id_manufacture, :file_manufacture_logo);';
    $result = $db->prepare($sql);
    $result->bindParam(':id_manufacture', $idManufacture, PDO::PARAM_STR);
    $result->bindParam(':file_manufacture_logo', $fileName, PDO::PARAM_STR);

    return $result->execute();
  }
}