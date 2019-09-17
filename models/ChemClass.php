<?php

class ChemClass
{
    public static function getListByIdSubstanceSQL($idSubstance) {
        $db = Db::getConnection();

        $sql = 'SELECT `name_chemclass_rus`
                  FROM `substance_and_chemclass` JOIN `chemclass` JOIN `substance_unit` 
                  ON `substance_and_chemclass`.`id_chemclass` = `chemclass`.`id_chemclass` 
                  AND `substance_and_chemclass`.`id_substance` = `substance_and_chemclass`.`id_substance` 
                  WHERE `substance_and_chemclass`.`id_substance` = :idSubstance 
                  GROUP BY `substance_and_chemclass`.`id_substance`;';
        $result = $db->prepare($sql);
        $result->bindParam(':idSubstance', $idSubstance, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}