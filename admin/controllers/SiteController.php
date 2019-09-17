<?php

class SiteController {
	public function actionIndex() {
        Admin::checkSignInAccess();

        $countUserObjectImage = Object::countAndImageNotShow();

		require_once(ROOT . '/views/site/index.php');
		return true;
	}
}