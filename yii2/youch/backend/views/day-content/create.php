<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\WeekDayContent */

$this->title = 'Create Week Day Content';
$this->params['breadcrumbs'][] = ['label' => 'Week Day Contents', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="week-day-content-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
