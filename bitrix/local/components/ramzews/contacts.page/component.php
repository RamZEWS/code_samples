<?php
if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) {
    die();
}

$arResult['CONTACTS'] = CContactTable::GetAll([], ['SORT' => 'ASC']);

$this->IncludeComponentTemplate();