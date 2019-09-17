<?php

class SiteController {
	public function actionIndex() {
	    $productCount = Product::getCount();
	    $productCountSeedTr = Product::getCountByIdProductClass(1);
        $productCountHerb = Product::getCountByIdProductClass(2);
        $productCountFungic = Product::getCountByIdProductClass(3);
        $productCountInsectic = Product::getCountByIdProductClass(4);
        $productCountAcaricid = Product::getCountByIdProductClass(5);
        $productCountRegulator = Product::getCountByIdProductClass(5);

        $objectCount = Object::getCount();
        $objectCountMycor = Object::getCountByIdObjectClass(1);

		require_once(ROOT . '/views/site/index.php');
		return true;
	}
}