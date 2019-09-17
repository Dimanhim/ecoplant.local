<?php

class ElementController
{
    public function actionAdd() {

        $errors = false;
        $success = false;

        $name = false;
        $chemFormula = false;

        if (isset($_POST['actionAdd'])) {
            if (isset($_POST['name']) && $_POST['name']) {
                $name = $_POST['name'];
            }

            if (!Check::strLength($name, 4)) {
                $errors[] = 'Название элемента должно быть более 4 символов';
            }

            if (isset($_POST['chemformulation']) && $_POST['chemformulation']) {
                $chemFormula = $_POST['chemformulation'];
            }

            if (!trim($chemFormula)) {
                $errors[] = 'Поле "Химический элемент" не должно быть пустым';
            }

            if (Element::getByName($name)) {
                $errors[] = 'Элемент с таким названием уже существует в базе данных';
            }
            if (Element::getByChemFormula($chemFormula)) {
                $errors[] = 'Элемент с такой химической формулой уже существует в базе данных';
            }

            if (!$errors) {
                if (Element::add($name, $chemFormula)) {
                    $success[] = 'Элемент "' . $name . '" был успешно добавлен';

                    $name = false;
                    $chemFormula = false;
                } else {
                    $errors[] = 'Возникла неизвестная ошибка';
                }
            }
        }

        $elementList = Element::getList();

        require_once(ROOT . '/views/element/add.php');
        return true;
    }
}