<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\ContentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="content-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'price_from') ?>

    <?php // echo $form->field($model, 'price_to') ?>

    <?php // echo $form->field($model, 'is_free') ?>

    <?php // echo $form->field($model, 'date_from') ?>

    <?php // echo $form->field($model, 'date_to') ?>

    <?php // echo $form->field($model, 'phone') ?>

    <?php // echo $form->field($model, 'site') ?>

    <?php // echo $form->field($model, 'file_base_url') ?>

    <?php // echo $form->field($model, 'file_url') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'city_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'rating') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
