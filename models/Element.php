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

    public static function getListByIdFertiliser($idFertiliser) {
        $db = Db::getConnection();
        
        $sql = 'SELECT `fertiliser`.`name_fertiliser`, `element`.`name_rus`, `element`.`chemformulation`, `fertiliser_and_element`.`concentration`
                FROM `fertiliser`, `fertiliser_and_element`, `element`
                WHERE `fertiliser`.`id_fertiliser` = `fertiliser_and_element`.`id_fertiliser`
                AND `fertiliser_and_element`.`id_element` = `element`.`id_element`
                AND `fertiliser`.`id_fertiliser` = :id_fertiliser;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_fertiliser', $idFertiliser, PDO::PARAM_INT);
        $result->execute();
        
        if ($result->rowCount()) {
            return $result;
        }
        
        return false;
    }

    // Получаем список элементов конкретного класса удобрений (только элементы содержащиеся в удобрениях)
    public static function getListByFertiliserClassAndContainInFertiliser($idFertiliserClass) {
        $db = Db::getConnection();

        $sql = 'SELECT `element`.`id_element`, `element`.`name_rus`, `element`.`chemformulation`
                FROM `element`, `clfertiliser_and_element`
                WHERE `clfertiliser_and_element`.`id_element` = `element`.`id_element`
                AND `clfertiliser_and_element`.`id_clfertiliser` = :id_clfertiliser
                AND `element`.`id_element` IN 
                (SELECT `element`.`id_element`
                FROM `fertiliser`, `fertiliser_and_clfertiliser`, `fertiliser_and_element`, `element`
                WHERE `fertiliser`.`id_fertiliser` = `fertiliser_and_clfertiliser`.`id_fertiliser`
                AND `fertiliser_and_element`.`id_fertiliser` = `fertiliser`.`id_fertiliser`
                AND `fertiliser_and_element`.`id_element` = `element`.`id_element`
                AND `fertiliser_and_clfertiliser`.`id_clfertiliser` = :id_clfertiliser);';
        $result = $db->prepare($sql);
        $result->bindParam(':id_clfertiliser', $idFertiliserClass, PDO::PARAM_INT);
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

    public static function get($idElement) {
        $db = Db::getConnection();

        $sql = 'SELECT * FROM `element` WHERE `id_element` = :id_element LIMIT 1;';
        $result = $db->prepare($sql);
        $result->bindParam(':id_element', $idElement, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result->fetch();
        }

        return false;
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