<?php

class FertiliserController
{
    public function actionIndex() {
        $fertiliserGroupList = FertiliserGroup::getList();
        $manufactureList = Manufacture::getListContainFertiliser();

        require_once(ROOT . '/views/fertiliser/index.php');
        return true;
    }

    public function actionListByGroupAndClass($idFertiliserGroup, $idFertiliserClass, $idElement = false) {

        $fertiliserGroup = FertiliserGroup::get($idFertiliserGroup);
        $fertiliserClass = FertiliserClass::get($idFertiliserClass);

        $elementList = Element::getListByFertiliserClassAndContainInFertiliser($idFertiliserClass);

        $element = false;
        if ($idElement) {
            $element = Element::get($idElement);
            $fertiliserList = Fertiliser::getListByGroupAndClassAndElement($idFertiliserGroup, $idFertiliserClass, $idElement);
        } else {
            $fertiliserList = Fertiliser::getListByGroupAndClass($idFertiliserGroup, $idFertiliserClass);
        }

        require_once(ROOT . '/views/fertiliser/listByGroupAndClass.php');
        return true;
    }
    
    public function actionListByManufacture($idManufacture) {
        $manufacture = Manufacture::getById($idManufacture);
        $fertiliserList = Fertiliser::getListByManufacture($idManufacture);

        require_once(ROOT . '/views/fertiliser/listByManufacture.php');
        return true;
    }
    
    public function actionInfo($idFertiliser) {
        $fertiliser = Fertiliser::get($idFertiliser);
        $fertiliserPackAndTara = Fertiliser::getPackAndTaraList($idFertiliser);
        $fertiliserElementList = Element::getListByIdFertiliser($idFertiliser);
        $fertiliserDescAdv = Fertiliser::getDescAdvList($idFertiliser);
        $fertiliserRegDataList = Fertiliser::getRegDataList($idFertiliser);
        $manufacture = Manufacture::getById($fertiliser['id_manufacture']);

        require_once(ROOT . '/views/fertiliser/info.php');
        return true;
    }
}