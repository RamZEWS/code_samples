<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

$arResult['LIST'] = [];

$need_main = isset($arParams['NEED_MAIN']) ? $arParams['NEED_MAIN'] : true;
if ($need_main) {
    $arResult['LIST'][] = [
        'link' => '/',
        'name' => GetMessage('MAIN_PAGE'),
    ];
}

$list = isset($arParams['BREADCRUMBS']) ? $arParams['BREADCRUMBS'] : [];
foreach ($list as $l => $n) {
    $arResult['LIST'][] = [
        'link' => $l,
        'name' => $n,
    ];
}


$this->IncludeComponentTemplate();