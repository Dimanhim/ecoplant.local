<?php

return array(
    // Литературный источник
    'biblio/add' => 'biblio/add',
    'biblio/finish/([0-9]+)' => 'biblio/finish/$1',
    'biblio/collection/add' => 'biblio/collectionAdd',
    'biblio/link/add' => 'biblio/linkAdd',
    'biblio/author/add/([0-9]+)' => 'biblio/authorAdd/$1',

    // Биотаргет
    'biotarget/select' => 'biotarget/select',
    'biotarget/addToProduct/([0-9]+)' => 'biotarget/addToProduct/$1',

    // Объект
    'object/add' => 'object/add',
    // Редактор изображений объектов
    'object/image/post' => 'object/imagePost',
    'object/image/param' => 'object/imageParam',
    'object/image/publish' => 'object/imagePublish',
    'object/image/avatar' => 'object/imageAvatar',
    'object/image/delete' => 'object/imageDelete',
    'object/image/([0-9]+)' => 'object/image/$1',
    'object/image' => 'object/image',
    // Обработка изображений от пользователей
    'object/user-image' => 'object/userImage',
    // Группа объектов
    'object/group/add' => 'object/groupAdd',
    'object/group/select/([0-9]+)' => 'object/groupSelect/$1',
    'object/group/merge/regDataAndObjectGroup' => 'regData/getAndObjectGroup',
    'object/group/merge' => 'object/groupMerge',
    // Описание объекта
    'object/desc/get' => 'object/getInfo',
    'object/desc' => 'object/descEdit',

    // Вид
    'species/add' => 'species/add',

    // Препаративная форма
    'solution/add' => 'solution/add',
    'solution/delete' => 'solution/delete',

    // Производители
    'manufacture/add' => 'manufacture/add',
    'manufacture/delete' => 'manufacture/delete',

    // Препараты
    'product/addAndCulture' => 'product/addAndCulture',
    'product/add' => 'product/add',
    'product/price/date' => 'product/priceDate',
    'product/price/info' => 'product/priceInfo',
    'product/price' => 'product/price',
    'product/analog/select' => 'product/analogSelect',
    'product/analog/addAndCulture/([0-9]+)' => 'product/analogAddAndCulture/$1',

	// Регистрационные данные
    'regdata/add' => 'regData/add',
	'regdata/certification/add/([0-9]+)' => 'regData/addCertificates/$1',
	'regdata/certification' => 'regData/selectProductCertificates',
	'regdata/selectObject' => 'regData/selectObject',

    // Действующие вещества
    'substance/addToProduct' => 'substance/addToProduct',
    'substance/addToProductNext' => 'substance/addToProductNext',
    'substance/add' => 'substance/add',

	// Статистика
    'stat/today' => 'stat/today',
    'stat/yesterday' => 'stat/yesterday',
    'stat/month' => 'stat/month',
    'stat/year' => 'stat/year',
    'stat/region' => 'stat/region',

	// Группы пользователей
    'userGroup/user/edit/([0-9]+)' => 'userGroup/userEdit/$1',
    'userGroup/user/delete/([0-9]+)' => 'userGroup/userDelete/$1',
    'userGroup/user/add' => 'userGroup/userAdd',

    'userGroup/edit/([0-9]+)' => 'userGroup/edit/$1',
    'userGroup/delete/([0-9]+)' => 'userGroup/delete/$1',
    'userGroup/add' => 'userGroup/add',
    'userGroup' => 'userGroup/index',

	// Удобрения
    'fertiliser/add' => 'fertiliser/add',
    'fertiliser/regdata/add' => 'fertiliser/RegData',
    'fertiliser/element/add/([0-9]+)' => 'fertiliser/addElement/$1',
	'fertiliser/descAdv/add' => 'fertiliser/addDescAdv',
	'fertiliser/descAdv/get/([0-9]+)' => 'fertiliser/getDescAdv/$1',
	'fertiliser/desc/add' => 'fertiliser/addDesc',

	// Элемент
    'element/add' => 'element/add',

	// Авторизация/Выход
    'signIn' => 'user/signIn',
	'signOut' => 'user/signOut',

    // Главная
	'' => 'site/index',
);