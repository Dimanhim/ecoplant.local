<?php

class ModeAction
{
    public static function getListByIdSubstanceSQL($idSubstance)
    {
        $db = Db::getConnection();

        $sql = 'SELECT `short_name_modeaction`, `name_modeaction`
                   FROM `modeaction` 
                   JOIN `substance_and_modeaction` ON `modeaction`.`id_modeaction` = `substance_and_modeaction`.`id_modeaction` 
                   WHERE `substance_and_modeaction`.`id_substance` = :idSubstance;';
        $result = $db->prepare($sql);
        $result->bindParam(':idSubstance', $idSubstance, PDO::PARAM_INT);
        $result->execute();

        if ($result->rowCount()) {
            return $result;
        }

        return false;
    }
}