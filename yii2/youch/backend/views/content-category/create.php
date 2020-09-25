<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ContentCategory */

$this->title = 'Create Content Category';
$this->params['breadcrumbs'][] = ['label' => 'Content Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-category-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
