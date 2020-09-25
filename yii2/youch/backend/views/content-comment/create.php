<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ContentComment */

$this->title = 'Create Content Comment';
$this->params['breadcrumbs'][] = ['label' => 'Content Comments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-comment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
