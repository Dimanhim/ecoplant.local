<?php

if ($searchResultProduct) {
    echo '<div class="autocomplete_line">Препараты</div>';
    while ($row = $searchResultProduct->fetch()) {
        echo '<div class="autocomplete_line"><a href="' . PATH . '/pesticide/full-info/id-product-' . $row['id_product'] . '">' . $row['name_product_rus'] . '</a></div>';
    }
}

if ($searchResultSubstance) {
    echo '<div class="autocomplete_line">Действующее вещество</div>';
    while ($row = $searchResultSubstance->fetch()) {
        echo '<div class="autocomplete_line"><a href="' . PATH . '/substance/full-info/id-substance-' . $row['id_substance'] . '">' . $row['name_rus'] . '</a></div>';
    }
}

if (!$searchResultProduct && !$searchResultSubstance) {
    echo '<div class="autocomplete_line">Нет результатов</div>';
}
