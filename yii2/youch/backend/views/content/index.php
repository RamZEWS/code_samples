<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\ContentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Contents';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="content-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Content', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
            'description:ntext',
            'user_id',
            'price_from',
            // 'price_to',
            // 'is_free',
            // 'date_from',
            // 'date_to',
            // 'phone',
            // 'site',
            // 'file_base_url:url',
            // 'file_url:url',
            // 'status',
            // 'city_id',
            // 'created_at',
            // 'updated_at',
            // 'rating',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
