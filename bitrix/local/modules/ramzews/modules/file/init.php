<?php
/** @return array Список подключаемых классов */

$classes = [];

/* Модели */
$models = [
    "CFileTable",
];

foreach ($models as $m) {
    $classes[] = "models/" . $m;
}

return $classes;