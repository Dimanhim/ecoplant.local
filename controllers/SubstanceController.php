<?php

class SubstanceController
{
    public function actionInfo($idSubstance) {
        $idProduct = $_SESSION['idProduct'];
        $idCulture = $_SESSION['idCulture'];
        $idProductClass = $_SESSION['idProductClass'];

        $productClass = ProductClass::getById($idProductClass);
        $productClassByProductAndCulture = ProductClass::getByIdProductAndIdProductAndIdCulture($idProduct, $idProductClass, $idCulture);

        $substance = Substance::getById($idSubstance);
        $chemClassList = ChemClass::getListByIdSubstanceSQL($idSubstance);

        $productClassList = ProductClass::getListByIdSubstanceAndIdCulture($idSubstance, $idCulture);

        require_once(ROOT . '/views/substance/info.php');
        return true;
    }
    public function actionFullInfo($idSubstance) {
        $idProduct = $_SESSION['idProduct'];
        $idProductClass = $_SESSION['idProductClass'];

        $productClass = ProductClass::getById($idProductClass);
        $productClassByIdProduct = ProductClass::getByIdProduct($idProduct);

        $substance = Substance::getById($idSubstance);
        $chemClassList = ChemClass::getListByIdSubstanceSQL($idSubstance);
        $modeActionList = ModeAction::getListByIdSubstanceSQL($idSubstance);

        $productContainSubstance = Product::getListContainSubstance($idSubstance);

        require_once(ROOT . '/views/substance/fullInfo.php');
        return true;
    }
}