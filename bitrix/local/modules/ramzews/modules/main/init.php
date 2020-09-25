<?php
/** @return array Список подключаемых классов */

$classes = [];

/* Модели */
$models = [
    "CModel"
];
foreach ($models as $m) {
    $classes[] = "models/".$m;
}

/* Хелперы */
$helpers = [
    "CAdminHelper",
];
foreach ($helpers as $m) {
    $classes[] = "helpers/".$m;
}

return $classes;