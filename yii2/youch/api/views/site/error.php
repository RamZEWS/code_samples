<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Json;

echo Json::encode([
    'name' => $name,
    'msg' => $message
]);
?>
