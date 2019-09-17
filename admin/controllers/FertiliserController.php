<?php

class FertiliserController {
  // Добавление удобрения
  public function actionAdd() {

    $errors = false;
    $success = false;

    $idManufacture = false;
    $fertiliserGroup = false;
    $fertiliserClass = false;
    $fertiliserName = false;
    $idLetter = false;
    $countries = false;
    $tara = false;

    if (isset($_POST['actionAdd'])) {
      if (isset($_POST['manufacture']) && $_POST['manufacture']) {
        $idManufacture = $_POST['manufacture'];
      } else {
        $errors[] = 'Производитель не был выбран';
      }

      if (isset($_POST['fertiliser_group']) && $_POST['fertiliser_group']) {
        $fertiliserGroup = $_POST['fertiliser_group'];
      } else {
        $errors[] = 'Тип удобрения не был выбран';
      }

      if (isset($_POST['fertiliser_class']) && $_POST['fertiliser_class'] && is_array($_POST['fertiliser_class'])) {
        $fertiliserClass = $_POST['fertiliser_class'];
      } else {
        $errors[] = 'Ни один класс удобрения не был выбран';
      }

      $fertiliserName = $_POST['fertiliser_name'];
      if (!Check::strLength($fertiliserName, 3)) {
        $errors[] = 'Название удобрения должно быть более 3 символов';
      }

      $idLetter = $_POST['id_letter'];
      if (!Check::isInt($idLetter)) {
        $errors[] = 'Буква алфавита была выбрана некорректно';
      }
      $countries = $_POST['countries'];
      if (!Check::isInt($countries)) {
        $errors[] = 'Страна регистрации была выбрана некорректно';
      }

      if (isset($_POST['tara']) && $_POST['tara']) {
        $tara = $_POST['tara'];
      } else {
        $errors[] = 'Упаковка не была выбрана';
      }

      if (!$errors) {
        // TODO Удалить старый вызов модели
        // TODO Удалить поле fertiliser.id_product_tara из таблицы базы данных и везде из моделей
//        $idFertiliser = Fertiliser::add($idManufacture, $fertiliserGroup, $idLetter, $fertiliserName, $countries, $tara);
        $idFertiliser = Fertiliser::add($idManufacture, $fertiliserGroup, $idLetter, $fertiliserName, $countries);
        if ($idFertiliser) {
          for ($i = 0; $i < count($fertiliserClass); $i++) {
            Fertiliser::addFertiliserClass($idFertiliser, $fertiliserClass[$i]);
          }

          for ($i = 0; $i < count($tara); $i++) {
            Fertiliser::addAndTara($idFertiliser, $tara[$i]);
          }

          header('Location: ' . PATH . '/fertiliser/element/add/' . $idFertiliser);
        } else {
          $errors[] = 'Возникла неизвестная ошибка';
        }
      }
    }

    $manufactureList = Manufacture::getListSQL('name');
    $fertiliserClassList = FertiliserClass::getList();
    $fertiliserGroupList = FertiliserGroup::getList();
    $countriesList = Countries::getList();
    $packAndTaraList = PackAndTara::getListSQL('name');
    $rusLetterList = Letter::getRusListSQL();

    require_once(ROOT . '/views/fertiliser/add.php');
    return true;
  }

  public function actionAddElement($idFertiliser) {

    $errors = false;
    $success = false;

    $concentration = false;
    $idSubstanceUnit = false;

    if (isset($_POST['actionAdd'])) {

      $elementArr = array();

      if (isset($_POST['concentration']) && $_POST['concentration'] && is_array($_POST['concentration'])) {
        $concentration = $_POST['concentration'];
        for ($i = 0; $i < count($concentration); $i++) {
          if (isset($_POST['element_' . $i]) && $_POST['element_' . $i] && isset($_POST['element_' . $i . '-autocomplete']) && $_POST['element_' . $i . '-autocomplete']) {
            $elementArr[$i] = $_POST['element_' . $i];
          }

        }
      }

      if (isset($_POST['idSubstanceUnit']) && $_POST['idSubstanceUnit'] && is_array($_POST['idSubstanceUnit'])) {
        $idSubstanceUnit = $_POST['idSubstanceUnit'];
      }

      if (count($concentration) == count($idSubstanceUnit) && count($idSubstanceUnit) == count($elementArr)) {
        foreach ($elementArr as $index => $item) {
          Fertiliser::addAndElement($idFertiliser, $item, $concentration[$index], $idSubstanceUnit[$index]);
        }
        $success[] = 'Все данные были сохранены';
      } else {
        $errors[] = 'Не все поля заполнены';
      }
    }

    $fertiliserClass = FertiliserClass::getListByIdFertiliser($idFertiliser);
    $fertiliserClassArray = array();
    if ($fertiliserClass) {
      while ($row = $fertiliserClass->fetch()) {
        $fertiliserClassArray[] = $row['id_clfertiliser'];
      }
    }
    $elementList = Element::getListByFertiliserClassArray($fertiliserClassArray);
    $substanceUnitList = Substance::getUnitListSQL();

    require_once(ROOT . '/views/fertiliser/element/add.php');
    return true;
  }

