<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户组';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
            'id',
            'username',
            'email:email',
            // 'status',
            [
                'attribute' => 'status',
                'value'     => 'statusStr',
            ],
            // 'created_at',
            [
                'attribute' => 'created_at',
                'format'    => ['date', 'php:Y-m-d H:i:s'],
            ],
            // 'updated_at',
            [
                'attribute' => 'updated_at',
                'format'    => ['date', 'php:Y-m-d H:i:s'],
            ],

            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{update}',
            ],
        ],
    ]); ?>
</div>
