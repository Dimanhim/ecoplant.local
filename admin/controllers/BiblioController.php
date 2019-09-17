<?php

class BiblioController
{
    public function actionAdd() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_BIBLIO_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        if (isset($_POST['collection']) && isset($_POST['year']) && 
            isset($_POST['volume']) && isset($_POST['number']) &&
            isset($_POST['name_work']) && isset($_POST['name_work_eng']) &&
            isset($_POST['pages'])) {

            $idBiblioCollection = $_POST['collection'];
            $idBiblioYear = $_POST['year'];
            $idBiblioVolume = $_POST['volume'];
            $idBiblioNumber = $_POST['number'];

            $nameWorkRus = $_POST['name_work'];
            $nameWorkEng = $_POST['name_work_eng'];
            $pages = $_POST['pages'];

            if (Biblio::addWork($nameWorkRus, $nameWorkEng)) {
                $idBiblioWork = Biblio::getWorkId($nameWorkRus, $nameWorkEng);

                Biblio::add($idBiblioCollection, $idBiblioWork, $idBiblioYear, $idBiblioVolume, $idBiblioNumber, $pages);

                header('Location: ' . PATH . '/biblio/finish/' . $idBiblioWork);
            } else {
                $errors[] = 'Ошибка ввода данных. Напишите Администратору.';
            }
        }

        $biblioListSQL = Biblio::getListSQL();
        $biblioYearListSQL = Biblio::getListYearSQL();
        $biblioVolumeListSQL = Biblio::getListVolumeSQL();
        $biblioNumberListSQL = Biblio::getListNumberSQL();

        require_once(ROOT . '/views/biblio/add.php');
        return true;
    }
    
    public function actionFinish($idBiblioWork) {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_BIBLIO_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        if (isset($_POST['action'])) {
            if (isset($_POST['link']) && isset($_POST['link_eng']) && isset($_POST['author'])) {
                $nameLink = $_POST['link'];
                $nameLinkEng = $_POST['link_eng'];
                $authorList = $_POST['author'];
                for ($i = 0; $i < count($authorList); $i++) {
                    Biblio::addAuthorToWork($idBiblioWork, $authorList[$i]);
                }

                $elink = $_POST['elink'];
                if (!Check::strLength($elink, 6)) {
                    $errors[] = 'Поле "Ссылка на источник" должно быть более 6 символов';
                }

                $idBiblioFile = false;
                if ($_FILES) {
                    $uploaddir = ROOT . '/template/files/';

                    $arrayFileName = explode('.', $_FILES['file']['name']);
                    $formatFile = $arrayFileName[count($arrayFileName) - 1];

                    $fileName = basename(substr(md5($_FILES['file']['name'] . time()), 8) . '.' . $formatFile);

                    $uploadfile = $uploaddir . $fileName;
                    move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);

                    $idBiblioFile = BiblioFile::add($fileName);
                }

                if (Biblio::addLink($nameLink, $nameLinkEng, $elink, $idBiblioFile)) {
                    $idBiblioLink = Biblio::getLinkId($nameLink, $nameLinkEng);

                    if (Biblio::updateLinkByIdBiblioWork($idBiblioWork, $idBiblioLink)) {
                        $success[] = 'Все изменения сохранены';
                    } else {
                        $errors[] = 'Ошибка обновления ссылки в литературном источнике.';
                    }
                } else {
                    $errors[] = 'Ошибка при добавлении ссылки в базу данных.';
                }
            } else {
                $errors[] = 'Не все поля были заполнены';
            }
        }

        $biblioAuthorListSQL = Biblio::getListAuthorSQL();

        require_once(ROOT . '/views/biblio/finish.php');
        return true;
    }
    
    public function actionCollectionAdd() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_BIBLIO_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        if (isset($_POST['name_collection']) && isset($_POST['name_collection_eng']) &&
            isset($_POST['name_publish_house']) && isset($_POST['name_publish_house_eng'])) {

            $nameCollectionRus = $_POST['name_collection'];
            $nameCollectionEng = $_POST['name_collection_eng'];
            $namePublishHouseRus = $_POST['name_publish_house'];
            $namePublishHouseEng = $_POST['name_publish_house_eng'];

            if (Biblio::addCollection($nameCollectionRus, $nameCollectionEng, $namePublishHouseRus, $namePublishHouseEng)) {
                header('Location: ' . PATH . '/biblio/add');
            } else {
                $errors[] = 'Ошибка при добавлении записи в базу данных';
            }
        }

        require_once(ROOT . '/views/biblio/collection/add.php');
        return true;
    }
    
    public function actionAuthorAdd($idBiblioWork) {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_BIBLIO_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        if (isset($_POST['surname']) && isset($_POST['surname_eng']) &&
            isset($_POST['firstname_short']) && isset($_POST['firstname_short_eng']) &&
            isset($_POST['patronymic_short']) && isset($_POST['patronymic_short_eng'])) {

            $surname = $_POST['surname'];
            $surnameEng = $_POST['surname_eng'];
            $firstnameShort = $_POST['firstname_short'];
            $firstnameShortEng = $_POST['firstname_short_eng'];
            $patronymicShort = $_POST['patronymic_short'];
            $patronymicShortEng = $_POST['patronymic_short_eng'];

            if (Biblio::addAuthor($surname, $surnameEng, $firstnameShort, $firstnameShortEng, $patronymicShort, $patronymicShortEng)) {
                header('Location: ' . PATH . '/biblio/finish/' . $idBiblioWork);
            } else {
                $errors[] = 'Ошибка при добавлении данных в базу данных';
            }
        }

        require_once(ROOT . '/views/biblio/author/add.php');
        return true;
    }

    // Добавление литературной ссылки
    public function actionLinkAdd() {

        $errors = false;
        $success = false;

        $nameLink = false;
        $nameLinkEng = false;
        $elink = false;

        $idBiblioFile = false;

        if (isset($_POST['action'])) {
            if (isset($_POST['name_link']) && isset($_POST['elink'])) {

                $nameLink = $_POST['name_link'];

                if (!Check::strLength($nameLink, 6)) {
                    $errors[] = 'Поле "Текст по авторам" должно быть более 6 символов';
                }

                if (isset($_POST['name_link_eng'])) {
                    $nameLinkEng = $_POST['name_link_eng'];
                }

                $elink = $_POST['elink'];
                if (!Check::strLength($elink, 6)) {
                    $errors[] = 'Поле "Ссылка на источник" должно быть более 6 символов';
                }

                if (!$errors) {
                    if ($_FILES) {
                        $uploaddir = ROOT . '/template/files/';

                        $arrayFileName = explode('.', $_FILES['file']['name']);
                        $formatFile = $arrayFileName[count($arrayFileName) - 1];

                        $fileName = basename(substr(md5($_FILES['file']['name'] . time()), 8) . '.' . $formatFile);

                        $uploadfile = $uploaddir . $fileName;
                        move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);

                        $idBiblioFile = BiblioFile::add($fileName);
                    }

                    if (Biblio::addLink($nameLink, $nameLinkEng, $elink, $idBiblioFile)) {
                        $success[] = 'Литературная ссылка была успешно добавлена';
                    }
                }
            } else {
                $errors[] = 'Не все обязательные поля были заполнены';
            }
        }

        require_once(ROOT . '/views/biblio/link/add.php');
        return true;
    }
}