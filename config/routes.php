<?php

return array(
    'search' => 'search/search',

    'species/id-species-([0-9]+)' => 'species/index/$1',

    // Вредные объекты
    'object/object-([0-9]+)/culture-([0-9]+)' => 'object/object/$1/$2',
    'object/object-([0-9]+)' => 'object/object/$1',
    'object/id-alphabet' => 'object/listByAlphabet',
    'object/id-culture-([0-9]+)' => 'object/listByCulture/$1',
    'object' => 'object/index',

    // Пестициды
    'pesticide/id-alphabet-([0-9]+)' => 'pesticide/listByAlphabet/$1',
    'pesticide/id-culture-group-([0-9]+)' => 'pesticide/listByCultureGroup/$1',
    'pesticide/id-manufacture-([0-9]+)' => 'pesticide/listByManufacture/$1',
    'pesticide/info/id-product-([0-9]+)/id-culture-([0-9]+)' => 'pesticide/info/$1/$2',
    'pesticide/full-info/id-product-([0-9]+)' => 'pesticide/fullInfo/$1',
    'pesticide/product-class-([0-9]+)' => 'pesticide/productClass/$1',
    'pesticide' => 'pesticide/index',

    'price-list/manufacture-([0-9]+)' => 'priceList/manufacture/$1',

    'substance/info/id-substance-([0-9]+)' => 'substance/info/$1',
    'substance/full-info/id-substance-([0-9]+)' => 'substance/fullInfo/$1',

	// Удобрения
    'fertiliser/fertiliser-group-([0-9]+)/fertiliser-class-([0-9]+)/element-([0-9]+)' => 'fertiliser/listByGroupAndClass/$1/$2/$3',
    'fertiliser/fertiliser-group-([0-9]+)/fertiliser-class-([0-9]+)' => 'fertiliser/listByGroupAndClass/$1/$2',
    'fertiliser/id-manufacture-([0-9]+)' => 'fertiliser/listByManufacture/$1',
    'fertiliser/id-([0-9]+)' => 'fertiliser/info/$1',
    'fertiliser' => 'fertiliser/index',

	'' => 'site/index',
);