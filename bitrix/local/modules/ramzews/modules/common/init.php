<?php
/** @return array Список подключаемых классов */

$classes = [];

/* Модели */
$models = [
    "CContactTable",
];
foreach ($models as $m) {
    $classes[] = "models/" . $m;
}

return $classes;