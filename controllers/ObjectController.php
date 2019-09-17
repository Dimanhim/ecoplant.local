<?php

class ObjectController {
    public function actionIndex() {
        $firstLetterObjectListSQL = Letter::getFirstLetterObjectListSQL();
        $cultureClassByExistObjectSQL = CultureClass::getListContainObject();
//        $cultureWithoutGroupSQL = Culture::getListWithoutCultureGroup();

        require_once(ROOT . '/views/object/index.php');
        return true;
    }

    public function actionListByAlphabet() {
        $firstLetterObjectListSQL = Letter::getFirstLetterObjectListSQL();

        require_once(ROOT . '/views/object/listByAlphabet.php');
        return true;
    }
    public function actionListByCulture($idCulture) {
        $cultureName = Culture::getNameById($idCulture);
        $objectClassListSQL = Object::getObjectClassListByIdCulture($idCulture);
        $objectListWithoutObjectClassSQL = Object::getListByIdCultureAndIdObjectClassSQL($idCulture, 0);

        require_once(ROOT . '/views/object/listByCulture.php');
        return true;
    }

    public function actionObject($idObject, $idCulture = 0) {

        $errors = false;
        $success = false;
        $name = false;
        $email = false;

        if (isset($_POST['actionAddImageObject'])) {
            if (isset($_POST['name']) && trim($_POST['name']) != '') {
                $name = $_POST['name'];
                if (!Check::strLength($name, 4, 32)) {
                    $errors[] = 'Поле "Ваше имя" должно быть более 4 и не более 32 символов';
                }
            }

            if (isset($_POST['email']) && trim($_POST['email']) != '') {
                $email = $_POST['email'];
                if (!Check::valideEmail($email)) {
                    $errors[] = 'Поле "Ваш Email" было некорректно заполнено';
                }
            }

            if (!$_FILES || $_FILES['photo']['size'] == 0) {
                $errors[] = 'Не был выбран файл изображения';
            }

            if ($_FILES['photo']['size'] > 5242880) {
                $errors[] = 'Файл имеет слишком большой размер (Разрешено не более 5 Мбайт)';
            }

            $valid_extensions = array('gif', 'jpg', 'png');

            if(!$image_info = Check::get_image_info($_FILES['photo']['tmp_name']) or !in_array($image_info['extension'], $valid_extensions)) {
                $errors[] = 'Файл имеет недопустимый формат. Разрешены форматы gif, jpg, png';
            }

            if (!$errors) {
                $uploaddir = ROOT . '/template/img/object/';

                $arrayFileName = explode('.', $_FILES['photo']['name']);
                $formatFile = $arrayFileName[count($arrayFileName) - 1];

                $fileName = basename(substr(md5($_FILES['photo']['name'] . time()), 8) . '.' . $formatFile);

                $uploadfile = $uploaddir . $fileName;
                move_uploaded_file($_FILES['photo']['tmp_name'], $uploadfile);

                $fontFilePath = ROOT . "/template/fonts/roboto/Roboto-Regular.ttf";
                $fontSize = 18;
                $paddingSize = 20;

                // Получаем информацию о изображении
                list($width, $height, $type, $attr) = getimagesize($uploadfile);

                // Получаем информацию о рамке с текстом
                $arrayFontBox = imagettfbbox($fontSize, 0, $fontFilePath, $name);
                $widthFontBox = $arrayFontBox[2] - $arrayFontBox[0];
                if ($width < $widthFontBox * 2) {
                    $fontSize = 12;
                    $paddingSize = 14;
                    $arrayFontBox = imagettfbbox($fontSize, 0, $fontFilePath, $name);
                    $widthFontBox = $arrayFontBox[2] - $arrayFontBox[0];
                }

                $pic = false;
                switch ($image_info['extension']) {
                    case 'jpg':
                        $pic = ImageCreateFromjpeg($uploadfile); //открываем рисунок в формате JPEG
                        break;
                    case 'gif':
                        $pic = ImageCreateFromgif($uploadfile); //открываем рисунок в формате JPEG
                        break;
                    case 'png':
                        $pic = ImageCreateFrompng($uploadfile); //открываем рисунок в формате JPEG
                        break;
                }

                if ($pic) {
                    $color = ImageColorAllocate($pic, 255, 255, 255); //получаем идентификатор цвета
                    /* определяем место размещения текста по вертикали и горизонтали */
                    /* выводим текст на изображение */

                    ImageTTFtext($pic, $fontSize, 0, $width - $widthFontBox - $paddingSize, $height - $paddingSize, $color, $fontFilePath, $name);
                    Imagejpeg($pic, $uploadfile); //сохраняем рисунок в формате JPEG
                    ImageDestroy($pic); //освобождаем память и закрываем изображение

                    $idObjectAndImage = Object::addAndImage($idObject, $idCulture, $fileName, 0);
                    if ($idObjectAndImage) {
                        if (Object::addAndImageInfo($idObjectAndImage, $name, $email)) {
                            $success[] = 'Изображение было успешно загружено. Оно будет опубликовано после проверки модератором.';
                        }
                    }
                }
            }
        }

        $object = Object::getById($idObject);
        $speciesListSQL = Species::getListByIdObjectSQL($idObject);
        $cultureListSQL = Culture::getListByIdObjectSQL($idObject);

        $countPhotos = Object::getCountAndImage($idObject, $idCulture);
        $objectPhotoListSQL = Object::getAndImageByIdCulture($idObject, $idCulture);
        $objectPhotoAvatar = Object::getAndImageAvatarByIdCulture($idObject, $idCulture);

        $objectDescBiology = Object::getDescBiology($idObject);
        $objectDescDevelop = Object::getDescDevelop($idObject);
        $objectDescSignif = Object::getDescSignif($idObject);
        $objectDescSymptoms = Object::getDescSymptoms($idObject);

        if ($idCulture != 0) {
            $productBiotarget = Product::getListContainBiotarget($idObject, $idCulture);
        } else {
            $cultureBiotarget = Culture::getListContainBiotarget($idObject);
        }

        $productListSQL = Product::getListByIdObject($idObject);

        require_once(ROOT . '/views/object/object.php');
        return true;
    }
}