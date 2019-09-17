<?php include(ROOT . '/views/layout/header.php'); ?>

  <div class="row">
    <h5>Добавить удобрение</h5>
  </div>
<?php
if (isset($errors) && is_array($errors)) {
  for ($i = 0; $i < count($errors); $i++) { ?>
    <blockquote class="error"><?php echo $errors[$i]; ?></blockquote>
    <?php
  }
}
if (isset($success) && is_array($success)) {
  for ($i = 0; $i < count($success); $i++) { ?>
    <blockquote><?php echo $success[$i]; ?></blockquote>
    <?php
  }
} ?>
  <div class="row">
    <div class="col s12">
      <form method="post">
        <div class="row">
          <div class="col s10">
            <select name="manufacture">
              <option value="" disabled selected>Выберите производителя</option>
              <?php
              if ($manufactureList) {
                while ($row = $manufactureList->fetch()) {
                  $selected = '';
                  if ($idManufacture == $row["id_manufacture"]) {
                    $selected = 'selected';
                  } ?>
                  <option value="<?php echo $row["id_manufacture"]; ?>" <?php echo $selected; ?>><?php echo $row["name_manufacture_rus"]; ?></option>
                  <?php
                }
              }
              ?>
            </select>
          </div>
          <div class="col s2"><a href="<?php echo PATH; ?>/manufacture/add">Добавить производителя</a></div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <select name="fertiliser_group">
              <option value="" disabled selected>Выберите тип удобрения</option>
              <?php
              if ($fertiliserGroupList) {
                while ($row = $fertiliserGroupList->fetch()) {
                  $selected = '';
                  if ($fertiliserGroup == $row['id_grfertiliser']) {
                    $selected = ' selected';
                  } ?>
                  <option
                    value="<?php echo $row['id_grfertiliser']; ?>"<?php echo $selected; ?>><?php echo $row['name_grfertilizer_rus']; ?></option>
                  <?php
                }
              } ?>
            </select>
            <label>Тип удобрения</label>
          </div>
        </div>
        <div class="row">
          <div class="col s12"><h6>Класс удобрения</h6></div>
          <div class="input-field col s11 FertiliserClassList-container">
            <select id="selectFertiliserClass" name="fertiliser_class_ids">
              <?php
              if ($fertiliserClassList) {
                while ($row = $fertiliserClassList->fetch()) {
                  echo "<option value = " . $row["id_clfertiliser"] . ">" . $row["name_clfertilizer_rus"] . "</option>";
                }
              }
              ?>
            </select>
            <label>Добавьте класс удобрения</label>
          </div>
          <div class="input-field col s1">
            <button class="btn light-blue darken-2 fertiliser-class-add-btn"><i class="material-icons">add</i></button>
          </div>
          <div class="col s12 fertiliserClassList">
            <div class="chip light-blue darken-2 white-text">Добавленные классы удобрения:</div>
            <?php
            if ($fertiliserClass) {
              foreach ($fertiliserClass as $fcl) { ?>
                <div class="chip">
                  <input type="hidden" name="fertiliser_class[]" value="<?php echo $fcl; ?>">
                  <span class="fertiliser_class" data-tara-id="<?php echo $fcl; ?>"></span>
                  <i class="close material-icons">close</i>
                </div>
                <?php
              }
            } ?>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input id="fertiliser_name" name="fertiliser_name" placeholder="Название" type="text" class="validate"
                   data-name-letter="id_letter" value="<?php echo $fertiliserName; ?>">
            <label for="fertiliser_name">Название удобрения</label>
          </div>
        </div>
        <div class="row letter-container">
          <div class="col s12">
            <input type="hidden" name="id_letter" value="<?php echo $idLetter; ?>">
            <p>Выберите русскую букву алфавита</p>
            <?php
            if ($rusLetterList) {
              while ($row = $rusLetterList->fetch()) {
                if ($idLetter == $row["id_alphabet_rus"]) { ?>
                  <a href="javascript:void();" class="chip letter-select select"
                     data-id-letter="<?php echo $row["id_alphabet_rus"]; ?>"><?php echo $row["letter"]; ?></a>
                  <?php
                } else { ?>
                  <a href="javascript:void();" class="chip letter-select"
                     data-id-letter="<?php echo $row["id_alphabet_rus"]; ?>"><?php echo $row["letter"]; ?></a>
                  <?php
                }
              }
            }
            ?>
          </div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <select name="countries">
              <?php
              if ($countriesList) {
                while ($row = $countriesList->fetch()) {
                  $selected = '';
                  if ($countries == $row['id_countrycode']) {
                    $selected = 'selected';
                  }
                  ?>
                  <option value="<?php echo $row['id_countrycode']; ?>"<?php echo $selected; ?>><?php echo $row['name']; ?></option>
                  <?php
                }
              } ?>
            </select>
            <label>Страна регистрации</label>
          </div>
        </div>

        <div class="row">
          <div class="col s12"><h5>Упаковки</h5></div>
          <div class="input-field col s11 taraList-container">
            <select id="selectTara" name="tara_ids">
              <?php
              if ($packAndTaraList) {
                while ($row = $packAndTaraList->fetch()) {
                  echo "<option value = " . $row["id_product_tara"] . ">" . $row["pack_and_tara"] . "</option>";
                }
              }
              ?>
            </select>
            <label>Введите упаковку</label>
          </div>
          <div class="input-field col s1">
            <button class="btn light-blue darken-2 tara-add-btn"><i class="material-icons">add</i></button>
          </div>
          <div class="col s12 taraList">
            <div class="chip light-blue darken-2 white-text">Добавленные упаковки:</div>
            <?php if ($tara && is_array($tara)) {
              foreach ($tara as $t) { ?>
                <div class="chip">
                  <input type="hidden" name="tara[]" value="<?php echo $t; ?>">
                  <span class="tara" data-tara-id="<?php echo $t; ?>"></span>
                  <i class="close material-icons">close</i>
                </div>
                <?php
              }
            } ?>
          </div>
        </div>

        <div class="row">
          <div class="col s12 center">
            <button class="waves-effect waves-light btn light-blue darken-2" type="submit" name="actionAdd">
              <i class="material-icons right">add</i>Добавить
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

<?php include(ROOT . '/views/layout/footer.php'); ?>