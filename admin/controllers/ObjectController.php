<?php

class ObjectController {
    public function actionAdd() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        $idLetterRus = false;
        $nameObjectRus = false;
        $nameObjectEng = false;
        $idObjectClass = false;
        $idCultureList = false;

        if (isset($_POST['rnameobject']) && isset($_POST['engnameobject']) &&
            isset($_POST['id_letter']) && isset($_POST['id_clobject']) &&
            isset($_POST['selectCulture'])) {

            $nameObjectRus = $_POST["rnameobject"];
            $idLetterRus = $_POST['id_letter'];
            $nameObjectEng = $_POST["engnameobject"];
            $idObjectClass = $_POST['id_clobject'];
            $idCultureList = $_POST['selectCulture'];

            // Вставить данные в таблицу Объект
            if (Object::add($nameObjectRus, $nameObjectEng, $idObjectClass)) {
                $idObject = Object::getId($nameObjectRus, $nameObjectEng, $idObjectClass);

                if (Object::addAndAlphabetRus($idObject, $idLetterRus)) {
                    for ($i = 0; $i < count($idCultureList); $i++) {
                        Object::addAndCulture($idObject, $idCultureList[$i]);
                    }

                    $success[] = "Объект \"$nameObjectRus\" успешно добавлен";
                } else {
                    $errors[] = 'Ошибка ввода данных. Напишите Администратору.';
                }
            } else {
                $errors[] = 'Ошибка ввода данных. Напишите Администратору.';
            }
        }

        $objectClassListSQL = ObjectClass::getListSQL();
        $rusLetterListSQL = Letter::getRusListSQL();
        $cultureListSQL = Culture::getListSQL('name_rus');

