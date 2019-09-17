<?php

class PesticideController {
    public function actionIndex() {
        $listProductClassWithDesc = ProductClass::getListWithDescSQL();
        $manufactureListSQL = Manufacture::getListSQL('name');

        require_once(ROOT . '/views/pesticide/index.php');
        return true;
    }

    public function actionProductClass($idProductClass) {
        $_SESSION['idProductClass'] = $idProductClass;

        $productClass = ProductClass::getById($idProductClass);
        $firstLetterByProductClass = Letter::getFirstLetterProductByIdProductClassListSQL($idProductClass);
        $cultureClassListSQL = CultureClass::getListByIdProductClassMerged($idProductClass);
        $manufactureByProductClassListSQL = Manufacture::getListByExistProductAndProductCulture($idProductClass);

        require_once(ROOT . '/views/pesticide/productClass.php');
        return true;
    }

    public function actionListByAlphabet($idAlphabet) {
        $idProductClass = $_SESSION['idProductClass'];

        $productClass = ProductClass::getById($idProductClass);
        $letter = Letter::getRusById($idAlphabet);
        $productList = Product::getListByIdAlphabetAndProductClassMerged($idAlphabet, $idProductClass);

        require_once(ROOT . '/views/pesticide/listByAlphabet.php');
        return true;
    }
    public function actionListByCultureGroup($idCultureGroup) {
        $idProductClass = $_SESSION['idProductClass'];

        $productClass = ProductClass::getById($idProductClass);
        $cultureListSQL = Culture::getListByIdCultureGroupAndIdProductClassWithRegData($idCultureGroup, $idProductClass);
        $cultureListTwoSQL = Culture::getListByIdCultureGroupAndIdProductClass($idCultureGroup, $idProductClass);

        require_once(ROOT . '/views/pesticide/listByCultureGroup.php');
        return true;
    }
    public function actionListByManufacture($idManufacture) {
        $idProductClass = $_SESSION['idProductClass'];

        $productClass = ProductClass::getById($idProductClass);
        $manufacture = Manufacture::getById($idManufacture);

        $importerList = Importer::getListImporterAndDateByIdManufacture($idManufacture);

        require_once(ROOT . '/views/pesticide/listByManufacture.php');
        return true;
    }

    public function actionInfo($idProduct, $idCulture) {
        $_SESSION['idProduct'] = $idProduct;
        $_SESSION['idCulture'] = $idCulture;
        $idProductClass = $_SESSION['idProductClass'];

        $productClass = ProductClass::getByIdProductAndIdProductAndIdCulture($idProduct, $idProductClass, $idCulture);
        $manufacture = Manufacture::getByIdProductSQL($idProduct);

        $productPriceList = Product::getListAndPriceByIdProductAndIdCulture($idProduct, $idCulture);
        $substanceList = Substance::getListByIdProduct($idProduct);
        $solutionList = Solution::getListByIdProduct($idProduct);
        $taraList = PackAndTara::getListByIdProduct($idProduct);

        $regDataList = RegData::getListByIdProductAndIdCultureSQL($idProduct, $idCulture);
        $namesObject = RegData::getListByIdProductAndIdCultureContainObject($idProduct, $idCulture);
        $productAndBiotargetList = Product::getListAndBioTargetByIdProductAndIdCulture($idProduct, $idCulture);

        require_once(ROOT . '/views/pesticide/info.php');
        return true;
    }
    public function actionFullInfo($idProduct) {
        $_SESSION['idProduct'] = $idProduct;
        $idProductClass = $_SESSION['idProductClass'];

        $productClassByIdProduct = ProductClass::getByIdProduct($idProduct);

        $manufacture = Manufacture::getByIdProductSQL($idProduct);
        $importerList = Importer::getListByIdProduct($idProduct);

        $priceMinRate = Product::getListAndPriceMinRateWithRegData($idProduct);
        $priceMaxRate = Product::getListAndPriceMaxRateWithRegData($idProduct);

        $substanceList = Substance::getListByIdProduct($idProduct);
        $solutionList = Solution::getListByIdProduct($idProduct);

        $taraList = PackAndTara::getListByIdProduct($idProduct);

        $regDataCultureList = RegData::getListByIdProductContainCulture($idProduct);

        $regCertificate = RegData::getRegCertificateByIdProduct($idProduct);

        require_once(ROOT . '/views/pesticide/fullInfo.php');
        return true;
    }
}