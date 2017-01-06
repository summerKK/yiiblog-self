<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CommentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '评论管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="comment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel'  => $searchModel,
        'columns'      => [
//            'id',
            [
                'attribute'      => 'id',
                'contentOptions' => ['width' => '30px'],
            ],
//            [
//                'attribute' => 'content',
//                'value'     => function($model) {
//                    $content = strip_tags($model->content);
//                    $contentLen = mb_strlen($content,'utf-8');
//                    return mb_substr($content,0,20,'utf-8') . ($contentLen > 20 ? '...' : '');
//                },
//            ],
            [
                'attribute' => 'content',
                'value'     => 'cutout',
            ],
            [
                'attribute'      => 'status',
                'value'          => 'status0.name',
                'filter'         => \common\models\Commentstatus::find()->select(['name', 'id'])->orderBy('position')->indexBy('id')->column(),
                'contentOptions' => function($model) {
                    return $model->status == 1 ? ['class' => 'bg-danger'] : [];
                },
            ],
            [
                'attribute' => 'create_time',
                'format'    => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'user.username',
                'value'     => 'user.username',
                'label'     => '作者',
            ],
//            'post_id',
            'post.title',
            [
                'class'    => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}{approve}',
                'buttons'  => [
                    'approve' => function($url, $model, $key) {
                        $options = [
                            'title' => Yii::t('yii', '审核'),
                            'aria-label' => Yii::t('yii','审核'),
                            'data-confirm' =>  Yii::t('yii','确定审核通过吗?'),
                            'data-method' => 'post',
                            'data-pajax' =>0,
                        ];
                        return Html::a('<span class="glyphicon glyphicon-check"></span>',$url,$options);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