        require_once(ROOT . '/views/object/add.php');
        return true;
    }
    
    public function actionGroupAdd() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        $nameRus = false;
        $nameEng = false;
        $idProductClass = false;
        $idObjectList = false;

        if (isset($_POST['rnamegrobject']) && isset($_POST['clproduct']) && isset($_POST['selectObject'])) {

            $nameRus = $_POST["rnamegrobject"];
            if(isset($_POST["engnamegrobject"])) $nameEng = $_POST["engnamegrobject"];
            else $nameEng = '';
            
            $idProductClass = $_POST['clproduct'];
            $idObjectList = $_POST['selectObject'];

            if (ObjectGroup::add($idProductClass, $nameRus, $nameEng)) {
                $idObjectGroup = ObjectGroup::getId($idProductClass, $nameRus, $nameEng);

                for ($i = 0; $i < count($idObjectList); $i++) {
                    Object::addAndObjectGroup($idObjectList[$i], $idObjectGroup);
                }

                header('Location: ' . PATH . '/object/group/select/' . $idProductClass);
            } else {
                $errors[] = 'Ошибка ввода данных. Напишите Администратору.';
            }
        }

        $productClassListSQL = ProductClass::getListSQL('name_clproduct_rus');
        $objectListSQL = Object::getListSQL('rnameobject');

        require_once(ROOT . '/views/object/group/add.php');
        return true;
    }
    
    public function actionGroupSelect($idProductClass) {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        $nameProductClass = ProductClass::getNameById($idProductClass);
        $productListSQL = Product::getListByIdProductClassSQL($idProductClass, 'name');

        require_once(ROOT . '/views/object/group/select.php');
        return true;
    }
    
    public function actionGroupMerge() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $idProduct = false;
        $regDataListSQL = false;
        $objectGroupListSQL = false;

        if (isset($_POST['idProduct'])) {
            $idProduct = $_POST['idProduct'];

            $regDataListSQL = RegData::getListByIdProductSQL($idProduct, 'name');
            $objectGroupListSQL = ObjectGroup::getListByIdProductSQL($idProduct, 'name');
        }

        if (isset($_POST['regdata']) && isset($_POST['grobject'])) {
            $idRegData = $_POST['regdata'];
            $idObjectGroupList = $_POST['grobject'];

            RegData::deleteAndObjectGroupAll($idRegData);
            for ($i = 0; $i < count($idObjectGroupList); $i++) {
                RegData::addAndObjectGroup($idRegData, $idObjectGroupList[$i]);
            }
        }

        require_once(ROOT . '/views/object/group/merge.php');
        return true;
    }
    
    public function actionImage($idObject = false) {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        $countMaxPhoto = Object::getCountMaxPhoto();

        $avatarId = -1;
        $countPhotos = 0;
        $objectPhotoList = false;

        $showPhotoList = false;
        if ($idObject) {
            $_SESSION['idObjectImg'] = $idObject;

            $countPhotos = Object::countAndImage($idObject);
            $objectPhotoListSQL = Object::getAndImage($idObject);
            $avatarIdListSQL = Object::getAndImageIdAvatar($idObject);

            $showPhotoList = true;
        }

        $objectListSQL = Object::getListSQL('name');
        $cultureListSQL = Culture::getListByIdObject($idObject);
        $tagForSelectListSQL = Tag::getListForSelectSQL();

        require_once(ROOT . '/views/object/image/add.php');
        return true;
    }
    public function actionImageParam() {
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            die;
        }

        if (isset($_POST['id'])) {
            $idImage = $_POST['id'];
            $desc = $_POST['desc'];
            $tagList = $_POST['tagList'];
            $idCulture = $_POST['idCulture'];

            if ($desc) {
                Object::updateAndImageDesc($_SESSION['idObjectImg'], $idImage, $desc);
            }
            if (Tag::deleteByIdImage($idImage)) {
                $tagList = trim($tagList, ', ');
                if ($tagList != '') {
                    $tagListArr = explode(',', $tagList);
                    if (count($tagListArr) <= 20) {
                        for ($i = 0; $i < count($tagListArr); $i++) {
                            Tag::add($idImage, $tagListArr[$i]);
                        }
                    }
                }
            }
            if ($idCulture && Check::isInt($idCulture)) {
                Object::updateAndImageIdCulture($_SESSION['idObjectImg'], $idImage, $idCulture);
            }

            echo 'ok';
        }

        return true;
    }
    public function actionImageAvatar() {
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            die;
        }

        if (isset($_POST['id'])) {
            $idImage = $_POST['id'];
            $idCulture = $_POST['idCulture'];

            $idAvatarOld = Object::getAndImageIdAvatar($_SESSION['idObjectImg'], $idCulture);
            Object::updateAndImageAvatarByIdCulture('0', $_SESSION['idObjectImg'], $idCulture);

            if (Object::updateAndImageAvatar('1', $_SESSION['idObjectImg'], $idImage)) {
                echo $idAvatarOld->fetch()['id'];
            } else {
                echo 'err';
            }
        }

        return true;
    }
    public function actionImageDelete() {
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            die;
        }

        if (isset($_POST['id'])) {
            $idImage = $_POST['id'];

            if (Object::deleteAndImage($idImage, $_SESSION['idObjectImg'])) {
                echo 'ok';
            }
        }

        return true;
    }
    public function actionImagePost() {
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            die;
        }

        if ($_FILES) {
            $uploaddir = ROOT . '/../template/img/object/';

            $arrayFileName = explode('.', $_FILES['photo']['name']);
            $formatFile = $arrayFileName[count($arrayFileName) - 1];

            $fileName = basename(substr(md5($_FILES['photo']['name'] . time()), 8) . '.' . $formatFile);

            $uploadfile = $uploaddir . $fileName;
            move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile);

            Object::addAndImage($_SESSION['idObjectImg'], $fileName);
        }

        return true;
    }

    public function actionImagePublish() {
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            die;
        }

        if (isset($_POST['id'])) {
            $idObjectAndImage = $_POST['id'];
            $idObject = $_POST['idObject'];
            $idCulture = $_POST['idCulture'];

            Object::publishAndImage($idObjectAndImage);
            $infoUser = Object::getAndImageInfo($idObjectAndImage);
            if ($infoUser) {
                if (isset($infoUser['email']) && $infoUser['email'] != '') {
                    Mail::sendAboutPublishImage($infoUser['email'], $infoUser['name'], $idObject, $idCulture);
                }
            }

            echo 'success:';
        }

        return true;
    }
    
    // Страница со списком изображений от пользователей
    public function actionUserImage() {

        $errors = false;
        $success = false;

        // Удаление изображения
        if (isset($_POST['actionDelete']) && isset($_POST['id']) && isset($_POST['idObject'])) {
            $idObjectAndImage = $_POST['id'];
            $idObject = $_POST['idObject'];

            if (!Check::isInt($idObjectAndImage)) {
                $errors[] = 'Изображение объекта было выбрано некорректно';
            }
            if (!Check::isInt($idObject)) {
                $errors[] = 'Изображение объекта было выбрано некорректно';
            }

            $fileName = Object::getFileNameByIdAndImage($idObjectAndImage);

            if (!$errors) {
                if (Object::deleteAndImage($idObjectAndImage, $idObject) && Object::deleteAndImageInfo($idObjectAndImage)) {
                    $success[] = 'Изображение пользователя было успешно удалено';
                    unlink(ROOT . '/template/img/object/' . $fileName);
                }
            }
        }

        // Публикация изображения
        if (isset($_POST['actionPublish']) && isset($_POST['id'])) {
            $idObjectAndImage = $_POST['id'];
            $idObject = $_POST['idObject'];
            $idCulture = $_POST['idCulture'];

            Object::publishAndImage($idObjectAndImage);
            $infoUser = Object::getAndImageInfo($idObjectAndImage);
            if ($infoUser) {
                if (isset($infoUser['email']) && $infoUser['email'] != '') {
                    Mail::sendAboutPublishImage($infoUser['email'], $infoUser['name'], $idObject, $idCulture);
                }
            }

            $success[] = 'Изображение пользователя было опубликовано';
        }

        $objectImageList = Object::getAndImageNotShowList();

        require_once(ROOT . '/views/object/image/userImageList.php');
        return true;
    }

    // Страница редактирования описаний
    public function actionDescEdit() {
        Admin::checkSignInAccess();
        if (!UserGroup::accessAdminBlockByIdUser(ACCESS_OBJECT_FUNC, User::getId())) {
            Admin::accessDenied();
        }

        $errors = false;
        $success = false;

        $objectId = false;

        $descBiology = false;
        $idDescBiologyBiblioLink = false;
        $idDescBiologyBiblioLinkAutocomplete = false;

        $descDevelopment = false;
        $idDescDevelopmentBiblioLink = false;
        $idDescDevelopmentBiblioLinkAutoComplete = false;

        $descSignificance = false;
        $idDescSignificanceBiblioLink = false;
        $idDescSignificanceBiblioLinkAutocomplete = false;

        $descSymptoms = false;
        $idDescSymptomsBiblioLink = false;
        $idDescSymptomsBiblioLinkAutoComplete = false;

        if (isset($_POST['action'])) {
            $objectId = $_POST['objectId'];

            if (Check::isInt($objectId)) {
                if (isset($_POST['desc_biology'])) {
                    $descBiology = $_POST['desc_biology'];
                    $idDescBiologyBiblioLink = $_POST['desc_biology_biblio_link'];
                    $idDescBiologyBiblioLinkAutocomplete = $_POST['desc_biology_biblio_link-autocomplete'];
                    if ($descBiology && $idDescBiologyBiblioLink && $idDescBiologyBiblioLinkAutocomplete) {
                        for ($i = 0; $i < count($descBiology); $i++) {
                            if (!Check::strLength($descBiology[$i], 6)) {
                                $errors[] = 'Описание биологии объекта №' . ($i + 1) . ' должно быть более 6 символов';
                            }
                            if (!Check::isInt($idDescBiologyBiblioLink[$i]) || !$idDescBiologyBiblioLinkAutocomplete[$i]) {
                                $errors[] = 'Не выбран литературный источник для описания биологии объекта №' . ($i + 1);
                            }
                        }
                        if (!$errors) {
                            Object::delDescBiology($objectId);

                            for ($i = 0; $i < count($descBiology); $i++) {
                                if (Object::saveDescBiology($objectId, $idDescBiologyBiblioLink[$i], $descBiology[$i])) {
                                    $success[] = 'Описание биологии объекта №' . ($i + 1) . ' успешно сохранено';
                                }
                            }
                        }
                    }
                } else {
                    Object::delDescBiology($objectId);
                    $descBiology = 'delete';
                }

                if (isset($_POST['desc_development'])) {
                    $descDevelopment = $_POST['desc_development'];
                    $idDescDevelopmentBiblioLink = $_POST['desc_development_biblio_link'];
                    $idDescDevelopmentBiblioLinkAutoComplete = $_POST['desc_development_biblio_link-autocomplete'];
                    if ($descDevelopment && $idDescDevelopmentBiblioLink && $idDescDevelopmentBiblioLinkAutoComplete) {
                        for ($i = 0; $i < count($descDevelopment); $i++) {
                            if (!Check::strLength($descDevelopment[$i], 6)) {
                                $errors[] = 'Описание развития поражения №' . ($i + 1) . ' должно быть более 6 символов';
                            }
                            if (!Check::isInt($idDescDevelopmentBiblioLink[$i]) || !$idDescDevelopmentBiblioLinkAutoComplete[$i]) {
                                $errors[] = 'Не выбран литературный источник для описания развития поражения №' . ($i + 1);
                            }
                        }
                        if (!$errors) {
                            Object::delDescDevelopment($objectId);

                            for ($i = 0; $i < count($descDevelopment); $i++) {
                                if (Object::saveDescDevelopment($objectId, $idDescDevelopmentBiblioLink[$i], $descDevelopment[$i])) {
                                    $success[] = 'Описание развития поражения №' . ($i + 1) . ' успешно сохранено';
                                }
                            }
                        }
                    }
                } else {
                    Object::delDescDevelopment($objectId);
                    $descDevelopment = 'delete';
                }

                if (isset($_POST['desc_significance'])) {
                    $descSignificance = $_POST['desc_significance'];
                    $idDescSignificanceBiblioLink = $_POST['desc_significance_biblio_link'];
                    $idDescSignificanceBiblioLinkAutocomplete = $_POST['desc_significance_biblio_link-autocomplete'];
                    if ($descSignificance && $idDescSignificanceBiblioLink && $idDescSignificanceBiblioLinkAutocomplete) {
                        for ($i = 0; $i < count($descSignificance); $i++) {
                            if (!Check::strLength($descSignificance[$i], 6)) {
                                $errors[] = 'Описание экономического значения №' . ($i + 1) . ' должно быть более 6 символов';
                            }
                            if (!Check::isInt($idDescSignificanceBiblioLink[$i]) || !$idDescSignificanceBiblioLinkAutocomplete[$i]) {
                                $errors[] = 'Не выбран литературный источник для описания экономического значения №' . ($i + 1);
                            }
                        }
                        if (!$errors) {
                            Object::delDescSignificance($objectId);

                            for ($i = 0; $i < count($descSignificance); $i++) {
                                if (Object::saveDescSignificance($objectId, $idDescSignificanceBiblioLink[$i], $descSignificance[$i])) {
                                    $success[] = 'Описание экономического значения №' . ($i + 1) . ' успешно сохранено';
                                }
                            }
                        }
                    }
                } else {
                    Object::delDescSignificance($objectId);
                    $descSignificance = 'delete';
                }

                if (isset($_POST['desc_symptoms'])) {
                    $descSymptoms = $_POST['desc_symptoms'];
                    $idDescSymptomsBiblioLink = $_POST['desc_symptoms_biblio_link'];
                    $idDescSymptomsBiblioLinkAutoComplete = $_POST['desc_symptoms_biblio_link-autocomplete'];
                    if ($descSymptoms && $idDescSymptomsBiblioLink && $idDescSymptomsBiblioLinkAutoComplete) {
                        for ($i = 0; $i < count($descSymptoms); $i++) {
                            if (!Check::strLength($descSymptoms[$i], 6)) {
                                $errors[] = 'Описание симптомов №' . ($i + 1) . ' должно быть более 6 символов';
                            }
                            if (!Check::isInt($idDescSymptomsBiblioLink[$i]) || !$idDescSymptomsBiblioLinkAutoComplete[$i]) {
                                $errors[] = 'Не выбран литературный источник для описания симптомов №' . ($i + 1);
                            }
                        }
                        if (!$errors) {
                            Object::delDescSymptoms($objectId);

                            for ($i = 0; $i < count($descSymptoms); $i++) {
                                if (Object::saveDescSymptoms($objectId, $idDescSymptomsBiblioLink[$i], $descSymptoms[$i])) {
                                    $success[] = 'Описание симптомов №' . ($i + 1) . ' успешно сохранено';
                                }
                            }
                        }
                    }
                } else {
                    Object::delDescSymptoms($objectId);
                    $descSymptoms = 'delete';
                }
            } else {
                $errors[] = 'Объект был выбран некорректно';
            }
        }

        $objectListSQL = Object::getListSQL('name');
        $biblioLinkSQL = Biblio::getListLinkSQL();

        require_once(ROOT . '/views/object/desc/edit.php');
        return true;
    }
    // Получения описаний по post запросу
    public function actionGetInfo() {
        if (isset($_POST['idObject'])) {
            $idObject = $_POST['idObject'];

            if (Check::isInt($idObject)) {
                echo json_encode(Object::getDescFull($idObject));
            }
        }

        return true;
    }
}