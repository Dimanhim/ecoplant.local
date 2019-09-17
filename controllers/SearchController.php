<?php

class SearchController {
    public function actionSearch() {

        if (isset($_POST['query'])) {
            $query = trim($_POST['query']);

            if (mb_strlen($query) >= 3 && mb_strlen($query) < 42) {
                $searchResultProduct = Product::searchByQuery($query);
                $searchResultSubstance = Substance::searchByQuery($query);
            }
        }

        require_once(ROOT . '/views/search/search.php');
        return true;
    }
}