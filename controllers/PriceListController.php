<?php

class PriceListController
{
    public function actionManufacture($idManufacture) {
        $manufacture = Manufacture::getById($idManufacture);
        $importerList = Importer::getListImporterAndDateByIdManufacture($idManufacture);

        require_once(ROOT . '/views/priceList/manufacture.php');
        return true;
    }
}