  // Добавление регистрационной информации
  public function actionRegData() {

    $errors = false;
    $success = false;

    $idFertiliser = false;
    $selectCulture = false;
    $min_rate = false;
    $max_rate = false;
    $reglament = false;

    if (isset($_POST['actionAdd'])) {
      if (isset($_POST['idFertiliser']) && $_POST['idFertiliser'] && isset($_POST['idFertiliser-autocomplete']) && $_POST['idFertiliser-autocomplete']) {
        $idFertiliser = $_POST['idFertiliser'];
      } else {
        $errors[] = 'Удобрение не было выбрано';
      }

      if (isset($_POST['selectCulture']) && is_array($_POST['selectCulture'])) {
        $selectCulture = $_POST['selectCulture'];
      } else {
        $errors[] = 'Не была выбрана ни одна культура';
      }

      if (isset($_POST['min_rate']) && $_POST['min_rate']) {
        $min_rate = $_POST['min_rate'];
      } else {
        $errors[] = 'Не была введена минимальная норма';
      }

      if (isset($_POST['max_rate']) && $_POST['max_rate']) {
        $max_rate = $_POST['max_rate'];
      } else {
        $errors[] = 'Не была введена максимальная норма';
      }

      if (isset($_POST['reglament']) && $_POST['reglament']) {
        $reglament = $_POST['reglament'];
      }

      if (!$errors) {
        for ($i = 0; $i < count($selectCulture); $i++) {
          Fertiliser::addRegData($idFertiliser, $selectCulture[$i], $min_rate, $max_rate, $reglament);
        }

        $success[] = 'Регистрационная информация была успешно добавлена';

        $selectCulture = false;
        $min_rate = false;
        $max_rate = false;
        $reglament = false;
      }
    }

    $fertiliserList = Fertiliser::getList();
    $cultureList = Culture::getListSQL();

    require_once(ROOT . '/views/fertiliser/regdata/add.php');
    return true;
  }

  // Добавление описания
  public function actionAddDesc() {

    $errors = false;
    $success = false;

    $idFertiliser = false;
    $desc = false;

    if (isset($_POST['actionAdd'])) {
      if (isset($_POST['idFertiliser']) && $_POST['idFertiliser'] && isset($_POST['idFertiliser-autocomplete']) && $_POST['idFertiliser-autocomplete']) {
        $idFertiliser = $_POST['idFertiliser'];
      } else {
        $errors[] = 'Удобрение не было выбрано';
      }

      if (isset($_POST['desc']) && $_POST['desc']) {
        $desc = $_POST['desc'];
        if (!Check::strLength($desc, 6)) {
          $errors[] = 'Описание удобрения должно быть более 6 символов';
        }
      }

      if (!$errors) {
        Fertiliser::addDecs($idFertiliser, $desc);

        $success[] = 'Описание удобрения было успешно добавлено';

        $idFertiliser = false;
        $desc = false;
      }
    }

    $fertiliserList = Fertiliser::getList();

    require_once(ROOT . '/views/fertiliser/desc/add.php');
    return true;
  }

  // Добавление описания преимущества удобрения
  public function actionAddDescAdv() {

    $errors = false;
    $success = false;

    $idFertiliser = false;
    $descAdvArr = false;

    if (isset($_POST['actionAdd'])) {
      if (isset($_POST['idFertiliserAdv']) && $_POST['idFertiliserAdv'] && isset($_POST['idFertiliserAdv-autocomplete']) && $_POST['idFertiliserAdv-autocomplete']) {
        $idFertiliser = $_POST['idFertiliserAdv'];
      } else {
        $errors[] = 'Удобрение не было выбрано';
      }

      if (isset($_POST['descAdv']) && is_array($_POST['descAdv'])) {
        $descAdvArr = $_POST['descAdv'];
      }

      if (!$errors) {
        Fertiliser::deleteDescAdv($idFertiliser);
        for ($i = 0; $i < count($descAdvArr); $i++) {
          Fertiliser::addDecsAdv($idFertiliser, $descAdvArr[$i]);
        }

        $success[] = 'Описания преимуществ удобрения были успешно добавлены';

        $idFertiliser = false;
        $descAdvArr = false;
      }
    }

    $fertiliserList = Fertiliser::getList();

    require_once(ROOT . '/views/fertiliser/desc/addAdv.php');
    return true;
  }

  public function actionGetDescAdv($idFertiliser) {

    $descAdvList = Fertiliser::getDescAdvList($idFertiliser);

    require_once(ROOT . '/views/fertiliser/desc/getAdv.php');
    return true;
  }
}