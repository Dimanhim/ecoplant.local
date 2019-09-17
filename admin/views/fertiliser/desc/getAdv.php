<?php

if ($descAdvList) {
    while ($row = $descAdvList->fetch()) { ?>
        <div class="chip">
            <input type="hidden" name="descAdv[]"
                   value="<?php echo $row['desc_advantage']; ?>"><?php echo $row['desc_advantage']; ?>
            <i class="close material-icons">close</i>
        </div>
        <?php
    }
}