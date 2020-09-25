<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ContentRating */

$this->title = 'Create Content Rating';
$this->params['breadcrumbs'][] = ['label' => 'Content Ratings', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-rating-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
