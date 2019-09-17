<?php

class SpeciesController
{
    public function actionAdd() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;
        $nameSpeciesLat = false;
        $idLetter = false;
        $idObject = false;
        $idSynonym = false;
        $actuality = false;

        if (isset($_POST['action'])) {
            $nameSpeciesLat = $_POST["lnamespecies"];
            if ($nameSpeciesLat == '')
                $errors[] = 'Название не может быть пустым';

            $idLetter = $_POST["id_letter"];
            if ($idLetter == '')
                $errors[] = 'Не выбрана буква алфавита';

            $id_synonym_text = $_POST['id_synonym-autocomplete'];
            if ($id_synonym_text) {
                $idSynonym = $_POST['id_synonym'];
            }

            if (isset($_POST['actuality'])) {
                if ($_POST['actuality'] == 'on')
                    $actuality = true;
            }

            if (isset($_POST['id_object']))
                $idObject = $_POST['id_object'];
            if ($idObject == '')
                $errors[] = 'Не выбран объект';

            if (!$errors) {
                if ($actuality)
                    $actuality = 1;
                else
                    $actuality = 0;

                if (Species::add($nameSpeciesLat, $idLetter, $actuality, $idSynonym)) {
                    $idSpecies = Species::getId($nameSpeciesLat, $idLetter, $actuality, $idSynonym);

                    if ($idSpecies) {
                        Species::addAndObject($idSpecies, $idObject);

                        $success[] = "Вид \"$nameSpeciesLat\" добавлен в базу данных";

                        $nameSpeciesLat = false;
                        $idLetter = false;
                        $idObject = false;
                        $idSynonym = false;
                        $actuality = false;
                    } else {
                        $errors[] = "Ошибка ввода данных. Напишите Администратору.";
                    }

                } else {
                    $errors[] = "Ошибка ввода данных. Напишите Администратору.";
                }
            }
        }

        $latLetterListSQL = Letter::getLatListSQL();
        $objectListSQL = Object::getListSQL('rnameobject');
        $speciesWithoutSynonymSQL = Species::getListWithoutSynonymSQL();

        require_once(ROOT . '/views/species/add.php');
        return true;
    }
}