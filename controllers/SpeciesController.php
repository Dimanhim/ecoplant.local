<?php

class SpeciesController {
    public function actionIndex($idSpecies) {
        $species = Species::getById($idSpecies);
        $speciesSynonymList = Species::getListSynonymByIdSpecies($idSpecies);

        require_once(ROOT . '/views/species/index.php');
        return true;
    }
}