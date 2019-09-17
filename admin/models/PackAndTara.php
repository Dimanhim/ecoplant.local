<?php

// Упаковки
class PackAndTara {
  public static function getListSQL($orderField = false) {
    $db = Db::getConnection();

    $sql = 'SELECT `id_product_tara`, `pack_and_tara` FROM `product_tara`';
    if ($orderField == 'name') {
      $sql .= ' ORDER BY `pack_and_tara` ASC';
    }
    $result = $db->prepare($sql);
    $result->execute();

    if ($result->rowCount()) {
      return $result;
    }

    return false;
  }

  public static function addToProduct($idProduct, $idPackAndTara) {
    $db = Db::getConnection();

    $sql = 'INSERT INTO `product_and_tara`(`id_product`, `id_product_tara`) 
                VALUES(:idProduct, :idPackAndTara);';
    $result = $db->prepare($sql);
    $result->bindParam(':idProduct', $idProduct, PDO::PARAM_INT);
    $result->bindParam(':idPackAndTara', $idPackAndTara, PDO::PARAM_INT);

    return $result->execute();
  }
}